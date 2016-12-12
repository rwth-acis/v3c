<?php
/**
 * Copyright 2015 Adam Brunnmeier, Dominik Studer, Alexandra Wörner, Frederik Zwilling, Ali Demiralp, Dev Sharma, Luca Liehner, Marco Dung, Georgios Toubekis
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @file welcome.php
 * Starting page when using V3C
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V3C</title>
</head>
<body>
<?php include("menu.php"); ?>

<!-- DESCRIPTION OF THE V3C WEBSITE -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="featured-box">
                <h3>Welcome to the V3C Project!</h3>
                <p>V3C is an innovative virtual vocational education and training centre,
                    which will provide appropriately designed modular certified courses in Modular Employable Skills.
                </p>
                <p>The “Virtual Vocational Education and Training – VIRTUS” project will develop an innovative, fully
                    functional virtual vocational education and training centre, which will provide appropriately
                    designed modular certified courses in Modular Employable Skills (MES), corresponding to a wide range
                    of circumstances such as regional growth potential and/or company restructuring and aiming at
                    increasing the participation rate of adult learners in vocational education and training.</p>
                <p>In particular, the virtual VET center will provide two modular certified courses on:
                <ol>
                    <li>Tourism and Hospitality Services.</li>
                    <li>Social Entrepreneurship.</li>
                </ol>
                </p>
            </div>
        </div>
    </div>
</div>


<div id="courses">
    <div class="container">
        <p>&nbsp;</p>
        <div class="row">
            <div class="col-md-12">
                <div class="featured-box">
                    <?php
                    //Decide if this site is inside a separate widget
                    if (filter_input(INPUT_GET, "widget") == "true") {
                        //we have to link to the widget versions:
                        print("<a href='subjects.php?widget=true'>");
                    } else {
                        //we have to link to the non-widget versions:
                        print("<a href='subjects.php'>");
                    }
                    ?>
                    <i class="fa fa-file fa-2x"></i>
                    <div class="text">
                        <h3>Courses</h3>
                        <p>Check for the the list of all the courses available here.</p>
                        </a>
                    </div>
                </div>
                <!--<div class="temp">
                    <a href="arrwidgetmockup.php">mockup</a>
                </div>-->
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

</body>
</html>
