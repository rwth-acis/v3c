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
<!--Prototype Templates -->
<div class="virtus-pw-prototype virtus-pw-hide " id="prototypeSlideViewer">
    <div class="virtus-pw-name">
        Slides Widget
    </div>
    <div class="virtus-pw-content-container">
        <div class="row virtus-pw-content-wrapper">
            <div class="col-sm-12 virtus-pw-slide-img-wrapper"><img class="virtus-pw-sliderviewer-img" src='https://s-media-cache-ak0.pinimg.com/564x/0d/e6/b3/0de6b34699563781365b286c45359692.jpg'></div>
            <div class="col-sm-12 virtus-pw-content">
                <div class="row">
                    <div class="col-sm-4">
                        <span class="glyphicon glyphicon glyphicon-chevron-left slideviewer-nav-icon" aria-hidden="true"></span>
                    </div>
                    <div class="col-sm-4">
                        <span class="slide-viewer-slideindex-style">1/20</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="glyphicon glyphicon-chevron-right slideviewer-nav-icon" aria-hidden="true"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="virtus-pw-prototype virtus-pw-hide " id="prototypeVideoViewer">
    <div class="virtus-pw-name">
        Video Widget
    </div>
    <div class="virtus-pw-content-container">
        <div class="row virtus-pw-content-wrapper">
            <div class="col-sm-12 virtus-pw-slide-img-wrapper"><img class="virtus-pw-sliderviewer-img" src='http://i.imgur.com/g0I8gTi.jpg'></div>
            <div class="col-sm-12 virtus-pw-content">
                <div class="row">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-6">
                        <span class="glyphicon glyphicon glyphicon glyphicon glyphicon-fast-backward slideviewer-nav-icon videoviewer-icons-side-padding" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon glyphicon glyphicon-play slideviewer-nav-icon videoviewer-icons-side-padding" aria-hidden="true"></span>
                        <span class="glyphicon glyphicon glyphicon glyphicon glyphicon-fast-forward slideviewer-nav-icon videoviewer-icons-side-padding" aria-hidden="true"></span><br>
                        <span class="videoviewer-time-style">00:30:43/01:15:00</span>
                    </div>
                    <div class="col-sm-3">
                        <span class="glyphicon glyphicon glyphicon-fullscreen slideviewer-nav-icon" aria-hidden="true"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id='courses'>
    <section class='container'>
        <div class='container'>
            <div class='row'>
                <!-- Info box with data about subject -->
                <div class='col-sm-2 virtus-margin-top-15'>
                    <div class='featured-box sidebar-container'>
                        <div class="sidebar-title">Toolbox:</div>
                        <div class="gridstack-sidebar">

                        </div>
                        <div class="trash">
                        </div>
                    </div>
                </div>

                <!-- List of all courses -->
                <div class='col-sm-10 virtus-margin-top-15'>
                    <div class="gridstack-canvas-container">
                        <div class="canvas-title">Rolespace</div>
                        <div class="grid-stack grid-stack-10 grid-stack-main" id="grid1">
                            <!--<div class="grid-stack-item test" data-gs-x="10" data-gs-y="0" data-gs-width="2" data-gs-height="8" data-gs-no-resize="" data-gs-no-move="" data-gs-locked=""></div>-->
                        </div>
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
<script src="../external/gridstack/gridstack.js"></script>
<script src="../external/gridstack/gridstack.jQueryUI.min.js"></script>

<!-- Plugin JavaScript -->

<script src="../js/course-list.js"></script>
<!--<script src="../js/widget-arrangement.js"><script/>-->
<script>
    initWidgets = [
        {name: 'slideviewer',prototypeName: 'prototypeSlideViewer'},{name: 'videoviewer',prototypeName: 'prototypeVideoViewer'}, {name: 'quiz',prototypeName: 'prototypeSlideViewer'}
    ];


    $(function () {

        var $canvas = $('#grid1');
        var $canvasContainer = $('.gridstack-canvas-container');

        var $prevItems = $('.gridstack-sidebar .grid-stack-item');
        var options = {
            width: 10,
            float: false,
            removable: '.trash',
            removeTimeout: 100,
            acceptWidgets: '.grid-stack-item',
            /*height: 8,*/

        };
        $canvas.gridstack(options);

        initWidgets.forEach(function (value, i) {
            createSidebarElement(value.name, i);
        });

        //$canvas.cellHeight($canvas.height);
        /*var items = [
            {x: 4, y: 1, width: 1, height: 2},
            {x: 4, y: 1, width: 1, height: 1},
            {x: 2, y: 3, width: 3, height: 1},
            {x: 2, y: 5, width: 1, height: 1}
        ];

        $('.grid-stack').each(function () {
            var grid = $(this).data('gridstack');

            _.each(items, function (node) {
                grid.addWidget($('<div><div class="grid-stack-item-content" /><div/>'),
                    node.x, node.y, node.width, node.height)
            }, this);
        });*/
        $prevItems.draggable({
            revert: 'invalid',
            handle: '.grid-stack-item-content',
            scroll: false,
            appendTo: 'body',
        });
        //fix for static sidebar items
        $('.grid-stack').on('change', function (event, items) {

            console.log("CHANGE EVENT FIRED");
            $.each(items, function (index, item) {
                var $item = (item.el).find('.grid-stack-sidebar-item');
                //console.log($item);
                if ($item.hasClass('grid-stack-sidebar-item')) {
                    console.log('found an item with class grid-stack-sidebar-item');
                    //This one needs to be added
                    var itemIndex = $item.data('index');
                    //console.log(ItemIndex);
                    createSidebarElement(initWidgets[itemIndex].name, itemIndex)
                    $item.removeClass('grid-stack-sidebar-item');


                    var $prototypeWidget = $('#'+initWidgets[itemIndex].prototypeName);
                    $prototypeClone = $prototypeWidget.clone();
                    $prototypeClone.removeClass('virtus-pw-hide');
                    $item.html("");
                    $item.append($prototypeClone);
                }

            });
        });
    });
function createSidebarElement(name, index){
    $parentEl =$('.gridstack-sidebar');
    if(index ==0){
        $parentEl.prepend($('<div class="grid-stack-item "><div class="grid-stack-item-content grid-stack-sidebar-item" data-index="'+index+'">'+name+'</div></div>')
            .draggable({
                revert: 'invalid',
                handle: '.grid-stack-item-content',
                scroll: false,
                appendTo: 'body',
            }));
    }else{
        //$('[data-index="'+(parseInt(index)-1)+'"]').parent().after($('<div class="grid-stack-item "><div class="grid-stack-item-content grid-stack-sidebar-item" data-index="'+index+'">'+name+'</div></div>')
        $('<div class="grid-stack-item "><div class="grid-stack-item-content grid-stack-sidebar-item" data-index="'+index+'">'+name+'</div></div>')
            //.find('.grid-stack-sidebar-item').append($('.virtus-pw-prototype'))
            .insertAfter($parentEl.find($('[data-index="'+(parseInt(index)-1)+'"]')).parent())
            .draggable({
                revert: 'invalid',
                handle: '.grid-stack-item-content',
                scroll: false,
                appendTo: 'body',
            });
    }


}
</script>
</body>
</html>
