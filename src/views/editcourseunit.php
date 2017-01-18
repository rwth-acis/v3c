<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widget arrangement mockup </title>

    <link rel="stylesheet" href="../external/redacted/fonts/stylesheet.css"/>
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
            <h1>Edit Course Unit</h1>
        </div>
    </div>
</header>
<!--Prototype Templates -->
<!-- ################################################################################### -->
<div class="virtus-pw-prototype virtus-pw-hide pw-slide-viewer" id="prototypeSlideViewer">
    <div class="row virtus-pw-prototype-topbar">
        <div class="virtus-pw-name col-sm-12">
            Slides Widget
        </div>
        <div class="virtus-pw-prototype-top-toolbar">
            <span class="glyphicon glyphicon glyphicon glyphicon-info-sign virtus-pw-padding-sides-02rem"
                  aria-hidden="true"></span>
            <span class="glyphicon glyphicon glyphicon-pencil virtus-pw-padding-sides-02rem" aria-hidden="true"></span>
            <span class="glyphicon glyphicon rm-icon glyphicon glyphicon-remove virtus-pw-padding-sides-02rem"
                  aria-hidden="true"></span>
        </div>
    </div>
    <div class="virtus-pw-content-container">
        <div class="row virtus-pw-content-wrapper">
            <div class="col-sm-12 virtus-pw-slide-img-wrapper">
                <div class="col-sm-12 virtus-pw-content-toolbox-wrapper pw-right-alignement">
                    <button type="button" class="btn btn-warning btn-sm modal-toggler-button" aria-label="Left Align"
                            data-toggle="modal"
                            data-target=".pw-modal-slideviewer">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Content
                    </button>
                    <!--<span class="glyphicon glyphicon-pencil pw-alert-color" aria-hidden="true"></span>-->
                </div>
                <img class="virtus-pw-sliderviewer-img" src='../images/widgetsPrototypes/slides-mockup.jpg'>
            </div>
            <div class="col-sm-12 virtus-pw-content">
                <div class="row">
                    <div class="col-sm-4">
                        <span class="glyphicon glyphicon glyphicon-chevron-left slideviewer-nav-icon"
                              aria-hidden="true"></span>
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


