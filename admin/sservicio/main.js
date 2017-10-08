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
                console.log(e.r)
                for (var i = e.r.length - 1; i >= 0; i--) {
                    console.log(i)
                    $('#tipos').html('<option>' + e.r[1][i] + '</option>');
                }
            } else {
                showNotification('Error!', e.r, 'danger');
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
        // tipos: $("#tipos").val(),
        foraneo: fora,
        tipoe: $("#tipoe").val(),
        origen: $("#origen").val(),
        destino: $("#destino").val(),
        peso: $("#peso").val(),
        bultos: $("#bultos").val(),
        fecha: $("#fecha").val(),
        hora: $("#hora").val(),
        comentario: $("#comenta").val()
    };
    $.post('main.php', { dt: dt, action: "new" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Servicio Solicitado', 'success');
                clean();
            } else {
                showNotification('Error!', e.r, 'danger');
            }
            $("#frm")[0].reset();
        });
    return false;
}