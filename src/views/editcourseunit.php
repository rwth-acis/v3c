<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widget arrangement</title>

    <link rel="stylesheet" href="../external/redacted/fonts/stylesheet.css"/>
    <link rel="stylesheet" href="../external/jasny-bootstrap/dist/css/jasny-bootstrap.min.css"/>
    <link rel="stylesheet" href="../external/gridstack/gridstack.css"/>
    <link rel="stylesheet" href="../external/gridstack/gridstack-extra.css"/>
    <link rel="stylesheet" href="../css/widget-arrangement.css"/>
    <link rel="stylesheet" href="../css/style.css"/>
</head>

<body>
    <?php include("menu.php"); ?>
    <header id='head' class='secondary'>
        <div class='container'>
            <div class='row'>
                <h1><?php echo getTranslation("designunit:head:title", "Edit Course Unit");?></h1>
            </div>
        </div>
    </header>
    <?php
    include '../php/access_control.php';
    $accessControl = new AccessControl();
    $course_id = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT);
    $unit_id = filter_input(INPUT_GET, 'uid', FILTER_VALIDATE_INT);
    $course_lang = filter_input(INPUT_GET, 'ulang');

    $canCreateCourse = $accessControl->canUpdateCourse($course_id);
    if ($canCreateCourse) {
        ?>
        <!--Prototype Templates -->
        <!-- ################################################################################### -->
        <div class="virtus-pw-prototype virtus-pw-hide pw-slide-viewer" id="prototypeSlideViewer">
            <div class="row virtus-pw-prototype-topbar">
                <div class="virtus-pw-name col-sm-12">
                    <?php echo getTranslation("designunit:content:slideswidget", "Slides Widget");?>
                </div>
                <div class="virtus-pw-prototype-top-toolbar">
                    <span class="glyphicon glyphicon glyphicon glyphicon-info-sign virtus-pw-padding-sides-02rem"
                    aria-hidden="true"></span>
                    <span class="glyphicon glyphicon glyphicon-pencil virtus-pw-padding-sides-02rem"
                    aria-hidden="true"></span>
                    <span class="glyphicon glyphicon rm-icon glyphicon glyphicon-remove virtus-pw-padding-sides-02rem"
                    aria-hidden="true"></span>
                </div>
            </div>
            <div class="virtus-pw-content-container">
                <div class="row virtus-pw-content-wrapper">
                    <div class="col-sm-12 virtus-pw-slide-img-wrapper">
                        <div class="col-sm-12 virtus-pw-content-toolbox-wrapper pw-right-alignement">
                            <button type="button" class="btn btn-warning btn-sm modal-toggler-button"
                            aria-label="Left Align"
                            data-toggle="modal"
                            data-target=".pw-modal-slideviewer">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo getTranslation("designunit:content:addcontent", "Add Content");?>
                        </button>
                        <!--<span class="glyphicon glyphicon-pencil pw-alert-color" aria-hidden="true"></span>-->
                    </div>
                    <div class="virtus-pw-sliderviewer-content">
                        <ul>
                            <li type="square"><br>
                                <div class="slides-question-text"> dolor</div>
                            </li>
                            <li type="square">
                                <div class="slides-question-text ">Lorem ipsum dolor sit amet</div>
                            </li>
                            <li type="square">
                                <div class="slides-question-text">Lorem ipor sit amet</div>
                            </li>
                            <li type="square">
                                <div class="slides-question-text">Lorem ipor sit amet</div>
                            </li>
                        </ul>
                    </div>

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
                            <span class="glyphicon glyphicon-chevron-right slideviewer-nav-icon"
                            aria-hidden="true"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="virtus-pw-prototype virtus-pw-hide pw-slide-viewer pw-image-viewer" id="prototypeImageViewer">
        <div class="row virtus-pw-prototype-topbar">
            <div class="virtus-pw-name col-sm-12">
                <?php echo getTranslation("designunit:content:imagewidget", "Image Widget");?>
            </div>
            <div class="virtus-pw-prototype-top-toolbar">
                <span class="glyphicon glyphicon glyphicon glyphicon-info-sign virtus-pw-padding-sides-02rem"
                aria-hidden="true"></span>
                <span class="glyphicon glyphicon glyphicon-pencil virtus-pw-padding-sides-02rem"
                aria-hidden="true"></span>
                <span class="glyphicon glyphicon rm-icon glyphicon glyphicon-remove virtus-pw-padding-sides-02rem"
                aria-hidden="true"></span>
            </div>
        </div>
        <div class="virtus-pw-content-container">
            <div class="row virtus-pw-content-wrapper">
                <div class="col-sm-12 virtus-pw-slide-img-wrapper">
                    <div class="col-sm-12 virtus-pw-content-toolbox-wrapper pw-right-alignement">
                        <button type="button" class="btn btn-warning btn-sm modal-toggler-button"
                        aria-label="Left Align"
                        data-toggle="modal"
                        data-target=".pw-modal-slideviewer">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo getTranslation("designunit:content:addcontent", "Add Content");?>
                    </button>
                    <!--<span class="glyphicon glyphicon-pencil pw-alert-color" aria-hidden="true"></span>-->
                </div>
                <div class="virtus-pw-sliderviewer-content">
                    <ul>
                        <li type="square"><br>
                            <div class="slides-question-text"> dolor</div>
                        </li>
                        <li type="square">
                            <div class="slides-question-text ">Lorem ipsum dolor sit amet</div>
                        </li>
                        <li type="square">
                            <div class="slides-question-text">Lorem ipor sit amet</div>
                        </li>
                        <li type="square">
                            <div class="slides-question-text">Lorem ipor sit amet</div>
                        </li>
                    </ul>
                </div>

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
                        <span class="glyphicon glyphicon-chevron-right slideviewer-nav-icon"
                        aria-hidden="true"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="virtus-pw-prototype virtus-pw-hide pw-hangouts" id="prototypeHangouts">
        <div class="row virtus-pw-prototype-topbar">
            <div class="virtus-pw-name col-sm-12">
                <?php echo getTranslation("designunit:content:hangoutwidget", "Video Conference Widget");?>
            </div>
            <div class="virtus-pw-prototype-top-toolbar">
                <span class="glyphicon glyphicon glyphicon glyphicon-info-sign virtus-pw-padding-sides-02rem"
                aria-hidden="true"></span>
                <span class="glyphicon glyphicon glyphicon-pencil virtus-pw-padding-sides-02rem"
                aria-hidden="true"></span>
                <span class="glyphicon glyphicon rm-icon glyphicon glyphicon-remove virtus-pw-padding-sides-02rem"
                aria-hidden="true"></span>
            </div>
        </div>
        <div class="virtus-pw-content-container">
            <div class="row virtus-pw-content-wrapper">
                <div class="col-sm-12 virtus-pw-slide-img-wrapper-full">
                    <img class="virtus-pw-hangouts-img" src='../images/widgetsPrototypes/hangouts-mockup.png'>
                </div>
            </div>
        </div>
    </div>


    <div class="virtus-pw-prototype virtus-pw-hide pw-video-viewer" id="prototypeVideoViewer">
        <div class="row virtus-pw-prototype-topbar">
            <div class="virtus-pw-name col-sm-12">
                <?php echo getTranslation("designunit:content:videowidget", "Video Widget");?>
            </div>
            <div class="virtus-pw-prototype-top-toolbar">
                <span class="glyphicon glyphicon glyphicon glyphicon-info-sign virtus-pw-padding-sides-02rem"
                aria-hidden="true"></span>
                <span class="glyphicon glyphicon glyphicon-pencil virtus-pw-padding-sides-02rem"
                aria-hidden="true"></span>
                <span class="glyphicon glyphicon glyphicon glyphicon-remove virtus-pw-padding-sides-02rem"
                aria-hidden="true"></span>
            </div>
        </div>
        <div class="virtus-pw-content-container">
            <div class="row virtus-pw-content-wrapper">
                <div class="col-sm-12 virtus-pw-slide-img-wrapper">
                    <div class="col-sm-12 virtus-pw-content-toolbox-wrapper pw-right-alignement">
                        <!--<span class="pw-alert-color"></span>-->
                        <button type="button" class="btn btn-warning btn-sm modal-toggler-button"
                        aria-label="Left Align"
                        data-toggle="modal"
                        data-target=".pw-modal-videoviewer">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo getTranslation("designunit:content:addcontent", "Add Content");?>
                    </button>
                    <!--<span class="glyphicon glyphicon-pencil pw-alert-color" aria-hidden="true"></span>-->
                </div>
                <img class="virtus-pw-sliderviewer-img" src='../images/widgetsPrototypes/video-mockup.png'>
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
            <?php echo getTranslation("designunit:content:quizwidget", "Quizzes Widget");?>
        </div>
        <div class="virtus-pw-prototype-top-toolbar">
            <span class="glyphicon glyphicon glyphicon glyphicon-info-sign virtus-pw-padding-sides-02rem"
            aria-hidden="true"></span>
            <span class="glyphicon glyphicon glyphicon-pencil virtus-pw-padding-sides-02rem"
            aria-hidden="true"></span>
            <span class="glyphicon glyphicon glyphicon glyphicon-remove virtus-pw-padding-sides-02rem"
            aria-hidden="true"></span>
        </div>
    </div>
    <div class="virtus-pw-content-container">
        <div class="row virtus-pw-content-wrapper">
            <div class="col-sm-12 virtus-pw-quizzes-img-wrapper">
                <div class="col-sm-12 virtus-pw-content-toolbox-wrapper pw-right-alignement">
                    <button type="button" class="btn btn-warning btn-sm modal-toggler-button"
                    aria-label="Left Align"
                    data-toggle="modal"
                    data-target=".pw-modal-quizzes">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo getTranslation("designunit:content:addcontent", "Add Content");?>
                </button>
                <!--<span class="glyphicon glyphicon-pencil pw-alert-color" aria-hidden="true"></span>-->
            </div>
            <img class="virtus-pw-sliderviewer-img" src='../images/widgetsPrototypes/quizzes-mockup.png'>
        </div>
        <div class="col-sm-12 quizzes-question-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
            sed
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
      id="prototypeSlideViewerModal" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>-->
                    <h4 class="modal-title" id="myModalLabel"><?php echo getTranslation("designunit:content:slideswidget", "Slides Widget");?></h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <input name="slidesFile" id="slidesFile" type="file" class="uploadFile" onchange="uploadData(this,'slides','#slides-link')">
                                <label for="slidesFile" class="btn btn-success modal-save-button "><?php echo getTranslation("designunit:content:uploadfile", "Upload File");?></label>
                                <div id="loadingSlides" style="width:32px;height: 32px;"></div>
                            </div>
                            <div class="col-sm-12">
                                <label for="slides-title"><?php echo getTranslation("designunit:content:title", "Title");?></label>
                                <input type="text" class="form-control protocontent"
                                name="slides-title"
                                placeholder="Title" aria-describedby="basic-addon1">
                            </div>
                            <div class="col-sm-12">
                                <label for="slides-link"><?php echo getTranslation("designunit:content:link", "Link");?></label><br>
                                <input type="text" class="form-control protocontent"
                                name="slides-link" id="slides-link"
                                placeholder="http://..." aria-describedby="basic-addon1">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    <button type="button" class="btn btn-success modal-save-button"  data-dismiss="modal"><?php echo getTranslation("designunit:content:apply", "Apply");?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade pw-modal-imageviewer" tabindex="-1" role="dialog" aria-labelledby="modal"
    id="prototypeImageViewerModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                  <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>-->
                  <h4 class="modal-title" id="myModalLabel"><?php echo getTranslation("designunit:content:imagewidget", "Image Widget");?></h4>
              </div>
              <div class="modal-body">
                  <div class="input-group">
                      <div class="row">
                           <div class="col-sm-12">
                                <input name="imageFile" id="imageFile" type="file" class="uploadFile" onchange="uploadData(this,'images','#image-link')">
                                <label for="imageFile" class="btn btn-success modal-save-button "><?php echo getTranslation("designunit:content:uploadfile", "Upload File");?></label>
                                <div id="loadingSlides" style="width:32px;height: 32px;"></div>
                            </div>
                          <div class="col-sm-12">
                              <label for="image-title"><?php echo getTranslation("designunit:content:title", "Title");?></label>
                              <input type="text" class="form-control protocontent"
                              name="image-title"
                              placeholder="Title" aria-describedby="basic-addon1">
                          </div>
                          <div class="col-sm-12">
                              <label for="image-link"><?php echo getTranslation("designunit:content:link", "Link");?></label><br>
                              <input type="text" class="form-control protocontent"
                              name="image-link"
                              placeholder="http://..." aria-describedby="basic-addon1">

                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                  <button type="button" class="btn btn-success modal-save-button"  data-dismiss="modal"><?php echo getTranslation("designunit:content:apply", "Apply");?></button>
              </div>
          </div>
      </div>
  </div>

    <div class="modal fade pw-modal-video" tabindex="-1" role="dialog" aria-labelledby="modal"
    id="prototypeVideoViewerModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>-->
                    <h4 class="modal-title" id="myModalLabel"><?php echo getTranslation("designunit:content:videowidget", "Video Widget");?></h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <input name="videoFile" id="videoFile" type="file" class="uploadFile" onchange="uploadData(this,'videos','#video-link')">
                                <label for="videoFile" class="btn btn-success modal-save-button "><?php echo getTranslation("designunit:content:uploadfile", "Upload File");?></label>
                                <div id="loadingSlides" style="width:32px;height: 32px;"></div>
                            </div>
                            <div class="col-sm-12">
                                <label for="video-title"><?php echo getTranslation("designunit:content:title", "Title");?></label>
                                <input type="text" class="form-control protocontent" id="video-title" name="video-title"
                                placeholder="Title" aria-describedby="basic-addon1">
                            </div>
                            <div class="col-sm-12">
                                <label for="video-link"><?php echo getTranslation("designunit:content:title", "Link");?> (<?php echo getTranslation("designunit:content:videolink", "Video or Audio");?>)</label><br>
                                <input type="text" class="form-control protocontent" id="video-link" name="video-link"
                                placeholder="http://..." aria-describedby="basic-addon1">

                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <button type="button" class="btn btn-success modal-save-button"  data-dismiss="modal"><?php echo getTranslation("designunit:content:apply", "Apply");?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade pw-modal-quizzes" tabindex="-1" role="dialog" aria-labelledby="modal"
id="prototypeQuizzesViewerModal" data-question-ctr="0" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>-->
                    <h4 class="modal-title" id="myModalLabel"><?php echo getTranslation("designunit:content:quizwidget", "Quizzes Widget");?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="video-title"><?php echo getTranslation("designunit:content:title", "Title");?></label>
                                    <input type="text" class="form-control protocontent"
                                    name="quizzes-title"
                                    placeholder="Title" aria-describedby="basic-addon1">
                                </div>
                                <div class="col-sm-12 qa-block-container">
                                    <h4 class=""><?php echo getTranslation("designunit:content:questions", "Questions");?></h4>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    <button type="button" class="btn btn-success modal-add-button"><?php echo getTranslation("designunit:content:addquestion", "Add Question");?> +</button>
                    <button type="button" class="btn btn-success modal-save-button"  data-dismiss="modal"><?php echo getTranslation("designunit:content:apply", "Apply");?></button>
                </div>
            </div>
        </div>
    </div>


    <!-- Templates -->
    <!-- Plugin JavaScript -->
    <script type="text/template" id="answerBlock">
        <div class="col-sm-6 padding-bottom-1em single-answer-block">
            <input type="hidden" name="quizzes-answer-id_0_0" class="protocontent" value="">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="quizzes-answer-correct_0_0" class="protocontent" value="correct">
            </span>
            <input type="text" class="form-control protocontent"
            name="quizzes-answer_0_0" class="protocontent"
            placeholder="Answer" aria-describedby="basic-addon1">
            <span class="input-group-btn">
                <button class="btn btn-secondary remove-answer" type="button">-</button>
            </span>
        </div>
    </div>
</script>


<!-- Plugin JavaScript -->
<script type="text/template" id="questionBlock">
    <div class="panel panel-default" data-answer-ctr="0">
        <div class="panel-heading">
            <h3 class="question-title-counter"><?php echo getTranslation("designunit:content:question", "Question");?> 1</h3>
        </div>
        <div class="panel-body">
            <div class="row qa-div">
                <div class="col-sm-12"><br><button class="btn btn-danger btn-remove-question" type="button"><?php echo getTranslation("general:button:remove", "Remove");?></button><br>
                    <label for="quizzes-question_0"><?php echo getTranslation("designunit:content:question", "Question");?>:</label>
                    <input type="text" class="form-control protocontent"
                    name="quizzes-question_0"
                    placeholder="Question" aria-describedby="basic-addon1">
                    <input type="hidden" name="quizzes-question-id_0" class="protocontent" value="">
                </div>
                <label class="col-sm-12"><?php echo getTranslation("designunit:content:answers", "Answers");?>:</label>
                <div class="checkbox">
                  <div class="col-sm-6 padding-bottom-1em">
                      <button type="button" class="btn btn-default btn-block btn-add-answer">
                          <?php echo getTranslation("designunit:content:addanswer", "Add Answer");?>
                      </button>
                  </div>
              </div>
          </div>
      </div>
  </div>
</script>


<!--Course edit site -->
<!-- ################################################################################### -->

<div id='courses'>
    <div class='container virtus-margin-top-15' style="background: #ff8060; padding: 1em; margin:1em auto;">
      <div class="btn-group" role="group">
        <button type="button" class="btn btn-default btn-block btn-save-courseunit">
            <?php echo getTranslation("designunit:content:save", "Save Changes");?>
        </button>
    </div>

    <span class="message-inprogress"><?php echo getTranslation("designunit:message:inprogress", "Please wait...");?></span>
    <span class="message-stored"><?php echo getTranslation("designunit:message:stored", "Saved successfully!");?></span>
    <span class="message-error"><?php echo getTranslation("designunit:message:error", "An error ocurred. Please refresh.");?></span>
    <span class="message-advice"><?php echo getTranslation("designunit:message:advice", "Changes to widget arrangements and widget contents are only applied after clicking this button!");?></span>
</div>
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
                            <div class="sidebar-title"><?php echo getTranslation("designunit:content:toolbox", "Toolbox");?>:</div>
                        </div>
                    </div>
                    <div class="gridstack-sidebar">

                    </div>
                            <!--<div class="row sidebar-widget-counter-container">
                                <div class="col-sm-12 sidebar-widget-counter-text">total Widgets used:</div>
                                <div class="col-sm-12 sidebar-widget-counter-number">0</div>
                            </div>-->
                            <div class="trash">
                            </div>
                        </div>
                    </div>

                    <!-- List of all courses -->
                    <div class='col-sm-10 virtus-margin-top-15'>
                        <div class="gridstack-canvas-container">
                            <div class="canvas-title"><?php echo getTranslation("designunit:content:rolespace", "ROLE Space");?></div>
                            <div class="grid-stack grid-stack-10 grid-stack-main" id="grid1">
                                <!--<div class="grid-stack-item test" data-gs-x="10" data-gs-y="0" data-gs-width="2" data-gs-height="8" data-gs-no-resize="" data-gs-no-move="" data-gs-locked=""></div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php
} else {
    include 'not_authorized.php';
} ?>
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


