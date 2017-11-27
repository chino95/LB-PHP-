$(document).ready(function() {
    Template.setTitle({ title: "Captura", "subtitle": "Usuarios" });
    getUsuarios();
});
$("#frm").validate({
    submitHandler: function(form) {
        newUsuario();
    }
});
$("#frmmod").validate({
    submitHandler: function(form) {
        updatUsuario();
    }
});
var idcc;

function getUsuarios() {
    $.post('main.php', { action: "get" },
        function(e) {
            if (e.data == true) {
                var cd = [{
                    targets: [0, 1, 2],
                    className: "print"
                }];
                initTable(e.r, e.c, $("#tbl"), cd);
            } else {
                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
        });
}

function MostrarModal(idc) {
    idcc = idc;
    $.post('main.php', { idc: idc, action: "getData" },
        function(e) {
            if (e.data == true) {
                console.log(e.r[0]);
                $('#mnombre').val(e.r[0]);
                $('#mcorreo').val(e.r[1]);
                $('#modalUpdate').modal();
            } else {
                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
        });

    return false;
}

function newUsuario() {
    var dtc = {
        cor: $("#correo").val(),
        psw: $("#psw").val(),
        nivel: 2
    };
    var dt = {
        idc: 0,
        ide: 0,
        nom: $("#nombre").val()
    };
    $.post('main.php', { dtc: dtc, dt: dt, action: "new" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Usuario Registrado', 'success');
                getUsuarios();
            } else {
                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
            $("#frm")[0].reset();
        });
    return false;
}

function updatUsuario() {
    var dtus = {
        idc: idcc,
        nom: $("#mnombre").val()

    };
    var dtcu = {
        idc: idcc,
        cor: $("#mcorreo").val(),
        psw: $("#mpsw").val()
    };
    $.post('main.php', { dtus: dtus, dtcu: dtcu, action: "update" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Usuario Modificado', 'success');
                getUsuarios();

            } else {
                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
            $("#frmmod")[0].reset();
            $('#modalUpdate').modal('toggle');
        });
    return false;
}