<div class="virtus-pw-prototype virtus-pw-hide pw-video-viewer" id="prototypeVideoViewer">
    <div class="row virtus-pw-prototype-topbar">
        <div class="virtus-pw-name col-sm-12">
            Video Widget
        </div>
        <div class="virtus-pw-prototype-top-toolbar">
            <span class="glyphicon glyphicon glyphicon glyphicon-info-sign virtus-pw-padding-sides-02rem"
                  aria-hidden="true"></span>
            <span class="glyphicon glyphicon glyphicon-pencil virtus-pw-padding-sides-02rem" aria-hidden="true"></span>
            <span class="glyphicon glyphicon glyphicon glyphicon-remove virtus-pw-padding-sides-02rem"
                  aria-hidden="true"></span>
        </div>
    </div>
    <div class="virtus-pw-content-container">
        <div class="row virtus-pw-content-wrapper">
            <div class="col-sm-12 virtus-pw-slide-img-wrapper">
                <div class="col-sm-12 virtus-pw-content-toolbox-wrapper pw-right-alignement">
                    <!--<span class="pw-alert-color"></span>-->
                    <button type="button" class="btn btn-warning btn-sm modal-toggler-button" aria-label="Left Align"
                            data-toggle="modal"
                            data-target=".pw-modal-videoviewer">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Content
                    </button>
                    <!--<span class="glyphicon glyphicon-pencil pw-alert-color" aria-hidden="true"></span>-->
                </div>
                <img class="virtus-pw-sliderviewer-img" src='../images/widgetsPrototypes/video-mockup.jpg'>
            </div>
            <div class="col-sm-12 virtus-pw-content">
                <div class="row">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-6">
                        <span
                            class="glyphicon glyphicon glyphicon glyphicon glyphicon-fast-backward slideviewer-nav-icon videoviewer-icons-side-padding"
                            aria-hidden="true"></span>
                        <span
                            class="glyphicon glyphicon glyphicon glyphicon-play slideviewer-nav-icon videoviewer-icons-side-padding"
                            aria-hidden="true"></span>
                        <span
                            class="glyphicon glyphicon glyphicon glyphicon glyphicon-fast-forward slideviewer-nav-icon videoviewer-icons-side-padding"
                            aria-hidden="true"></span><br>
                        <span class="videoviewer-time-style">00:30:43/01:15:00</span>
                    </div>
                    <div class="col-sm-3">
                        <span class="glyphicon glyphicon glyphicon-fullscreen slideviewer-nav-icon"
                              aria-hidden="true"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="virtus-pw-prototype virtus-pw-hide pw-quizzes-viewer" id="prototypeQuizzesViewer">
    <div class="row virtus-pw-prototype-topbar">
        <div class="virtus-pw-name col-sm-12">
            Quizzes Widget
        </div>
        <div class="virtus-pw-prototype-top-toolbar">
            <span class="glyphicon glyphicon glyphicon glyphicon-info-sign virtus-pw-padding-sides-02rem"
                  aria-hidden="true"></span>
            <span class="glyphicon glyphicon glyphicon-pencil virtus-pw-padding-sides-02rem" aria-hidden="true"></span>
            <span class="glyphicon glyphicon glyphicon glyphicon-remove virtus-pw-padding-sides-02rem"
                  aria-hidden="true"></span>
        </div>
    </div>
    <div class="virtus-pw-content-container">
        <div class="row virtus-pw-content-wrapper">
            <div class="col-sm-12 virtus-pw-quizzes-img-wrapper">
                <div class="col-sm-12 virtus-pw-content-toolbox-wrapper pw-right-alignement">
                    <button type="button" class="btn btn-warning btn-sm modal-toggler-button" aria-label="Left Align"
                            data-toggle="modal"
                            data-target=".pw-modal-quizzes">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Content
                    </button>
                    <!--<span class="glyphicon glyphicon-pencil pw-alert-color" aria-hidden="true"></span>-->
                </div>
                <img class="virtus-pw-sliderviewer-img" src='../images/widgetsPrototypes/quizzes-mockup.jpg'>
            </div>
            <div class="col-sm-12 quizzes-question-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                diam nonumy eirmod tempor ?
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12 quizzes-answers-container">
                        <div class="row">
                            <div class="col-sm-6 quizzes-answer-box-container">
                                <div class="quizzes-answer-box">some answer</div>
                            </div>
                            <div class="col-sm-6 quizzes-answer-box-container">
                                <div class="quizzes-answer-box">The answer is b</div>
                            </div>
                            <div class="col-sm-6 quizzes-answer-box-container">
                                <div class="quizzes-answer-box">No that is the</div>
                            </div>
                            <div class="col-sm-6 quizzes-answer-box-container">
                                <div class="quizzes-answer-box">ture that</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Prototype Modal Templates -->
<!-- ################################################################################### -->
<div class="modal fade pw-modal-slideviewer" tabindex="-1" role="dialog" aria-labelledby="modal"
     id="prototypeSlideViewerModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Slides Widget</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="slides-title">Sildes Title</label>
                            <input type="text" class="form-control protocontent" id=-slides-title" name="slides-title"
                                   placeholder="Title" aria-describedby="basic-addon1">
                        </div>
                        <div class="col-sm-6">
                            <label for="slides-upload">Upload Slides</label><br>
                            <label class="btn btn-default glyphicon glyphicon-upload" aria-hidden="true">
                                Browse <input type="file" class="hidden protocontent" id=slides-upload"
                                              name="slides-upload">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success modal-save-button">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade pw-modal-video" tabindex="-1" role="dialog" aria-labelledby="modal"
     id="prototypeVideoViewerModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Video Widget</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="video-title">Video Title</label>
                            <input type="text" class="form-control protocontent" id=-video-title" name="video-title"
                                   placeholder="Title" aria-describedby="basic-addon1">
                        </div>
                        <div class="col-sm-6">
                            <label for="video-upload">Upload Video</label><br>
                            <label class="btn btn-default glyphicon glyphicon-upload" aria-hidden="true">
                                Browse <input type="file" class="hidden protocontent" id=video-upload"
                                              name="video-upload">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success modal-save-button">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade pw-modal-quizzes" tabindex="-1" role="dialog" aria-labelledby="modal"
     id="prototypeQuizzesViewerModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Quizzes Widget</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="video-title">Quizzes Title</label>
                                <input type="text" class="form-control protocontent" id=-quizzes-title"
                                       name="quizzes-title"
                                       placeholder="Title" aria-describedby="basic-addon1">
                            </div>
                            <div class="col-sm-12">
                                <h4 class="">Questions</h4>
                                <hr>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="question-title-counter">Question 1</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="quizzes-question-0">Question:</label>
                                                <input type="text" class="form-control protocontent"
                                                       id=-quizzes-question-0" name="quizzes-question-0"
                                                       placeholder="Question" aria-describedby="basic-addon1">
                                            </div>
                                            <label class="col-sm-12">Answers:</label>

                                            <div class="col-sm-6 padding-bottom-1em">
                                                <div class="input-group">
                                                    <input type="text" class="form-control protocontent"
                                                           id=-quizzes-answer-0-0" name="quizzes-answer-0-0"
                                                           placeholder="Answer 1" aria-describedby="basic-addon1"
                                                           placeholder="Add Answer">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-secondary" type="button"
                                                                disabled>-</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 padding-bottom-1em">
                                                <div class="input-group">
                                                    <input type="text" class="form-control protocontent"
                                                           id=-quizzes-answer-0-0" name="quizzes-answer-0-0"
                                                           placeholder="Answer 2" aria-describedby="basic-addon1"
                                                           placeholder="Add Answer">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-secondary" type="button"
                                                                disabled>-</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 padding-bottom-1em">
                                                <button type="button" class="btn btn-default btn-block btn-add-answer">
                                                    Add Answer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-sm-12 padding-bottom-1em text-center">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <li>
                                                <a href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <li><a href="#">1</a></li>
                                            <li>
                                                <a href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success modal-add-button">Add Question +</button>
                <button type="button" class="btn btn-success modal-save-button">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!--Course edit site -->
