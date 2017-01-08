
// Adds onclick listeners to the yes/no confirm buttons on course deletion
$(document).ready(function () {

    // When clicking yes, remove course from database
    $("#btn-yes").on("click", function () {
        var courseId = URI().query(true).id;
        var courseLang = URI().query(true).lang;
        $.post("../php/delete_course.php", {
                "course_id": courseId,
                "course_lang": courseLang
        }, function (data) {
            if (data == "FALSE") {
                console.log("Error deleting course: " + data);
            } else {
                console.log("Course successfully deleted");
                window.location = "course_list.php?id=" + data + "&deleted=1";
            }
        });
    });

    // When clicking no, go back to page where user came from
    $("#btn-no").on("click", function () {
        window.location = document.referrer;
    });

});