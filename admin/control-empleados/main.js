$(document).ready(function() {
    Template.setTitle({ title: "Captura", "subtitle": "Empleados" });
    getUsuarios();
});
$("#frm").validate({
    submitHandler: function(form) {
        newUsuarios();
    }
});
$("#frmmod").validate({
    submitHandler: function(form) {
        updatUsuario();
    }
});
var idm;

function MostrarModal(id) {
    idm = id;
    $.post('main.php', { id: id, action: "getData" },
        function(e) {
            if (e.data == true) {
                $('#mnombre').val(e.r[0]);
                $('#mcorreo').val(e.r[1]);
                $('#modalUpdate').modal();
            } else {
                showNotification('Error!', e.r, 'danger');
            }
        });

    return false;
}

function getUsuarios() {
    $.post('main.php', { action: "get" },
        function(e) {
            if (e.data == true) {
                initTable(e.r, e.c, $("#tbl"));
            } else {
                showNotification('Error!', e.r, 'danger');
            }
        });
}

function newUsuarios() {
    var dtcu = {
        cor: $("#correo").val(),
        psw: $("#psw").val()
    };
    var dtus = {
        id: 0,
        nom: $("#nombre").val()
    };
    $.post('main.php', { dtcu: dtcu, dtus: dtus, action: "new" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Usuario Registrado', 'success');
                getUsuarios();

            } else {
                showNotification('Error!', e.r, 'danger');
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
                getUsuarios();

            } else {
                showNotification('Error!', e.r, 'danger');
            }
            $("#frmmod")[0].reset();
            $('#modalUpdate').modal('toggle');
        });
    return false;
}