<?php

$conn = require '../php/db_connect.php';

$course_id = filter_input(INPUT_GET, 'id');
$course_lang = filter_input(INPUT_GET, 'lang');

// Get course units
$stmt = $conn->prepare("SELECT course_units.*
                        FROM courses 
                        JOIN course_to_unit 
                        ON courses.id = course_to_unit.course_id 
                          AND courses.lang = course_to_unit.course_lang
                        JOIN course_units 
                        ON course_to_unit.unit_id = course_units.id 
                          AND course_to_unit.unit_lang = course_units.lang
                        WHERE courses.id = :course_id
                          AND course_units.lang = :course_lang");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

$success = $stmt->execute();
if ($success) {
    $course_units = $stmt->fetchAll();
}

// Get course info
$stmt2 = $conn->prepare("SELECT courses.*
                        FROM courses 
                        WHERE courses.id = :course_id
                          AND courses.lang = :course_lang
                        LIMIT 1");

$stmt2->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt2->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

$success = $stmt2->execute();
if ($success) {
    $course = $stmt2->fetch();
}

?>

<div id='courses'>
    <section class='container'>
        <br><br>
        <div class='container'>
            <div class='row'>
                <div class='col-md-10 col-md-offset-1'>

                    <form role="form"
                          action="../php/edit_script_course.php" method="post" enctype="multipart/form-data" id="UploadForm">

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

                                    // Getsubjects
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
                                            <a href="/src/views/editcourseunit_info.php?cid=<?php echo $course_id?>&uid=<?php echo $course_unit["id"]; ?>&ulang=<?php echo $course_unit["lang"] ?>" class="margin-left btn btn-xs btn-success">
                                                Edit
                                            </a>
                                            <a href="/src/views/editcourseunit.php?id=<?php echo $course_id; ?>&lang=<?php echo $course_unit["lang"] ?>" class="margin-left btn btn-xs btn-warning">
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

                        <?php if (count($course_units) < 5): ?>
                        <a href="/src/views/addcourseunit.php?courseid=<?php echo $course_id; ?>&lang=<?php echo $course_lang; ?>" class="btn btn-success">+ <?php echo getTranslation("editcourseunit:edit:addunit", "Add Course Unit");?></a>
                        <?php endif; ?>

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
