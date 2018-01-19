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
 * @file help.php
 * Webpage for showing general information and instructions on how to use V3C
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
<?php require("menu.php"); ?>

<?php
//Decide if this site is inside a separate widget
if (filter_input(INPUT_GET, "widget") == "true") {

} else {
    echo '
            <header id="head" class="secondary">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1>'.getTranslation("help:help", "Help").'</h1>
                        </div>
                    </div>
                </div>
            </header>
        ';
}
?>


<!-- container -->
<section class="container">
    <div class="row">
        <!-- main content -->
        <section class="col-sm-8 maincontent">
              <h4><iframe width="728" height="410" src="https://www.youtube.com/embed/VyAjm3S7OdQ?rel=0" frameborder="0" allowfullscreen></iframe> <br><?php echo getTranslation("help:info", "For more information visit");?> <a href="http://virtus-project.eu/">http://virtus-project.eu</a>.</h4>
        </section>
        <!-- /main -->

        <!-- Sidebar -->
        <aside class="col-sm-4 sidebar sidebar-right">

            <div class="panel">
                <h4><?php echo getTranslation("help:importantLinks", "Important Links");?></h4>
                <ul class="list-unstyled list-spaces">
                    <?php
                    //Decide if this site is inside a separate widget
                    if (filter_input(INPUT_GET, "widget") == "true") {
                        ?>
                        <li><a href="subjects.php?widget=true"><?php echo getTranslation("general:button:courses", "Courses");?></a><br>
                            <span class="small text-muted"><?php echo getTranslation("help:coursesDesc", "A list of all the courses available");?></span></li>
                    <?php } else { ?>
                        <li><a href="subjects.php"><?php echo getTranslation("general:button:courses", "Courses");?></a><br>
                            <span class="small text-muted"><?php echo getTranslation("help:coursesDesc", "A list of all the courses available.");?></span></li>
                    <?php } ?>
                    <li><a href="../media/slides/VIRTUS_R4.5_handbook_<?php echo getTranslation("help:handbookLink", "EN");?>.pdf"><?php echo getTranslation("help:handbook", "Handbook");?></a><br>
                            <span class="small text-muted"><?php echo getTranslation("help:handbookDesc", "A trainee handbook.");?></span></li>
                </ul>
            </div>

        </aside>
        <!-- /Sidebar -->

    </div>
</section>
<!-- /container -->
<?php include("footer.php"); ?>
</body>
</html>
