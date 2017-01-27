<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | V3C</title>

    <link rel="stylesheet" href="../external/jasny-bootstrap/dist/css/jasny-bootstrap.min.css"/>
</head>

<body>
<?php

include("menu.php");

// Get all entries from the user table in the database

include '../php/db_connect.php';
include '../php/tools.php';

$user_list = $db->query("SELECT * FROM users
                                  JOIN organizations
                                  ON users.affiliation = organizations.id
                                  ORDER BY family_name")->fetchAll();

require_once '../php/db_connect.php';
//prepare role array for select boxes
$role_object = $db->query("SELECT * FROM roles ORDER BY id ASC")->fetchAll();
foreach ($role_object as $role_el) {
    $roles[$role_el['id']] = $role_el['role'];
}
//prepare organizations array for select boxes
$orga_object = $db->query("SELECT * FROM organizations ORDER BY id ASC")->fetchAll();
foreach ($orga_object as $orga_el) {
    $orgas[$orga_el['id']] = $orga_el['name'];
}



$user_update_notice = "";
//TODO Info about Update result

?>

<header id='head' class='secondary'>
    <div class='container'>
        <div class='row'>
            <h1><?php
                echo getTranslation("usermanagement:head:headline", " Manage Users");
                ?></h1>
        </div>
    </div>
</header>

<div id='users'>
    <section class='container'>
        <div class='container'>

            <div class='row'>

                <div class="row col-sm-12">

                    <?php echo $user_update_notice;
                    //DEBUG print_r($_SESSION);

                    ?>

                    <form id="fsearch" class="navbar-form navbar-left" role="search">
                        <div class="row">
                                <input id="searchString" name="searched" type="text" class="form-control"
                                       placeholder="Search by Name"
                                       onkeyup="filter()">
                                <br/>
                        </div>
                    </form>
                </div>

                <!-- List of all users -->
                <div class='col-sm-8'>
                    <div>
                        <table id="user-table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th><?php echo getTranslation("usermanagement:choose:family_name",
                                        "Family Name"); ?>
                                    , <?php echo getTranslation("usermanagement:choose:given_name",
                                        "Given Name"); ?></th>
                                <th><?php echo getTranslation("usermanagement:choose:role", "Role"); ?></th>
                                <th><?php echo getTranslation("usermanagment:choose:affiliation",
                                        "Affiliation"); ?></th>
                                <th></th> <!--column for submit buttons -->

                            </tr>
                            </thead>
                            <tbody data-link="row" class="rowlink">
                            <?php
                            foreach ($user_list as $user) {
                                echo "<tr><td>" . $user['family_name'] . ", " . $user['given_name'] . "</td>";
                                echo "<form METHOD='POST' action='../php/update_users.php'>";
                                echo "<input type='hidden' name='sub' value='$user[openIdConnectSub]'>";
                                echo "<td>";
                                echo "<select name='role'>";
                                foreach ($roles as $role_id => $role) {
                                    $selected = ($user['role'] == $role_id) ? "selected" : "";
                                    echo "<option value='$role_id' $selected>$role</option>";
                                }
                                echo "</select>";
                                echo "</td>";
                                echo "<td>";
                                echo "<select name='orga'>";
                                foreach ($orgas as $orga_id => $orga) {
                                    $selected = ($user['affiliation'] == $orga_id) ? "selected" : "";
                                    echo "<option value='$orga_id' $selected>$orga</option>";
                                }
                                echo "</select>";
                                echo "</td>";
                                echo "<td><button type='submit' class='btn btn-success btn-sm btn-block' id='SubmitButton' value='Update User'>Update User</button></td>";
                                echo "</form></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
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
<script src="../external/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
<script src="../js/course-list.js"></script>
<script src="../js/search-course.js"></script>
<script src="../js/filter-users.js"></script>
</body>
</html>
