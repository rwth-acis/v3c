<?php
$course_id = filter_input(INPUT_GET, 'cid');
$course_lang = filter_input(INPUT_GET, 'ulang');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='X-UA-Compatible' content='IE=edge' charset='utf8'/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Your Course</title>

    <!-- Additional styles -->
    <link rel="stylesheet" href="../css/editcourse.css">

</head>

<body>
    <?php include "menu.php"; ?>

    <script>
        function updateQueryStringParameter(uri, key, value) {
          var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
          var separator = uri.indexOf('?') !== -1 ? "&" : "?";
          if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        }
        else {
            return uri + separator + key + "=" + value;
        }
    }

    $( document ).ready(function() {
        var sel = document.getElementById('change-lang');
        sel.onchange = function() {
          var show = document.getElementById('change-lang');
          window.location.href = updateQueryStringParameter(document.URL,"ulang",show.value);
      }
  });

</script>

<header id='head' class='secondary'>
    <div class='container'>
        <div class='row'>
            <h1><?php echo getTranslation("editcourse:head:edit", "Edit Your Course");?>
                <select class="form-control" name="change-lang" id="change-lang" style="width: 150px; float: right" >
                    <?php
                    $languages = getSelectableLanguages();
                    foreach ($languages as $code => $language) {
                        $selected = ($course_lang == $code) ? "selected" : "";

                        echo "<option class='flag flag-$code' value='$code' $selected>$language</option>";
                    }
                    ?>
                </select>
            </h1>
        </div>
    </div>
</header>
<?php
// Check whether the currently logged in user is allowed to edit courses
require '../php/access_control.php';

$accessControl = new AccessControl();

$canEditCourse = $accessControl->canUpdateCourse($course_id);

if ($canEditCourse) {
    include 'editcourseunit_content.php';
} else {
    include 'not_authorized.php';
}


include("footer.php");
?>

</body>
</html>
