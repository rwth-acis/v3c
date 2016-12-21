<?php

/* 
 * Copyright 2015 Adam Brunnmeier, Dominik Studer, Alexandra Wörner, Frederik Zwilling, Ali Demiralp, Dev Sharma, Luca Liehner, Marco Dung, Georgios Toubekis
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *  http://www.apache.org/licenses/LICENSE-2.0
 * 
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 * 
 *  @file editcourse_content.php
 *  The content of 'editcourse.php' if the user is allowed to edit courses
 */

$db = require '../php/db_connect.php';
$course_id = filter_input(INPUT_GET, 'id');
try {
    $entry = getSingleDatabaseEntryByValue('courses', 'id', $course_id);
} catch (Exception $e) {
    error_log($e->getMessage());
}

?>

<div id='courses'>
    <section class='container'>
        <br><br>
        <div class='container'>
            <div class='row'>
                <div class='col-md-10 col-md-offset-1'>

                    <!-- FORM FOR EDITING INPUT VALUES -->
                    <form role="form"
                          action="../php/edit_script_course.php<?php if (isset($_GET['widget']) && $_GET['widget'] == true) {
                              echo '?widget=true';
                          } ?>" method="post" enctype="multipart/form-data" id="UploadForm">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="targetName"><?php echo getTranslation("editcourse:edit:name", "Course name:");?></label>
                            <div class="col-sm-10">
                                <input type="hidden" name="targetId" value="<?php echo $course_id; ?>">
                                <input type="text" class="form-control" rows="1" name="name" id="targetName"
                                       value="<?php echo htmlentities($entry['name']); ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="targetDomain"><?php echo getTranslation("editcourse:edit:domain", "Course Domain:");?></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" rows="1" name="domain" id="targetDomain"
                                       value="<?php echo htmlentities($entry['domain']); ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="targetProfession"><?php echo getTranslation("editcourse:edit:profession", "Course Profession:");?></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" rows="1" name="profession" id="targetProfession"
                                       value="<?php echo htmlentities($entry['profession']); ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="targetText"><?php echo getTranslation("editcourse:edit:description", "Description:");?></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="3" name="text" id="targetText"
                                          placeholder="Enter course description"><?php echo htmlentities($entry['description']); ?></textarea>
                            </div>
                        </div>

                        <div class="center">
                            <a href="arrwidgetmockup.php"><?php echo getTranslation("editcourse:edit:design", "Design learning environment");?></a>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg btn-block" id="SubmitButton" value="Upload">
                            <?php echo getTranslation("general:button:save", "Save");?>
                        </button>
                    </form>
                    <!-- FROM FOR EDITING INPUT VALUES ENDING -->
                    <br>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- container -->

<!-- Darken background when model select window appears -->
<div id="blackout" onclick="editCourse.endBlackout()"></div>

