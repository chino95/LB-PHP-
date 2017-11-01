$(document).ready(function() {
    Template.setTitle({ title: "Solicitar", "subtitle": "Servicio" });
    getTServicio();
});
$("#frm").validate({
    submitHandler: function(form) {
        newSolicitud();
    }
});

function clean() {
    $("#tipos").val('');
    $("#foraneo").val('');
    $("#tipoe").val('');
    $("#origen").val('');
    $("#destino").val('');
    $("#fecha").val('');
    $("#hora").val('');
    $("#comenta").val('');
}

function getTServicio() {
    $.post('main.php', { action: "getTServicio" },
        function(e) {
            if (e.data == true) {
                $('#tipos').html(e.l);
            } else {
                if (e.error == true)
                    showNotification('Error!', e.r, 'danger');
                else
                    showNotification('Aviso!', 'No hay datos para mostrar', 'warning');
            }
        });
    return false;
}

var fora;

function newSolicitud() {
    if ($('#foraneo').val() == 'Si') {
        fora = 1;
    } else {
        fora = 0;
    }
    var dt = {
        idcliente: 0,
        tipos: $("select[name='CCards'] option:selected").index(),
        foraneo: fora,
        tipoe: $("#tipoe").val(),
        origen: $("#origen").val(),
        destino: $("#destino").val(),
        peso: $("#peso").val(),
        pesom: $("#pesom").val(),
        bultos: $("#bultos").val(),
        bultosm: $("#bultosm").val(),
        fecha: $("#fecha").val(),
        hora: $("#hora").val(),
        comentario: $("#comenta").val(),
        status: 'Solicitado'
    };
    $.post('main.php', { dt: dt, action: "new" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Servicio Solicitado', 'success');
                clean();
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