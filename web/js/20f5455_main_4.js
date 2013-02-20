
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