<script src="../js/course-list.js"></script>
<!--<script src="../js/widget-arrangement.js"><script/>-->
<script>
    widgetConfiguration = [
    {name: '<?php echo getTranslation("designunit:content:slideswidget", "Slides Widget");?>', prototypeName: 'prototypeSlideViewer', modalname: 'prototypeSlideViewerModal', widgetType: 'slides'},
    {name: '<?php echo getTranslation("designunit:content:videowidget", "Video Widget");?>', prototypeName: 'prototypeVideoViewer', modalname: 'prototypeVideoViewerModal', widgetType: 'video'},
    {name: '<?php echo getTranslation("designunit:content:quizwidget", "Quizzes Widget");?>', prototypeName: 'prototypeQuizzesViewer', modalname: 'prototypeQuizzesViewerModal', widgetType: 'quiz'},
    {name: '<?php echo getTranslation("designunit:content:hangoutwidget", "Video Conference Widget");?>', prototypeName: 'prototypeHangouts', modalname: 'prototypeHangoutsModal', widgetType: 'hangout'},
    {name: '<?php echo getTranslation("designunit:content:imagewidget", "Image Widget");?>', prototypeName: 'prototypeImageViewer', modalname: 'prototypeImageViewerModal', widgetType: 'image'}
    ];

    var totalWidgets = 0; //counting amount of Widgets added, without couting removals (this variable is only used for the indexing of modals within the widgets. Don't use it for something else.



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
            resizable: {
              handles: 'e, w'
            }
            /*height: 8,*/

        };
        $canvas.gridstack(options);

        widgetConfiguration.forEach(function (value, i) {
            createSidebarElement(value.name, i);
        });


        // Load Canvas Elements like that
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
     $('.grid-stack').on('change', function (event, items) {

        $.each(items, function (index, item) {
            var $item = (item.el).find('.grid-stack-sidebar-item');
            if ($item.hasClass('grid-stack-sidebar-item')) {
                    //This one needs to be added
                    var itemIndex = $item.data('index');
                    createSidebarElement(widgetConfiguration[itemIndex].name, itemIndex)
                    $item.removeClass('grid-stack-sidebar-item');
                    $item.html("");

                    transformToWidget(item.el, itemIndex);

                }
            });
    });
 });

    function transformToWidget(item, itemIndex) {
      var $item = (item).find('.grid-stack-item-content');

      var $prototypeWidget = $('#' + widgetConfiguration[itemIndex].prototypeName);
      $prototypeClone = $prototypeWidget.clone();
      $prototypeClone.removeClass('virtus-pw-hide');
      $prototypeClone.attr("id", widgetConfiguration[itemIndex].prototypeName + "-" + totalWidgets);
      $prototypeClone.find(".modal-toggler-button").attr("data-target", "#" + widgetConfiguration[itemIndex].modalname + "-" + totalWidgets);
      (item).attr("data-widget-type", widgetConfiguration[itemIndex].widgetType);
      $item.append($prototypeClone);

      var $prototypeModal = $('#' + widgetConfiguration[itemIndex].modalname);
      $prototypeModalClone = $prototypeModal.clone();
      $prototypeModalClone.attr("id", widgetConfiguration[itemIndex].modalname + "-" + totalWidgets);
      $("body").append($prototypeModalClone);

      var prototypeWidgetId = widgetConfiguration[itemIndex].prototypeName + "-" + totalWidgets;
      var prototypeWidgetModalId = widgetConfiguration[itemIndex].modalname + "-" + totalWidgets;
      $prototypeModalClone.find(".modal-save-button").click(function () {
          appendDataAttributes(prototypeWidgetId, prototypeWidgetModalId);
      });

/*
      $prototypeModalClone.on('hidden.bs.modal', function (e) {
          // does not work -> backdrock set to static and dismiss buttons removed
          appendDataAttributes(prototypeWidgetId, prototypeWidgetModalId);
      });
*/

      $('.modal-add-button').click(function () {
          var $qb = $('#questionBlock').html();
          var count = $(this).parents(".modal-content").find(".qa-block-container").find(".question-title-counter")
          var aNum = count.length + 1;

          $(this).parents(".modal-content").find(".qa-block-container").append($qb);
          var $elem = $(this).parents(".modal-content").find(".qa-block-container").find('.panel-default').last();
          $elem.find(".question-title-counter").text("Question " + aNum);

          var qorder = parseInt( $elem.parents(".modal").attr("data-question-ctr") );
          $elem.parents(".modal").attr("data-question-ctr", qorder+1);

          $elem.find("[name=quizzes-question_0]").attr("name", "quizzes-question_" + qorder);
          $elem.find("[name=quizzes-question-id_0]").attr("name", "quizzes-question-id_" + qorder);
          $elem.attr("data-question-id", qorder);

          quizzesButtonFunc($elem);
      });

      totalWidgets++;
  }

  function quizzesButtonFunc($elem) {
    $elem.find(".btn-remove-question").click(function() {
      var container = $(this).parents(".qa-block-container");
      $(this).parents(".panel-default").remove();
      container.find(".question-title-counter").each(function (index) {
          $(this).html("Question "+ (index +1));
      });
  });

    $elem.find(".btn-add-answer").click(function () {
        var template = $("#answerBlock").html();
        template = $(template).insertBefore($(this).parent());

        var qorder = parseInt( $(template).parents(".panel").attr("data-question-id") );
        var aorder = parseInt( $(template).parents(".panel").attr("data-answer-ctr") );
        $(template).parents(".panel").attr("data-answer-ctr", aorder+1);

        $(template).find("[name=quizzes-answer_0_0]").attr("name", "quizzes-answer_" + qorder + "_" + aorder);
        $(template).find("[name=quizzes-answer-id_0_0]").attr("name", "quizzes-answer-id_" + qorder + "_" + aorder);
        $(template).find("[name=quizzes-answer-correct_0_0]").attr("name", "quizzes-answer-correct_" + qorder + "_" + aorder);

            //qa-div
            $(template).find('.remove-answer').click(function () {
                qaparent = $(this).parent(".qa-div");
                $(this).parents(".single-answer-block").remove();
                removeButtons = $(qaparent).find(".remove-answer")
                if (removeButtons.length <= 2) {
                    removeButtons.each(function () {
                        $(this).prop('disabled', true);
                    })
                }
            });
            removeButtons = $(this).parent().parent().find(".remove-answer");
            removeButtons.each(function () {
                $(this).prop('disabled', false);
            });

        });

}

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

        // clean attributes
        var toRemove = [];
        $.each($widget.parent().parent().get(0).attributes, function() {
          if(this.specified &&
              ( this.name.startsWith("data-video") || this.name.startsWith("data-quizzes") || this.name.startsWith("data-slides") ) ) {
            toRemove.push(this.name);
          }
        });
        toRemove.forEach(function(val) {
          $widget.parent().parent().removeAttr( val );
        })

        // set attributes
        $inputObj = $modal.find(".modal-body").find(".protocontent");
        $inputObj.each(function (index) {
          //For unknown reason, replacing attr() with data() does not work
          var value = $(this).val();
          if ($(this).is(':checkbox') && !$(this).prop('checked')) {
            value="";
          }

          $widget.parent().parent().attr("data-" + $(this).attr("name"), value);
      });
    }

    function setStateFromDataAttributes(widgetId, modalId) {
        $widget = $("#" + widgetId);
        $modal = $("#" + modalId);

        // add questions and answers for quiz
        if ($widget.parent().parent().attr("data-widget-type") == "quiz") {
          for (var i = 0; i < parseInt($widget.parent().parent().attr("data-tmp-question-count")); i++) {
            $modal.find(".modal-add-button").click();
            var $question = $modal.find(".panel-default").last();
            for (var j = 0; j < parseInt($widget.parent().parent().attr("data-tmp-answer-count_" + i)); j++) {
              $question.find(".btn-add-answer").click();
            }
          }
        }

        $inputObj = $modal.find(".modal-body").find(".protocontent");
        $inputObj.each(function (index) {
          if ($(this).is(':checkbox')) {
            $(this).prop('checked', $widget.parent().parent().attr("data-" + $(this).attr("name")) != "");
          }
          else {
            $(this).val($widget.parent().parent().attr("data-" + $(this).attr("name")));
          }
        });
      }

