$(document).ready(function() {
    Template.setTitle({ title: "Captura", "subtitle": "Clientes" });
    getUsuarios();
});
$("#frmmod").validate({
    submitHandler: function(form) {
        updatUsuario();
    }
});
var idcl;
var idcu;

function MostrarModal(idCliente, idCuenta) {
    idcl = idCliente;
    idcu = idCuenta;
    $.post('main.php', { id: idcl, action: "getData" },
        function(e) {
            if (e.data == true) {
                $('#ncontacto').val(e.r[0]);
                $('#nempresa').val(e.r[1]);
                $('#ndireccion').val(e.r[2]);
                $('#ntelefono').val(e.r[3]);
                $('#nctpat').val(e.r[4]);
                $('#ncorreo').val(e.r[5]);

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

function getUsuarios() {
    $.post('main.php', { action: "get" },
        function(e) {
            if (e.data == true) {
                var cd = [{
                    targets: [0, 1, 2, 3, 4, 5],
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

function updatUsuario() {
    var ctpatc = $('#nctpat').val();
    if (ctpatc == '' || ctpatc == '0') {
        ctpatc = 0;
    }
    var dtcl = {
        idcl: idcl,
        contacto: $("#ncontacto").val(),
        empresa: $("#nempresa").val(),
        dire: $("#ndireccion").val(),
        tel: $('#ntelefono').val(),
        ctpat: ctpatc
    };
    var dtcu = {
        id: idcu,
        cor: $("#ncorreo").val(),
        psw: $("#npsw").val()
    };
    $.post('main.php', { dtcl: dtcl, dtcu: dtcu, action: "update" },
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