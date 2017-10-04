$(document).ready(function() {
    Template.setTitle({ title: "Captura", "subtitle": "Usuarios" });
    getMservicio();
});
$("#frm").validate({
    submitHandler: function(form) {
        newUsuarios();
    }
});
var idm;

function MostrarModal(id) {
    idm = id;
    $.post('main.php', { id: id, action: "getData" },
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
                showNotification('Error!', e.r, 'danger');
            }
        });

    return false;
}

function getMservicio() {
    $.post('main.php', { action: "get" },
        function(e) {
            if (e.data == true) {
                initTable(e.r, e.c, $("#tbl"));
            } else {
                showNotification('Error!', e.r, 'danger');
            }
        });
}