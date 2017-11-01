$(document).ready(function() {
    Template.setTitle({ title: "Actualizar", "subtitle": "Status" });
    getServicios();
});
$("#frmNew").validate({
    submitHandler: function(form) {
        sentUpdate();
    }
});
var idm;

function VerServicio(id) {
    idm = id;

    $.post('main.php', { id: id, action: "getDataVer" },
        function(e) {
            if (e.data == true) {
                $('#modalVer').modal();

                initTable(e.r, e.c, $("#tablastatus"));
            } else {
                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
        });

    return false;
}


function UpdateServicio(id) {
    idm = id;
    $('#modalUpdate').modal();
    return false;
}

function getServicios() {
    $.post('main.php', { action: "get" },
        function(e) {
            if (e.data == true) {
                var cd = [{
                    targets: [0, 1, 2, 3],
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

function sentUpdate() {
    var dt = {
        id: idm,
        status: $("#status").val(),
        fecha: 0,
        ubi: $("#ubicacion").val()
    };
    $.post('main.php', { dt: dt, action: "sentUpdate" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Status Actualizado', 'success');
                getUsuarios();

            } else {
                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
            $('#modalUpdate').modal('toggle');
            $("#frmNew")[0].reset();
        });
    return false;
}


function FinServicio(id) {
    idm = id;
    $('#modalFin').modal();
    return false;
}


function MFinServicio() {
    var dt = {
        id: idm
    };
    $.post('main.php', { dt: dt, action: "FinServicio" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Servicio Finalizado', 'success');
                getServicios();
            } else {
                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
            $("#frmNew")[0].reset();
            $('#modalFin').modal('toggle');
        });
    return false;
}