<!-- ################################################################################### -->

<div id='courses'>
    <section class='container'>
        <div class='container'>
            <div class='row'>
                <!-- Info box with data about subject -->
                <div class='col-sm-2 virtus-margin-top-15'>
                    <div class='featured-box sidebar-container'>
                        <div class="row">
                            <div class="col-sm-2 lock-sidebar-icon-container virtus-pw-hide">
                                <span class="glyphicon glyphicon glyphicon-lock locked-color-style sidbeback-lock-icon"
                                      aria-hidden="true"
                                      data-toggle="tooltip"
                                      data-placement="bottom"
                                      title="The sidebar is locked, because you already filled the rolespace with the maximum amount of Widgets. Remove Widgets to be able to add new Widgets again."></span>
                            </div>
                            <div class="col-sm-8">
                                <div class="sidebar-title">Toolbox:</div>
                            </div>
                        </div>
                        <div class="gridstack-sidebar">

                        </div>
                        <div class="row sidebar-widget-counter-container">
                            <div class="col-sm-12 sidebar-widget-counter-text">total Widgets used:</div>
                            <div class="col-sm-12 sidebar-widget-counter-number">0/3</div>
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
<script type="text/template" id="answerBlock">
    <div class="col-sm-6 padding-bottom-1em">
        <div class="input-group">
            <input type="text" class="form-control protocontent"
                   id=-quizzes-answer-0-0" name="quizzes-answer-0-0"
                   placeholder="Answer 2" aria-describedby="basic-addon1"
                   placeholder="Add Answer">
            <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">-</button>
            </span>
        </div>
    </div>
</script>


