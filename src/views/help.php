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
      if(filter_input(INPUT_GET, "widget") == "true") {

      }
      else {
        echo '
            <header id="head" class="secondary">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1>Help</h1>
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
            <?php
              // Explanation and links to ROLE environment are not shown if already inside ROLE environment
              if(!(filter_input(INPUT_GET, "widget") == "true"))
              {
            ?>
                <h3>Set Up Viewing Environment</h3>
                <p>
                    <img src="../images/role-full.jpg" alt="" class="img-rounded pull-right" width="300">
                    <p>The Collaborative 3D Model Viewing is
                  provided in widgets for
                  the <a href="http://www.role-project.eu/">Responsive
                  Open Learning Environments
                  (ROLE)</a>. Here you can create a
                  workspace, setup a learning environment
                  and invite other people to join
                  you. ROLE allows you to combine the
                  Collaborative 3D Model Viewing with many
                  other widgets for collaborative
                  learning. </p>

                <p>Setting up the environment for
                collaborative viewing is really easy. If
                you do it for the first time, you can
                follow these steps:</p>

                <ol>
                  <li>Create a ROLE space <a href="http://role-sandbox.eu/">here</a></li>
                  <li>Log in (Use a Learning Layers account)</li>
                  <li>On the "Edit Your Course" page next to the "Course room" entry two URLs are given. Do the following steps for each of them once:  </li>
                  <ol>
                    <li>In the sidebar on the left by clicking the "+" symbol next to "Widgets". A popup window will appear.</li>
                    <li>Copy the URL into the textbox in the popup window and click "OK".</li>
                  </ol>
                  <li>Enter the ROLE Space URL (e.g. http://role-sandbox.eu/spaces/spacename) on the "Edit Your Course" page.</li>
                  <li>Invite others by providing the link to the space</li>
                </ol>
            <?php } ?>

            </section>
            <!-- /main -->

            <!-- Sidebar -->
            <aside class="col-sm-4 sidebar sidebar-right">

                <div class="panel">
                    <h4>Important Links</h4>
                    <ul class="list-unstyled list-spaces">
                      <?php
                        //Decide if this site is inside a separate widget
                        if(filter_input(INPUT_GET, "widget") == "true")
                        {
                      ?>
                        <li><a href="subjects.php?widget=true">Courses</a><br>
                            <span class="small text-muted">A list of all the courses available</span></li>
                      <?php } else { ?>
                        <li><a href="subjects.php">Courses</a><br>
                            <span class="small text-muted">A list of all the courses available</span></li>
                      <?php } ?>
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
