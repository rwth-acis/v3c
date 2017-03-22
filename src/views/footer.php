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