<script src="../js/course-list.js"></script>
<!--<script src="../js/widget-arrangement.js"><script/>-->
<script>
    initWidgets = [
        {name: 'slide viewer', prototypeName: 'prototypeSlideViewer', modalname: 'prototypeSlideViewerModal'},
        {name: 'video viewer', prototypeName: 'prototypeVideoViewer', modalname: 'prototypeVideoViewerModal'},
        {name: 'quiz', prototypeName: 'prototypeQuizzesViewer', modalname: 'prototypeQuizzesViewerModal'}
    ];


    $(function () {

        // TODO: FIX TOOLTIP HOVERING
        //$('[data-toggle="tooltip"]').tooltip()


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
        var totalWidgets = 0; //counting amount of Widgets added, without couting removals (this variable is only used for the indexing of modals within the widgets. Don't use it for something else.
        $('.grid-stack').on('change', function (event, items) {

            console.log("CHANGE EVENT FIRED");
            var cntr = 0;
            $.each(items, function (index, item) {
                var $item = (item.el).find('.grid-stack-sidebar-item');
                if ($item.hasClass('grid-stack-sidebar-item')) {
                    console.log('found an item with class grid-stack-sidebar-item');
                    //This one needs to be added
                    var itemIndex = $item.data('index');
                    //console.log(ItemIndex);
                    createSidebarElement(initWidgets[itemIndex].name, itemIndex)
                    $item.removeClass('grid-stack-sidebar-item');


                    var $prototypeWidget = $('#' + initWidgets[itemIndex].prototypeName);
                    $prototypeClone = $prototypeWidget.clone();
                    $prototypeClone.removeClass('virtus-pw-hide');
                    $prototypeClone.attr("id", initWidgets[itemIndex].prototypeName + "-" + totalWidgets);
                    $prototypeClone.find(".modal-toggler-button").attr("data-target", "#" + initWidgets[itemIndex].modalname + "-" + totalWidgets);
                    $item.html("");
                    $item.append($prototypeClone);

                    var $prototypeModal = $('#' + initWidgets[itemIndex].modalname);
                    $prototypeModalClone = $prototypeModal.clone();
                    $prototypeModalClone.attr("id", initWidgets[itemIndex].modalname + "-" + totalWidgets);
                    $("body").append($prototypeModalClone);

                    var prototypeWidgetId = initWidgets[itemIndex].prototypeName + "-" + totalWidgets; //call by value
                    var prototypeWidgetModalId = initWidgets[itemIndex].modalname + "-" + totalWidgets;//call by value7
                    $prototypeModalClone.find(".modal-save-button").click(function () {
                        appendDataAttributes(prototypeWidgetId, prototypeWidgetModalId);
                        //$(this).modal('toggle');
                    });
                    $prototypeModalClone.find(".btn-add-answer").click(function () {

                        var template = $("#answerBlock").html();
                        $(template).insertBefore($(this).parent());
                    });

                    totalWidgets++;

                }
                cntr++;
            });
            $('.sidebar-widget-counter-number').text(cntr + "/3");
            if (cntr >= 3) {
                $('.gridstack-sidebar').addClass('disable-item locked-sidebar');
                $('.sidebar-widget-counter-container').addClass('locked-color-style');
                $('.lock-sidebar-icon-container').removeClass('virtus-pw-hide');

            } else {
                $('.gridstack-sidebar').removeClass('disable-item locked-sidebar');
                $('.gridstack-sidebar').find('.sidbeback-lock-icon').remove();
                $('.sidebar-widget-counter-container').removeClass('locked-color-style');
                $('.lock-sidebar-icon-container').addClass('virtus-pw-hide');
            }
            cntr = 0;
        });
    });

    function createSidebarElement(name, index) {
        $parentEl = $('.gridstack-sidebar');
        if (index == 0) {
            $parentEl.prepend($('<div class="grid-stack-item "><div class="grid-stack-item-content grid-stack-sidebar-item" data-index="' + index + '"><div class="grid-stack-sidebar-item-topbar"></div>' + name + '</div></div>')
                .draggable({
                    revert: 'invalid',
                    handle: '.grid-stack-item-content',
                    scroll: false,
                    appendTo: 'body',
                }));
        } else {
            //$('[data-index="'+(parseInt(index)-1)+'"]').parent().after($('<div class="grid-stack-item "><div class="grid-stack-item-content grid-stack-sidebar-item" data-index="'+index+'">'+name+'</div></div>')
            $('<div class="grid-stack-item "><div class="grid-stack-item-content grid-stack-sidebar-item" data-index="' + index + '"><div class="grid-stack-sidebar-item-topbar"></div>' + name + '</div></div>')
            //.find('.grid-stack-sidebar-item').append($('.virtus-pw-prototype'))
                .insertAfter($parentEl.find($('[data-index="' + (parseInt(index) - 1) + '"]')).parent())
                .draggable({
                    revert: 'invalid',
                    handle: '.grid-stack-item-content',
                    scroll: false,
                    appendTo: 'body',
                });
        }

    }
    function appendDataAttributes(widgetId, modalId) {
        $widget = $("#" + widgetId);
        $modal = $("#" + modalId);

        $inputObj = $modal.find(".modal-body").find(".protocontent");
        $inputObj.each(function (index) {
            //For unknown reason, replacing attr() with data() does not work
            $widget.parent().parent().attr("data-" + $(this).attr("name"), $(this).val());
        });
        console.log($inputObj)
    }

</script>
</body>
</html>
