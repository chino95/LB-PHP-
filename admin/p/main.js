$(document).ready(function() {
    Template.setTitle({ title: "Captura", "subtitle": "Empleados" });
    getEmpleados();
    get();
});
$("#frm").validate({
    submitHandler: function(form) {
        newEmpleado();
    }
});
$("#frmmod").validate({
    submitHandler: function(form) {
        updatUsuario();
    }
});
var idm;

function get() {
    $.post('main.php', { action: "getl" },
        function(e) {
            console.log(e);
        });
}

function getEmpleados() {
    $.post('main.php', { action: "get" },
        function(e) {
            if (e.data == true) {
                var cd = [{
                    targets: [0, 1, 2, 3, 4, 5, 6, 7],
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

function MostrarModal(id) {
    idm = id;
    $.post('main.php', { id: id, action: "getData" },
        function(e) {
            if (e.data == true) {
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

function newEmpleado() {
    var dt = {
        nom: $("#nombre").val(),
        appat: $("#appat").val(),
        dire: $("#dire").val(),
        tel: $("#telefono").val(),
        lice: $("#lice").val(),
        numlic: $("#numlic").val(),
        tipolic: $('#tipolic'),
        visa: $('#visa'),
        ife: $('#ife')
    };
    $.post('main.php', { dt: dt, action: "new" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Usuario Registrado', 'success');
                getEmpleados();

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
    var dataus = {
        id: idm,
        nom: $("#mnombre").val()

    };
    var datacu = {
        idcu: 0,
        cor: $("#mcorreo").val(),
        psw: $("#mpassword").val()
    };
    $.post('main.php', { dtus: dataus, dtcu: datacu, action: "update" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Usuario Modificado', 'success');
                getEmpleados();

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