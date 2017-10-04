$(document).ready(function() {

    $.post('../permisos/session.php', { action: 'check' }, function(e) {
        if (e.data) {
            Template.setUser(e.correo);
            $("#btnlogout1").click(logout);
            $("#btnlogout").click(logout);

            if (e.nivel == 0) {
                $.getJSON('../permisos/menuc.json', function(data, status, xhr) {
                    Template.setMenu(data);
                });
            } else {
                $.getJSON('../permisos/menu.json', function(data, status, xhr) {
                    Template.setMenu(data);
                });
            }

        } else {
            //logout();
        }
    });





    $.getJSON('../permisos/iconos.json', function(data, status, xhr) {
        Template.setIcons(data);
    });

    $("#logout").click(function() {
        window.location.replace("../../login");
    });
});

$.extend(jQuery.validator.messages, {
    required: "Este campo es Requerido.",
    email: "Favor de ingresar un Correo Válido.",
    maxlength: jQuery.validator.format("No mas de {0} caracteres."),
    minlength: jQuery.validator.format("Ingresar al menos {0} caracteres."),
    equalTo: "Favor de ingresar el mismo valor en ambas contraseñas.",
    max: jQuery.validator.format("El valor no puede ser mas de {0}."),
    min: jQuery.validator.format("El valor debe ser al menos {0}.")
});

function showNotification(textS, textN, typez) {
    var n = noty({
        text: '<div class="alert alert-' + typez + ' media fade in"><p><strong>' + textS + '</strong> ' + textN + '</p></div>',
        progressBar: true,
        type: typez,
        dismissQueue: true,
        layout: 'topRight',
        closeWith: ['click'],
        theme: 'made',
        maxVisible: 10,
        animation: {
            open: 'animated bounceIn',
            close: 'animated bounceOut',
            easing: 'swing',
            speed: 100
        },
        timeout: 3000,
        buttons: ''
    });
}



function initTable(ds, c, table, cd, footerCallback) {

    if (typeof cd === typeof undefined)
        cd = [];
    if (typeof footerCallback === typeof undefined)
        footerCallback = null;
    var oTable = table.dataTable({
        //sDom: "<'row'<'col-md-6'f><'col-md-6'T>r>t<'row'<'col-md-6'i><'spcol-md-6an6'p>>",
        destroy: true,
        autoWidth: false,
        data: ds,
        columns: c,
        columnDefs: cd,
        "language": {
            "aria": {
                "sortAscending": ": Orden Ascendente",
                "sortDescending": ": Orden Descendente"
            },
            "emptyTable": "No hay datos para mostrar",
            "info": "Mostrando _START_ hasta _END_ de _TOTAL_ registros",
            "infoEmpty": "No se encontraron registros",
            "infoFiltered": "(Filtrado desde _MAX_ registros totales)",
            "lengthMenu": "_MENU_",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron registros"
        },

        buttons: [
            { extend: 'print', className: 'btn btn-outline blue', text: 'IMPRIMIR', footer: table.find('tfoot').length, exportOptions: { columns: '.print' } },
            { extend: 'pdf', className: 'btn btn-outline red', text: 'PDF', footer: table.find('tfoot').length, exportOptions: { columns: '.pdf' } },
            { extend: 'excel', className: 'btn btn-outline green', text: 'EXCEL', footer: table.find('tfoot').length, exportOptions: { columns: '.excel' } },
            { extend: 'copy', className: 'btn btn-outline purple', text: 'COPIAR', footer: table.find('tfoot').length, exportOptions: { columns: '.copy' } }
        ],
        fnDrawCallback: function(oSettings) {
            //table.parent().parent().parent().parent().find('.export-options-container').append($('.exportOptions'));
            $('[data-toggle="tooltip"]').tooltip();
            $('#tbl_length select').select2();
        },
        footerCallback: footerCallback,
        responsive: true,
        "lengthMenu": [
            [10, 30, 50, 100, -1],
            [10, 30, 50, 100, "Todos"]
        ],
        "pageLength": 10

    });
}