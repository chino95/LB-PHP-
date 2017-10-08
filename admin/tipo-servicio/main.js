$(document).ready(function() {
    Template.setTitle({ title: "Captura", "subtitle": "Tipos de Servicios" });
    getTServicios();
});
$("#frm").validate({
    submitHandler: function(form) {
        newTipoServicio();
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
                $('#mnservicio').val(e.r[0]);
                $('#modalUpdate').modal();
            } else {
                showNotification('Error!', e.r, 'danger');
            }
        });

    return false;
}

function getTServicios() {
    $.post('main.php', { action: "get" },
        function(e) {
            if (e.data == true) {
                initTable(e.r, e.c, $("#tbl"));
            } else {
                showNotification('Error!', e.r, 'danger');
            }
        });
}

function newTipoServicio() {
    var dt = {
        nom: $("#nservicio").val()
    };
    $.post('main.php', { dt: dt, action: "new" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Servicio Registrado', 'success');
                getTServicios();

            } else {
                showNotification('Error!', e.r, 'danger');
            }
            $("#frm")[0].reset();
        });
    return false;
}

function updatUsuario() {
    var dt = {
        id: idm,
        nom: $("#mnservicio").val()
    };
    $.post('main.php', { dt: dt, action: "update" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Servicio Modificado', 'success');
                getTServicios();

            } else {
                showNotification('Error!', e.r, 'danger');
            }
            $("#frmmod")[0].reset();
            $('#modalUpdate').modal('toggle');
        });
    return false;
}