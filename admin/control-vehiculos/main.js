$(document).ready(function() {
    Template.setTitle({ title: "Captura", "subtitle": "Vehiculos" });
    getVehiculo();
});
$("#frm").validate({
    submitHandler: function(form) {
        newVehiculo();
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
                $("#mmarca").val(e.r[0]),
                    $("#mmodelo").val(e.r[1]),
                    $("#mserie").val(e.r[2]),
                    $("#mtipov").val(e.r[3]),
                    $('#mplacamex').val(e.r[4]),
                    $('#mplacausa').val(e.r[5]),
                    $('#mclavevehi').val(e.r[6]),
                    $('#mnumeco').val(e.r[7]),
                    $('#mcapcar').val(e.r[8]),
                    $('#mcapvol').val(e.r[9]),
                    $('#mmedidas').val(e.r[10])

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

function getVehiculo() {
    $.post('main.php', { action: "get" },
        function(e) {
            if (e.data == true) {
                var cd = [{
                    targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
    return false;
}

function newVehiculo() {
    var dt = {
        marca: $("#marca").val(),
        modelo: $("#modelo").val(),
        serie: $("#serie").val(),
        tipov: $("#tipov").val(),
        placam: $('#placamex').val(),
        placau: $('#placausa').val(),
        clavev: $('#clavevehi').val(),
        numeco: $('#numeco').val(),
        capcar: $('#capcar').val(),
        capvol: $('#capvol').val(),
        medidas: $('#medidas').val()
    };
    $.post('main.php', { dt: dt, action: "new" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Vehiculo Registrado', 'success');
                getVehiculo();

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
        marca: $("#mmarca").val(),
        modelo: $("#mmodelo").val(),
        serie: $("#mserie").val(),
        tipov: $("#mtipov").val(),
        placam: $('#mplacamex').val(),
        placau: $('#mplacausa').val(),
        clavev: $('#mclavevehi').val(),
        numeco: $('#mnumeco').val(),
        capcar: $('#mcapcar').val(),
        capvol: $('#mcapvol').val(),
        medidas: $('#mmedidas').val()
    };
    $.post('main.php', { dt: dt, action: "update" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Vehiculo Modificado', 'success');
                getVehiculo();

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