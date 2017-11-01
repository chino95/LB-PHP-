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
                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
        });

    return false;
}

function getTServicios() {
    $.post('main.php', { action: "get" },
        function(e) {
            if (e.data == true) {
                var cd = [{
                    targets: [0, 1],
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