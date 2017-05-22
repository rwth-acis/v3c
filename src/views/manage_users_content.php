<?php
/**
 * Created by PhpStorm.
 * User: Tilman
 * Date: 04.02.2017
 * Time: 16:40
 */

$user_list = $db->query("SELECT * FROM users
                                  LEFT JOIN organizations
                                  ON users.affiliation = organizations.id
                                  ORDER BY family_name")->fetchAll(); // TODO not set if no affiliation exists...

require '../php/db_connect.php';
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
                                   placeholder="<?php
                echo getTranslation("usermanagement:search:name", "Search by Name");
                ?>"
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
                                        "Family Name"); ?>,
                                    <?php echo getTranslation("usermanagement:choose:given_name",
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
                                echo "<form METHOD='POST' action='../php/update_users.php' enctype='multipart/form-data'>";
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
                                echo "<option value='NULL'>-</option>";
                                foreach ($orgas as $orga_id => $orga) {
                                    $selected = ($user['affiliation'] == $orga_id) ? "selected" : "";
                                    echo "<option value='$orga_id' $selected>$orga</option>";
                                }
                                echo "</select>";
                                echo "</td>";
                                echo "<td><input type='submit' class='btn btn-success btn-sm btn-block' value='" . getTranslation("usermanagement:button:update",
                                        "Update User") . "'></td>";
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
<script src="../js/filter-users.js"></script>
