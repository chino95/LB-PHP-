$(document).ready(function() {
    Template.setTitle({
        title: "Ver",
        "subtitle": "Historial"
    });
    getMservicio();
});
$("#frm").validate({
    submitHandler: function(form) {
        AceptarSolicitud();
    }
});
$("#frmre").validate({
    submitHandler: function(form) {
        RechazarSolicitud();
    }
});

var idm;

function AceptarSolicitud() {
    var dt = {
        idser: idm,
        emp: $("select[name='emp'] option:selected").index(),
        veh: $("select[name='veh'] option:selected").index(),
        precio: $('#precio').val()
    };
    $.post('main.php', {
            dt: dt,
            action: "aceptarsoli"
        },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Solicitud Aceptada', 'success');
                getMservicio();
            } else {
                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
            $('#modalVer').modal('toggle');
            $("#frm")[0].reset();
        });
    return false;
}

function VerRecha(id) {
    idm = id;
    $('#modalRe').modal();
    return false;
}

function RechazarSolicitud() {
    var dt = {
        idser: idm
    };
    $.post('main.php', {
            dt: dt,
            action: "rechazarsoli"
        },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Solicitud Rechazada', 'warning');
                getMservicio();
            } else {
                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
            $('#modalRe').modal('toggle');
            $("#frm")[0].reset();
        });
    return false;
}

function getMservicio() {
    $.post('main.php', {
            action: "get"
        },
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

function VerServicio(id) {
    idm = id;
    $.post('main.php', {
            id: id,
            action: "getData"
        },
        function(e) {
            if (e.data == true) {
                var tabla = '<tr><th>Empresa</th><th>Fecha</th><th>Hora</th><th>Foraneo</th><th>Tipo de Carga</th><th>Origen</th><th>Destino</th><th>Peso</th><th>Bultos</th><th>Comentarios</th></tr>';
                tabla += '<tr><td>' + e.r[0] + '</td><td>' + e.r[1] + '</td><td>' + e.r[2] + '</td><td>' + e.r[3] + '</td><td>' + e.r[4] + '</td><td>' + e.r[5] + '</td><td>' + e.r[6] + '</td><td>' + e.r[7] + '</td><td>' + e.r[8] + '</td><td>' + e.r[9] + '</td></tr>';
                tabla += '</td></tr>';
                $('#tablaDetalle').html(tabla);
                getEmpVeh();
                $('#modalVer').modal();
            } else {

                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
        });
    return false;
}


function getEmpVeh() {
    $.post('main.php', {
            action: "getEmpVeh"
        },
        function(e) {
            if (e.data == true) {
                $('#emp').html(e.e);
                $('#veh').html(e.v);
            } else {
                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
        });
    return false;
}