function spaceToJson() {
  var widgetSerializer = {
    slides: function(el) {
        return {
          type: "slides",
          title: el.attr("data-slides-title"),
          link: el.attr("data-slides-link")
      };
    },
    image: function(el) {
        return {
          type: "image",
          title: el.attr("data-image-title"),
          link: el.attr("data-image-link")
      };
    },
    video: function(el) {
      return {
        type: "video",
        title: el.attr("data-video-title"),
        link: el.attr("data-video-link")
      };
    },
    quiz: function(el) {
      var questions = {};

      $.each(el.get(0).attributes, function() {
        if(this.specified) {
          var nameSplit = this.name.split("_");
          if (nameSplit[0] == "data-quizzes-question") {
            questions[nameSplit[1]] = {
              id: el.attr("data-quizzes-question-id_" + nameSplit[1]),
              title: el.attr("data-quizzes-question_" + nameSplit[1]),
              answers: {}
            }
          }
        }
      });

      $.each(el.get(0).attributes, function() {
        if(this.specified) {
          var nameSplit = this.name.split("_");
          if (nameSplit[0] == "data-quizzes-answer") {
            questions[nameSplit[1]].answers[nameSplit[2]] =  {
              id: el.attr("data-quizzes-answer-id_" + nameSplit[1]+ "_" + nameSplit[2]),
              title: el.attr("data-quizzes-answer_" + nameSplit[1]+ "_" + nameSplit[2]),
              correct: el.attr("data-quizzes-answer-correct_" + nameSplit[1]+ "_" + nameSplit[2])
          }
        }
      }
      });

      return {
        type: "quiz",
        title: el.attr("data-quizzes-title"),
        questions: questions
      };
    },
    hangout: function(el) {
      return { type: "hangout" };
    },
  }

var result = [];
$("#grid1").find(".grid-stack-item").each(function(idx,el) {
    result.push({
      "element_id": $(el).attr("data-element-id"),
      "widget": widgetSerializer[$(el).attr("data-widget-type")]($(el)),
      "x": $(el).attr("data-gs-x"),
      "y": $(el).attr("data-gs-y"),
      "width": $(el).attr("data-gs-width"),
      "height": $(el).attr("data-gs-height")
  });
});

return result;
}

