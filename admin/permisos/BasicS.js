$(document).ready(function() {
    $.post('../permisos/session.php', { action: 'check' }, function(e) {
        if (e.data) {
            //  Template.setUser(e.nickname);
            // $("#lblname").text(e.nickname);
            $("#btnlogout1").click(logout);
            $("#btnlogout").click(logout);
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