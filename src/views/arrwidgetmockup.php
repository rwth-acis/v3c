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
 * @file course_delete.php
 * Webpage for deleting a single course
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widget arrangement mockup </title>

    <link rel="stylesheet" href="../external/jasny-bootstrap/dist/css/jasny-bootstrap.min.css"/>
    <link rel="stylesheet" href="../external/gridstack/gridstack.css"/>
    <link rel="stylesheet" href="../external/gridstack/gridstack-extra.css"/>
    <link rel="stylesheet" href="../css/widget-arrangement.css"/>


</head>

<body>
<?php include("menu.php"); ?>
<header id='head' class='secondary'>
    <div class='container'>
        <div class='row'>
            <h1>Widget Arrangement Mockup</h1>
        </div>
    </div>
</header>

<div id='courses'>
    <section class='container'>
        <div class='container'>
            <div class='row'>
                <!-- Info box with data about subject -->
                <div class='col-sm-2'>
                    <div class='featured-box sidebar-container'>
                        <div class="gridstack-sidebar">
                            <div class="grid-stack-item preview-item-margin">
                                <div class="grid-stack-item-content">slideviewer</div>
                            </div>
                            <div class="grid-stack-item preview-item-margin">
                                <div class="grid-stack-item-content">videoviewer</div>
                            </div>
                            <div class="grid-stack-item preview-item-margin">
                                <div class="grid-stack-item-content">quiz</div>
                            </div>

                        </div>
                        <div class="trash">
                        </div>
                    </div>
                </div>

                <!-- List of all courses -->
                <div class='col-sm-10'>
                    <div class="grid-stack grid-stack-10 grid-stack-main">
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- container -->

<?php include("footer.php"); ?>

<script type="text/javascript" src="../js/tools.js"></script>
<?php
//Decide if this site is inside a separate widget
if (filter_input(INPUT_GET, "widget") == "true") {
    print("<script src='../js/overview-widget.js'> </script>");
}
?>
<!-- Library which defines behavior of the <table class="table table-striped table-bordered table-hover"> -->
<script src="../external/jquery/dist/jquery.js"></script>
<script src="../external/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
<script src="../external/jqueryUI/jquery-ui.min.js"></script>
<script src="../external/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
<script src="../external/lodash/lodash.js"></script>
<!--<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.2.5/gridstack.min.js"></script>-->
<!--<script src="../external/gridstack/gridstack.js"></script>-->
<script src="../external/gridstack/gridstack.all.js"></script>
<script src="../external/gridstack/gridstack.jQueryUI.min.js"></script>

<!-- Plugin JavaScript -->

<script src="../js/course-list.js"></script>
<!--<script src="../js/widget-arrangement.js"><script/>-->
<script>
    $(function () {

        $canvas = $('.grid-stack-main');
        var options = {
            width: 10,
            float: false,
            removable: '.trash',
            removeTimeout: 100,
            placeholderClass: 'grid-stack-placeholder',
            acceptWidgets: '.grid-stack-item'
        };
        $canvas.gridstack(options);

        $('.gridstack-sidebar .grid-stack-item').draggable({
            revert: 'invalid',
            handle: '.grid-stack-item-content',
            scroll: false,
            appendTo: 'body'
        });
    });

</script>
</body>
</html>