function jsonToSpace(data) {
  var widgetDeserializer = {
    slides: function(el, data) {
      el.attr("data-slides-title", data.title);
      el.attr("data-slides-link", data.link);
  },
  image: function(el, data) {
    el.attr("data-image-title", data.title);
    el.attr("data-image-link", data.link);
  },
  video: function(el, data) {
      el.attr("data-video-title", data.title);
      el.attr("data-video-link", data.link);
  },
  quiz: function(el, data) {
      el.attr("data-quizzes-title", data.title);

      if (data.questions == undefined) return;

      el.attr("data-tmp-question-count", Object.keys(data.questions).length);

      for (var qid in data.questions) {
        if (!data.questions.hasOwnProperty(qid)) continue;
        var question = data.questions[qid];

        el.attr("data-quizzes-question_" + qid, question.title);
        el.attr("data-quizzes-question-id_" + qid, question.id);

        el.attr("data-tmp-answer-count_" + qid, Object.keys(question.answers).length);

        for (var aid in question.answers) {
          if (!question.answers.hasOwnProperty(aid)) continue;
          var answer = question.answers[aid];

          el.attr("data-quizzes-answer_" + qid + "_" + aid, answer.title);
          el.attr("data-quizzes-answer-id_" + qid + "_" + aid, answer.id);
          el.attr("data-quizzes-answer-correct_" + qid + "_" + aid, answer.correct);
      }
    }
  },
  hangout: function(el, data) {
  },
}

      // TODO
      //$canvas.cellHeight($canvas.height);

      var grid = $('#grid1').data('gridstack');

      _.each(data, function (el) {
         // get widget config for type
         for(var itemIndex = 0; itemIndex < widgetConfiguration.length; itemIndex ++) {
             if (widgetConfiguration[itemIndex].widgetType == el.widget.type)
                break;
        }

         // add widget
         var widget = $('<div><div class="grid-stack-item-content"></div></div>');
         grid.addWidget(widget, el.x, el.y, el.width, el.height);
         transformToWidget(widget, itemIndex);

         // set data attributes
         widget.attr("data-element-id", el.element_id);
         widget.attr("data-widget-type", el.widget.type);
         widgetDeserializer[el.widget.type](widget, el.widget);

         // set state
         var prototypeWidgetId = widgetConfiguration[itemIndex].prototypeName + "-" + (totalWidgets-1);
         var prototypeWidgetModalId = widgetConfiguration[itemIndex].modalname + "-" + (totalWidgets-1);
         setStateFromDataAttributes(prototypeWidgetId, prototypeWidgetModalId);
     }, this);
  }

  function clear() {
      //totalWidgets = 0;
      var grid = $('#grid1').data('gridstack');
      try {
        grid.removeAll()
    } catch(e) {}
}

