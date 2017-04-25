<?php
$conn = require '../php/db_connect.php';

$course_id = filter_input(INPUT_GET, 'id');
$course_lang = filter_input(INPUT_GET, 'lang');

$tab = filter_input(INPUT_GET, 'tab');

if ($tab == "") {
  $tab = "progress";
}

?>

<section class='container'>
  <ul class="nav nav-tabs">
    <li<?php echo $tab=='progress' ? ' class="active"' : '' ?>><a href="?id=<?php echo $course_id ?>&lang=<?php echo $course_lang ?>&tab=progress">Progress</a></li>
    <li<?php echo $tab=='activity' ? ' class="active"' : '' ?>><a href="?id=<?php echo $course_id ?>&lang=<?php echo $course_lang ?>&tab=activity">Activity</a></li>
  </ul>

  <div class='container'>
    <?php include("courseanalytics_tab_".$tab.".php") ?>
  </div>
</section>
