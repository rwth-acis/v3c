<?php

$conn = require '../php/db_connect.php';

$course_id = filter_input(INPUT_GET, 'id');
$course_lang = filter_input(INPUT_GET, 'lang');

// Get course units
$stmt = $conn->prepare("SELECT course_units.*, course_units_lng.*
    FROM course_to_unit, course_units, course_units_lng
    WHERE course_to_unit.unit_id = course_units.id
    AND course_to_unit.course_id = :course_id
    AND course_units.id = course_units_lng.unit_id
    AND course_units_lng.lang = (SELECT
    IFNULL( (SELECT lang FROM course_units_lng
    WHERE course_units_lng.unit_id = course_to_unit.unit_id AND course_units_lng.lang = :course_lang),
    course_units.default_lang ))
    ");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

$success = $stmt->execute();
if ($success) {
    $course_units = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else {
  print_r( $stmt->errorInfo() );
}

// Get course info
$stmt = $conn->prepare("SELECT courses.*, courses_lng.*
  FROM courses, courses_lng
  WHERE courses.id = :course_id
  AND courses_lng.course_id = courses.id
  AND (courses_lng.lang = :course_lang OR courses_lng.lang = (SELECT default_lang FROM courses WHERE id = :course_id))");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

$success = $stmt->execute();
if (!$success) {
    echo "Error loading course.";
} else {
    $course = $stmt->fetchAll();
    if (sizeof($course) == 1 || $course[0]['lang'] == $course_lang) {
      $course = $course[0];
  }
  else {
      $course = $course[1];
  }
}


// Get subjects
$stmt3 = $conn->prepare("SELECT id, name
    FROM subjects");


$success = $stmt3->execute();
if ($success) {
    $subjects = $stmt3->fetchAll();
}


?>
<div id='courses'>
    <section class='container'>
        <br><br>
        <div class='container'>
            <div class='row'>
                <div class='col-md-10 col-md-offset-1'>

                    <form role="form"
                    action="../php/edit_script_course.php?courseid=<?php echo $course_id . "&courselang=" . $course_lang ?>" method="post" enctype="multipart/form-data" id="UploadForm"> <!-- ../api/api.php/courses/<?php echo $course_id . "/" . $course_lang ?> -->
                    <input type="hidden" name="_METHOD" value="PUT"/>
                    <input type="hidden" name="courseid" value="<?php echo $course_id; ?>">
                    <input type="hidden" name="courselang" value="<?php echo $course_lang; ?>">

                    <!-- COURSE NAME -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="targetName"><?php echo getTranslation("editcourse:edit:name", "Course name:");?></label>
                        <div class="col-sm-10">
                            <input type="hidden" name="targetId" value="<?php echo $course_id; ?>">
                            <input type="text" class="form-control" name="name" id="targetName"
                            value="<?php echo htmlentities($course['name']); ?>" required>
                        </div>
                    </div>

                    <!-- COURSE DOMAIN-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="targetDomain"><?php echo getTranslation("addcourse:content:domain", "Course Domain:");?></label>
                        <div class="col-sm-10">
                            <select class="form-control" name="domain" id="domain">
                                <?php
                                    // Get subjects
                                $subjects = $conn->query("SELECT subjects.* FROM subjects")->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($subjects as $subject) {
                                    $id = $subject["id"];
                                    $name = $subject["name"];
                                    $selected = ( $id == $course['domain']) ? "selected" : "";
                                    echo "<option value='$id' $selected>$name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- COURSE PROFESSION -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="targetProfession"><?php echo getTranslation("editcourse:edit:profession", "Course Profession:");?></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="profession" id="targetProfession"
                            value="<?php echo htmlentities($course['profession']); ?>" required>
                        </div>
                    </div>

                    <!-- COURSE DESCRIPTION -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="targetText"><?php echo getTranslation("editcourse:edit:description", "Description:");?></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" name="description" id="description"
                            placeholder="Enter course description"><?php echo htmlentities($course['description']); ?></textarea>
                        </div>
                    </div>

                    <h3>Course Units</h3>
                    <div class="form-group row">
                        <ul class="list-group">
                            <!-- List element for each course unit is created -->
                            <?php foreach($course_units as $course_unit): ?>

                                <?php $unit_id = $course_unit["id"]; ?>

                                <li data-toggle="collapse" data-target="#<?php echo $course_unit["id"] ?>" href="#" class="hover-click list-group-item clearfix">
                                    <span class="glyphicon glyphicon-book margin-right"></span>
                                    <?php echo $course_unit["title"] ?>
                                    <span class="pull-right">
                                        <span class="glyphicon glyphicon-calendar margin-right"></span>
                                        <?php echo $course_unit["start_date"] ?>
                                        <a href="/src/views/editcourseunit_info.php?cid=<?php echo $course_id?>&uid=<?php echo $course_unit["id"]; ?>&ulang=<?php echo $course_lang; ?>" class="margin-left btn btn-xs btn-success">
                                            Edit
                                        </a>
                                        <a href="/src/views/editcourseunit.php?cid=<?php echo $course_id; ?>&uid=<?php echo $course_unit["id"]; ?>&ulang=<?php echo $course_lang; ?>"
                                         class="margin-left btn btn-xs btn-warning">
                                         <?php echo getTranslation("course:content:editunit", "Design learning environment");?>
                                     </a>
                                 </span>
                             </li>
                             <div id="<?php echo $unit_id ?>" class="collapse">
                                <div class="margin-top margin-left">
                                    <?php echo $course_unit["description"] ?>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse">
                                    <div class="panel-body">Panel Body</div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <a href="/src/views/addcourseunit.php?courseid=<?php echo $course_id; ?>&lang=<?php echo $course_lang; ?>" class="btn btn-success">+ <?php echo getTranslation("editcourseunit:edit:addunit", "Add Course Unit");?></a>

        <button type="submit" class="btn btn-success btn-lg btn-block" id="SubmitButton" value="Save">
            <?php echo getTranslation("general:button:save", "Save");?>
        </button>
    </form>
    <br>
</div>
</div>
</div>
</section>
</div>
<!-- container -->
