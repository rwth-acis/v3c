<?php

$conn = require_once "../php/db_connect.php";
$stmt = $conn->prepare("SELECT * FROM subjects");
$success = $stmt->execute();

$course_id = filter_input(INPUT_GET, 'courseid', FILTER_VALIDATE_INT);
$course_lang = filter_input(INPUT_GET, 'lang');

$subjects = null;
if ($success) {
    $subjects = $stmt->fetchAll();
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
                          action="../api/api.php/courses/<?php echo $course_id . "/" . $course_lang . "/units"?>" method="post" enctype="multipart/form-data" id="UploadForm">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">
                                <?php echo getTranslation("addcourseunit:content:name", "Course unit name:");?>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="<?php echo getTranslation('addcourseunit:placeholder:name', 'Enter your course unit name');?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="points">
                                <?php echo getTranslation("addcourseunit:content:points", "ECVET Points:");?>
                            </label>
                            <div class="col-sm-10">
                                <input type="number" name="points" id="points" min="0" max="20" value="5">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="startdate"><?php echo getTranslation("addcourseunit:content:startdate", "Start Date:");?></label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="startdate" id="startdate"
                                       placeholder="<?php echo getTranslation('addcourseunit:placeholder:startdate', 'Start Date:');?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="description"><?php echo getTranslation("addcourseunit:content:description", "Description:");?></label>
                            <div class="col-sm-10">
                <textarea class="form-control" rows="3" name="description" id="description"
                          placeholder="<?php echo getTranslation('addcourseunit:placeholder:description', 'Enter course description');?>"></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="courseid" value="<?php echo $course_id; ?>">
                        <input type="hidden" name="courselang" value="<?php echo $course_lang; ?>">

                        <button type="submit" class="btn btn-success btn-lg btn-block" id="SubmitButton"
                                value="Save"><?php echo getTranslation("general:button:save", "Save");?></button>
                    </form>
                    <div id="output"></div>
                    <br>
                </div>
            </div>
        </div>
    </section>
</div>
