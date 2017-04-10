<?php

$conn = require "../php/db_connect.php";
$stmt = $conn->prepare("SELECT * FROM subjects");
$success = $stmt->execute();

$course_id = filter_input(INPUT_GET, 'courseid', FILTER_VALIDATE_INT);
$course_lang = filter_input(INPUT_GET, 'lang');

$subjects = null;
if ($success) {
    $subjects = $stmt->fetchAll();
}

// Get course units start dates
$statement = $conn->prepare("SELECT start_date
    FROM course_units, course_to_unit, course_units_lng
    WHERE course_units.id = course_to_unit.unit_id
    AND course_units.id = course_units_lng.unit_id
    AND course_to_unit.course_id = :course_id
    AND course_units_lng.lang = :course_lang
    ");

$statement->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$statement->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

$success = $statement->execute();
if ($success) {
    $course_unit_dates = $statement->fetchAll(PDO::FETCH_ASSOC);
}

//if a course has already some units, find the last course unit start date
if(sizeof($course_unit_dates)>0){
    $date_picker_date = $course_unit_dates[0]['start_date'];
    foreach($course_unit_dates as $unit_start_date){
        if(strtotime($date_picker_date)<strtotime($unit_start_date['start_date'])){
            $date_picker_date = $unit_start_date['start_date'];
        }
    }
//if course hasn't any unit, set date to current date
}else{
    $date_picker_date = date('Y-m-d');
}

//set suggested start date for the new course unit to 1 week after start date of last unit or after 1 week from current date
$date_picker_date = date('Y-m-d',strtotime('+1 week',strtotime($date_picker_date)));

?>
<div id='courses'>
    <section class='container'>
        <br><br>
        <div class='container'>
            <div class='row'>
                <div class='col-md-10 col-md-offset-1'>

                    <!--- CREATE COURSE INPUT FORM -->
                    <form role="form" class="form-horizontal"
                    action="../php/upload_script_courseunit.php?course_id=<?php echo $course_id; ?>&course_lang=<?php echo $course_lang; ?>" method="post" enctype="multipart/form-data" id="UploadForm"> <!-- api/api.php/courses/ echo  . "/" . $course_lang . "/units -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="name">
                            <?php echo getTranslation("addcourseunit:content:name", "Course unit name:");?>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name"
                            placeholder="<?php echo getTranslation('addcourseunit:placeholder:name',
                            'Enter your course unit name'); ?>" required>
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
                            <input type="date" class="form-control" name="startdate" id="startdate" value = "<?php echo htmlentities($date_picker_date);?>"required>
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
