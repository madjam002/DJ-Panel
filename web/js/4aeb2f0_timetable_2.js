$(function() {

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var timetable = $("#timetable").fullCalendar({
        events: "./timetable/getjson",
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'agendaWeek,agendaDay'
        },
        //height: 999999999,
        firstDay: 1,
        firstHour: 9,
        defaultView: "agendaWeek",
        allDaySlot: false,
        selectable: true,
        selectHelper: true,
        unselectAuto: false,
        select: function(start, end, allDay) {
            $("#timetable-popover-edit").hide();
            $("#timetable-popover-edit .btn-delete").unbind("click");
            $("#timetable-popover-create").show()
                .css("top", $("#timetable .fc-select-helper").offset().top - $("#timetable").offset().top +
                    ($("#timetable .fc-select-helper").height() / 2) - ($("#timetable-popover-create").height() / 2))
                .css("left", $("#timetable .fc-select-helper").offset().left - $("#timetable").offset().left - $("#timetable-popover-create").width());

            $("#timetable-popover-create button[type=submit]").bind("click", function() {
                $.post("./timetable/book", { show: $("#timetable-popover-create select").val(), startDate: start.toISOString(), endDate: end.toISOString() }, function(d) {
                    if (d.status == "SUCCESS") {
                        timetable.fullCalendar('refetchEvents');
                    } else {
                        timetable.fullCalendar('unselect');
                    }
                }, "json");
                $(this).attr("disabled", "1");
            });
        },
        unselect: function() {
            $("#timetable-popover-create").hide();
            $("#timetable-popover-create button[type=submit]").unbind("click").removeAttr("disabled");
        },
        eventClick: function(event) {
            timetable.fullCalendar('unselect');
            $("#timetable-popover-edit").show()
                .css("top", $(this).offset().top - $("#timetable").offset().top +
                    ($(this).height() / 2) - ($("#timetable-popover-edit").height() / 2))
                .css("left", $(this).offset().left - $("#timetable").offset().left - $("#timetable-popover-edit").width());
            $("#timetable-popover-edit .btn-delete").unbind("click").bind("click", function() {
                $.post("./timetable/unbook", { booking: event.id }, function(d) {
                    if (d.status == "SUCCESS") {
                        timetable.fullCalendar("removeEvents", event.id);
                        $("#timetable-popover-edit").hide();
                    }
                    $("#timetable-popover-edit .btn-delete").removeAttr("disabled");
                }, "json");
                $(this).unbind("click").attr("disabled", "1");
            });
            return false;
        },
        viewDisplay: function() {
            $("#timetable-popover-edit").hide();
            $("#timetable-popover-edit .btn-delete").unbind("click");
        },
        loading: function(isLoading) {
            if (isLoading == false) {
                timetable.fullCalendar('unselect');
            }
        },
        editable: false
    });

    $("#timetable-popover-create button[type=button]").click(function() {
        timetable.fullCalendar("unselect");
    });

    $("#timetable-popover-edit .btn-cancel").click(function() {
        $("#timetable-popover-edit").hide();
    });


});