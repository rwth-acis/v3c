<?php

$conn = require_once "../php/db_connect.php";
$stmt = $conn->prepare("SELECT * FROM subjects");
$success = $stmt->execute();

$subjects = null;
if ($success) {
    $subjects = $stmt->fetchAll();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $string = "?id=".$id;
}

$upload_script_url = "../php/upload_script_course.php{$string}";

?>
<div id='courses'>
    <section class='container'>
        <br><br>
        <div class='container'>
            <div class='row'>
                <div class='col-md-10 col-md-offset-1'>

                    <!--- CREATE COURSE INPUT FORM -->
                    <form role="form" class="form-horizontal"
                          action="<?php echo $upload_script_url?>" method="post" enctype="multipart/form-data" id="UploadForm">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="targetName">
                                <?php echo getTranslation("addcourse:content:name", "Course name:");?>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="targetName"
                                       placeholder="<?php echo getTranslation('addcourse:placeholder:name', 'Enter your course name');?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="language">
                                <?php echo getTranslation("addcourse:content:language", "Course language:");?>
                            </label>
                            <div class="col-sm-10">

                                <!-- TODO: Refactor (extract method) to display such language select elements -->
                                <select class="form-control" name="language" id="language">
                                    <?php
                                    $languages = array(
                                        "en" => "English",
                                        "de" => "Deutsch",
                                        "es" => "Español",
                                        "it" => "Italiano",
                                        "gr" => "ελληνικά"
                                    );
                                    foreach ($languages as $code => $language) {
                                        $selected = ($_SESSION["lang"] == $code) ? "selected" : "";
                                        echo "<option class='flag flag-$code' value='$code' $selected>$language</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="targetDomain"><?php echo getTranslation("addcourse:content:domain", "Course Domain:");?></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="domain" id="domain">
                                    <?php
                                    foreach ($subjects as $subject) {
                                        $id = $subject["id"];
                                        $name = $subject["name"];
                                        echo "<option value='$id'>$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="targetProfession"><?php echo getTranslation("addcourse:content:profession", "Course Profession:");?></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="profession" id="targetProfession"
                                       placeholder="<?php echo getTranslation('addcourse:placeholder:profession', 'Enter your course profession');?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="description"><?php echo getTranslation("addcourse:content:desription", "Description:");?></label>
                            <div class="col-sm-10">
                <textarea class="form-control" rows="3" name="description" id="description"
                          placeholder="<?php echo getTranslation('addcourse:placeholder:description', 'Enter course description');?>"></textarea>
                            </div>
                        </div>
                        <input hidden id="subject_input" name="subject_id">
                        <button type="submit" class="btn btn-success btn-lg btn-block" id="SubmitButton"
                                value="Upload"><?php echo getTranslation("general:button:save", "Save");?></button>
                    </form>
                    <div id="output"></div>
                    <br>
                </div>
            </div>
        </div>
    </section>
</div>

<!--<script type="text/javascript" src="../js/tools.js"></script>-->
<!--<script type="text/javascript" src="../js/addcourse.js"></script>-->
