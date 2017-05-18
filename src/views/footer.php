<?php require_once '../php/access_control.php';
$accessControl = new AccessControl(); ?>

<footer id="footer">
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
                            <a href="welcome.php"><?php echo getTranslation("general:button:home", "Home");?></a> |
                            <a href="subjects.php"><?php echo getTranslation("general:button:courses", "Courses");?></a> |
                            <a href="help.php"><?php echo getTranslation("general:button:help", "Help");?></a>
                            <?php if ($accessControl->isAdmin()) { ?> | <a href="manage_users.php">Manage
                                Users</a> <?php } ?>
                        </p>
                    </div>
                </div>

                <div class="col-md-6 panel">
                    <div class="panel-body">
                        <p class="text-right">
                            <?php echo getTranslation("general:footer:virtus", "VIRTUS Virtual Vocational Training Centre");?>
                        </p>
                        <p class="text-right"><!-- <?php echo getTranslation("general:footer:reach", "Reach us at: ");?><a href=""></a> -->
                        </p>
                    </div>
                </div>
            </div>
            <!-- /row of panels -->
        </div>
    </div>
</footer>

<div class="container">
  <img  src="http://virtus-project.eu/wp-content/uploads/2016/06/erasmus_pie-83.png" style="float:right; margin: 0.5rem; max-width:20rem;" />
  <h6 style="text-align: justify;"><?php echo getTranslation("general:footer:erasmus", "This project has been funded with support from the European Commission. This publication reflects the views only of the author, and the Commission cannot be held responsible for any use which may be made of the information contained therein.");?></h6>
  <h6>PROJECT NUMBER – 562222-EPP-1-2015-1-EL-EPPKA3-PI-FORWARD</h6>
  <div class="clear"></div>
  <!--CLEAR FLOATS-->
</div>
