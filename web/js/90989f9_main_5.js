
/*
 * Confirm Dialog
 */
function confirmDialog(content, title, callback)
{
    if ($("#dialogConfirm").length == 0) {
        $("body").prepend("<div id=\"dialogConfirm\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\">\
            <div class=\"modal-header\">\
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\">×</button>\
                <h3></h3>\
            </div>\
            <div class=\"modal-body\">\
                <p></p>\
            </div>\
            <div class=\"modal-footer\">\
                <button class=\"btn\" data-dismiss=\"modal\">No</button>\
                <button class=\"btn btn-primary\">Yes</button>\
            </div>\
        </div>");
        $("#dialogConfirm").modal({
            keyboard: false,
            show: false
        });
    }

    $("#dialogConfirm .modal-header h3").text(title);
    $("#dialogConfirm .modal-body p").text(content);
    $("#dialogConfirm .modal-footer .btn-primary").unbind("click").bind("click", function() {
        callback();
        $("#dialogConfirm").modal("hide");
        return false;
    });

    $("#dialogConfirm").modal("show");
}

/*
 * Update the Station Statistics on the page such as the current track and station uptime
 */
function updateStats()
{
    $.getJSON(Routing.generate("dj_panel_api_station_info"), function(d) {
        if (d.onAir) {
            $("#station-nowplaying-title").text(d.nowPlaying.title);
            $("#station-nowplaying-artist").text(d.nowPlaying.artist);
            if (!$("#station-onair").text("On Air").hasClass("label-success")) {
                $("#station-onair").addClass("label-success");
            }
        } else {
            $("#station-nowplaying-title").text("...");
            $("#station-nowplaying-artist").text("...");
            if ($("#station-onair").text("Off Air").hasClass("label-success")) {
                $("#station-onair").removeClass("label-success");
            }
        }
    });
}

$(function() {

    // Update Server Time
    setInterval(function() {
        ServerTime.setSeconds(ServerTime.getSeconds() + 1);

        // Update Server Time Label
        $("#station-time").text(moment(ServerTime.toISOString()).format("HH:mm:ss"));
    }, 1000);

    // Keep Updating the Stats
    updateStats();
    setInterval(function() { updateStats(); }, 5000);

});