$(function() {
  $(".btn-save-courseunit").click(function() {
    console.log(JSON.stringify(spaceToJson()));
    $(".btn-save-courseunit").prop('disabled', true);
    showProgress();
    $.ajax( {
      method: "POST",
      url: "../php/edit_script_courseunit_elements.php?courseid=<?php echo $course_id; ?>&unitid=<?php echo $unit_id; ?>&unitlang=<?php echo $course_lang; ?>&store",
      data: JSON.stringify(spaceToJson())
  })
    .done(function(data) {
      clear();
      jsonToSpace(JSON.parse(data));
      $(".btn-save-courseunit").prop('disabled', false);
      showSuccess();
  })
    .fail(function(data) {
      showError();
      alert( "error: " + data );
  });
});
});

$(function() {
  $(".btn-save-courseunit").prop('disabled', true);
  showProgress();

  $.ajax( "../php/edit_script_courseunit_elements.php?courseid=<?php echo $course_id; ?>&unitid=<?php echo $unit_id; ?>&unitlang=<?php echo $course_lang; ?>")
  .done(function(data) {
    clear();
    jsonToSpace(JSON.parse(data));
    $(".btn-save-courseunit").prop('disabled', false);
    showAdvice();
})
  .fail(function(data) {
    showError();
    alert( "error: " + data );
});
});

$(function() {
  $(".message-inprogress").hide();
  $(".message-stored").hide();
  $(".message-error").hide();
  $(".message-advice").show();
});

function showProgress() {
  $(".message-inprogress").show();
  $(".message-stored").hide();
  $(".message-error").hide();
  $(".message-advice").hide();
}

function showAdvice() {
  $(".message-inprogress").hide();
  $(".message-stored").hide();
  $(".message-error").hide();
  $(".message-advice").show();
}

function showError() {
  $(".message-inprogress").hide();
  $(".message-stored").show();
  $(".message-error").hide();
  $(".message-advice").hide();
}

function showSuccess() {
  $(".message-inprogress").hide();
  $(".message-stored").show();
  $(".message-error").hide();
  $(".message-advice").hide();

  setTimeout(showAdvice, 1000);
}

function uploadData(handler,type,label){
    var file_data = handler.files[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('type', type);
    $.ajax({
                url: '../php/upload.php', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(php_script_response){
                    var x = handler.closest('.modal-body');
                    x.querySelector(label).setAttribute("value",php_script_response);
                }
     });
}

</script>
</body>
</html>
