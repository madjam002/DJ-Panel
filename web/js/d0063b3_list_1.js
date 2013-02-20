$(function() {
    $(".btn-delete-show").click(function() {
        var showId = $(this).parents("tr").attr("data-showid");
        confirmDialog("Are you sure you want to delete this show?", "Confirmation", function() {
            $.post("/app_dev.php/api/show/delete", { showId: showId }, function(d) {
                alert(d);
            });
        });
        return false;
    });
});