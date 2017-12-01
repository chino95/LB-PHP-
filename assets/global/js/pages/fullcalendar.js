function runCalendar() {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var form = '';
    var today = new Date($.now());


    var calendar = $('#calendar').fullCalendar({
        defaultView: 'month',
        handleWindowResize: true,
        height: $(window).height() - 200,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: [{
            title: 'See John',
            start: today,
            end: today
        }],
        editable: false,
        droppable: false,
        eventLimit: true
    });
}

$(function() {
    runCalendar();
});