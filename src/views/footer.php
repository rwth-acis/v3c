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
 * @file footer.php
 * The footer of a each website
 */
?>
<footer id="footer" style="margin-top: 100px">
    <div class="container">
        <div class="clear"></div>
        <!--CLEAR FLOATS-->
    </div>
    <div class="footer2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 panel">
                    <div class="panel-body">
                        <p class="simplenav">
                            <?php
                            //Decide if this site is inside a separate widget
                            if (filter_input(INPUT_GET, "widget") == "true") {
                                ?>
                                <a href="welcome.php?widget=true">Home</a> |
                                <a href="subjects.php?widget=true">Courses</a> |
                                <a href="help.php?widget=true">Help</a>
                            <?php } else { ?>
                                <a href="welcome.php">Home</a> |
                                <a href="subjects.php">Courses</a> |
                                <a href="help.php">Help</a>
                            <?php } ?>
                        </p>
                    </div>
                </div>

                <div class="col-md-6 panel">
                    <div class="panel-body">
                        <p class="text-right">
                            VIRTUS Virtual Vocational Training Centre
                        </p>
                        <p class="text-right">Reach us at: <a href="mailto:henm1617g3@dbis.rwth-aachen.de">henm1617g3@dbis.rwth-aachen.de</a>
                        </p>
                    </div>
                </div>

            </div>
            <!-- /row of panels -->
        </div>
    </div>
</footer>