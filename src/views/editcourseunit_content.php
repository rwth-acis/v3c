<?php

$conn = require "../php/db_connect.php";

$course_id = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT);
$unit_id = filter_input(INPUT_GET, 'uid', FILTER_VALIDATE_INT);
$unit_lang = filter_input(INPUT_GET, 'ulang');

// Get course info
$statement = $conn->prepare("SELECT *
                        FROM course_units, course_units_lng
                        WHERE course_units.id = :unit_id
                        AND course_units.id = course_units_lng.unit_id
                        AND course_units_lng.lang = (SELECT
                          IFNULL( (SELECT lang FROM course_units_lng WHERE lang = :unit_lang AND unit_id = :unit_id),
                          course_units.default_lang ))
                        LIMIT 1");

$statement->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
$statement->bindParam(":unit_lang", $unit_lang, PDO::PARAM_STR);

$success = $statement->execute();
if ($success) {
    $course_unit = $statement->fetch();
}
else {
  print_r($statement->errorInfo());
  die("error");
}

?>
<div id='courses'>
    <section class='container'>
        <br><br>
        <div class='container'>
            <div class='row'>
                <div class='col-md-10 col-md-offset-1'>

                    <!--- CREATE COURSE INPUT FORM -->
                    <form role="form" class="form-horizontal"
                          action="../php/edit_script_courseunit.php" method="post" enctype="multipart/form-data" id="UploadForm">

                        <input type="hidden" name="courseid" value="<?php echo $course_id; ?>">
                        <input type="hidden" name="unitid" value="<?php echo $unit_id; ?>">
                        <input type="hidden" name="unitlang" value="<?php echo $unit_lang; ?>">

                        <!--Course unit name-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">
                                <?php echo "Course unit name:";/*getTranslation("editcourseunit:edit:name", "Course unit name:");*/?>
                            </label>
                            <div class="col-sm-10">
                                <input type="hidden" name="targetId" value="<?php echo $unit_id; ?>">
                                <input type="text" class="form-control" name="title" id="targetName"
                                       value="<?php echo htmlentities($course_unit['title']); ?>" required>

                            </div>
                        </div>

                        <!--Course unit points-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="points">
                                <?php echo "ECVET Ponits";/*getTranslation("editcourseunit:edit:points", "ECVET Points:");*/?>
                            </label>
                            <div class="col-sm-10">
                                <input type="number" name="points" id="points" min="0" max="20"
                                       value="<?php echo htmlentities($course_unit['points']);?>" required>
                            </div>
                        </div>

                        <!--Course unit startdate-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="startdate">
                                <?php echo "Start Date:";/*getTranslation("editcourseunit:edit:startdate", "Start Date:");*/?>
                            </label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="startdate" id="startdate"
                                       value="<?php echo htmlentities($course_unit['start_date']);?>" required>
                            </div>
                        </div>

                        <!--Course unit description-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="description">
                                <?php echo "Description";/*getTranslation("editcourseunit:edit:description", "Description:");*/?>
                            </label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="3" name="description" id="description" placeholder="<?php echo "Enter course unit description";/*getTranslation('editcourseunit:placeholder:description', 'Enter course description');*/?>"><?php echo htmlentities($course_unit['description']);?></textarea>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-success btn-lg btn-block" id="SubmitButton"
                                value="Save"><?php echo "Save";/*getTranslation("general:button:save", "Save");*/?></button>
                    </form>
                    <div id="output"></div>
                    <br>
                </div>
            </div>
        </div>
    </section>
</div>
