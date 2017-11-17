$(document).ready(function() {
    $.post('../permisos/session.php', { action: 'check' }, function(e) {
        if (e.data) {
            checkPage(e.nivel);
            $("#btnlogout1").click(logout);
            $("#btnlogout").click(logout);
            $("#logout").click(logout);
        } else {
            logout();
        }
    });
});

function logout() {
    $.post('../permisos/session.php', { action: 'logout' },
        function(e) {
            window.location.replace("../../login");
        });
}

function checkPage(role) {
    var path = window.location.toString().split('/');
    var page = path[path.length - 2];
    console.log("role: " + role);
    console.log("path: " + path);
    console.log("page: " + page);
    switch (page) {
        case 'sservicio':
            if (role != 0)
                window.location.replace("../../login");
            break;
        case 'cupdate-status':
            if (role != 0)
                window.location.replace("../../login");
            break;
        case 'cshistorial':
            if (role != 0)
                window.location.replace("../../login");
            break;
        case 'control-clientes':
            if (role != 1)
                window.location.replace("../../login");
            break;
        case 'control-usuarios':
            if (role != 1)
                window.location.replace("../../login");
            break;
        case 'control-empleados':
            if (role != 1)
                window.location.replace("../../login");
            break;
        case 'control-vehiculos':
            if (role != 1)
                window.location.replace("../../login");
            break;
        case 'tipo-servicio':
            if (role != 1)
                window.location.replace("../../login");
            break;
        case 'mservicio':
            if (role != 1)
                window.location.replace("../../login");
            break;
        case 'update-status':
            if (role != 1)
                window.location.replace("../../login");
            break;
        case 'shistorial':
            if (role != 1)
                window.location.replace("../../login");
            break;
        default:
            break;
    }
}