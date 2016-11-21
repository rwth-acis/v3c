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
 * @file addcourse_content.php
 * The content of 'addcourse.php' if the user is allowed to create courses 
 */
?>
<!--<div class='container'>-->
<div id='courses'>
    <section class='container'>
        <br><br>
        <div class='container'>
            <div class='row'>
                <div class='col-md-10 col-md-offset-1'>
                    <!-- User information box -->
                    <div class='featured-box'>
                        Add your new course room data. To create a new ROLE space click "+" and for help on ROLE click
                        "?".<br>
                        Don't forget to click the save button.
                    </div>
                    <!--- CREATE COURSE INPUT FORM -->
                    <form role="form" class="form-horizontal"
                          action="../php/upload_script_course.php<?php if (isset($_GET['widget']) && $_GET['widget']) {
                              echo '?widget=true';
                          } ?>" method="post" enctype="multipart/form-data" id="UploadForm">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="targetName">Course name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" rows="1" name="name" id="targetName"
                                       placeholder="Enter your course name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="targetRole">Course room:</label>
                            <div class="col-sm-10">
                                <div class="course-room-div">
                                    <input type="text" class="form-control" rows="1" name="roleLink" id="targetRole"
                                           placeholder="Enter ROLE space name">
                                </div>
                                <a href="#">
                                    <input id="create-room-btn" class="col-xs-1 btn btn-default btn-inline"
                                           type="button" value="+"/>
                                </a>
                                <!-- Help button which opens role.php in new tab. TODO: Could be done more specific and in place. Also in addcourse.php -->
                                <a target="_blank" href="help.php">
                                    <input class="col-xs-1 btn btn-default btn-inline" type="button" value="?"/>
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="targetDomain">Course Domain:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" rows="1" name="domain" id="targetDomain"
                                       placeholder="Enter your course domain" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="targetProfession">Course Profession:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" rows="1" name="profession" id="targetProfession"
                                       placeholder="Enter your course profession" required>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="col-sm-2 control-label" for="targetContact">Contact:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="3" name="contact" id="targetContact"
                                          placeholder="Enter your contact details, e.g. enter university name, department, address, phone number, fax number"></textarea>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="targetText">Description:</label>
                            <div class="col-sm-10">
                <textarea class="form-control" rows="3" name="text" id="targetText"
                          placeholder="Enter course description"></textarea>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="col-sm-2 control-label" for="targetDates">Dates:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="3" name="dates" id="targetDates"
                                          placeholder="Enter dates for online appointments which are relevant for your students"></textarea>
                            </div>
                        </div>-->
                        <!--<div class="form-group">
                            <label class="col-sm-2 control-label" for="targetLinks">Links:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="3" name="links" id="targetLinks"
                                          placeholder="Enter external links which provide additional information, e.g. links to Campus Office, L2P"></textarea>
                            </div>
                        </div>-->
                        <input hidden id="subject_input" name="subject_id">
                        <button type="submit" class="btn btn-success btn-lg btn-block" id="SubmitButton"
                                value="Upload">Save
                        </button>
                    </form>
                    <div id="output"></div>
                    <br>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="../js/tools.js"></script>
<script type="text/javascript" src="../js/addcourse.js"></script>
