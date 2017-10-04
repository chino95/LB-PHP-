var Template = function() {
    var AppName = "Logistica Balderrama";

    var renderMenu = function(app) {
        $.get('../permisos/menu.html', function(template) {
            var rendered = Mustache.render(template, app);
            $('#menu').html(rendered);
        });
    };
    var renderTitle = function(app) {
        $("title").html(AppName + "|" + app.title + "|" + app.subtitle);
        $(".header").html('<h2><strong>' + app.title + '</strong>  <small>' + app.subtitle + '</small></h2>');
    };
    var renderUser = function(app) {
        $(".usr-dt").html(app);
    };
    var renderIcons = function(app) {
        $.get('../permisos/iconos.html', function(template) {
            var rendered = Mustache.render(template, app);
            $('.nav-icons').append(rendered);
            $('[data-rel="tooltip"]').tooltip();
        });
    };

    return {
        setMenu: function(menu) {
            renderMenu(menu);
        },
        setTitle: function(title) {
            renderTitle(title);
        },
        setUser: function(user) {
            renderUser(user);
        },
        setIcons: function(icons) {
            renderIcons(icons);
        }
    };
}();