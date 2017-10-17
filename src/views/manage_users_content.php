<?php
/**
 * Created by PhpStorm.
 * User: Tilman
 * Date: 04.02.2017
 * Time: 16:40
 */

$user_list = $db->query("SELECT family_name,given_name,users.email,date_updated,role,affiliation,openIdConnectSub FROM users
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
                echo getTranslation("usermanagement:search", "Search by");
                ?>"
                                   onkeyup="selectFilter();">
                                   <select name='searchType' id="searchType" onchange="selectFilter()" style="margin-left: 3px;">
                                       <option value="0">Name</option>
                                       <option value="1">Email</option>
                                       <option value="2">Last Updated</option>
                                       <option value="4">Affliation</option>
                                   </select><div style="display:inline;margin-left: 3px;">Found: <div id="userCount" style="display:inline;">0</div></div>
                            <br/>

                        </div>
                    </form>
                </div>

                <!-- List of all users -->
                <div class='col-sm-11'>
                    <div>
                        <table id="user-table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th onclick="sortTable(0);switchClass(this);" style="cursor: pointer; cursor: hand;"><?php echo getTranslation("usermanagement:choose:family_name",
                                        "Family Name"); ?>,
                                    <?php echo getTranslation("usermanagement:choose:given_name",
                                        "Given Name"); ?><i class="hidden"></i></th>
                                <th onclick="sortTable(1);switchClass(this);" style="cursor: pointer; cursor: hand;"><?php echo getTranslation("usermanagement:choose:email", "Email"); ?><i class="hidden"></i></th>
                                <th onclick="sortTable(2);switchClass(this);" style="cursor: pointer; cursor: hand;"><?php echo getTranslation("usermanagement:choose:updated", "Last Updated"); ?><i class="hidden"></i></th>
                                <th onclick="sortTable(3);switchClass(this);" style="cursor: pointer; cursor: hand;"><?php echo getTranslation("usermanagement:choose:role", "Role"); ?><i class="hidden"></i></th>
                                <th onclick="sortTable(4);switchClass(this);" style="cursor: pointer; cursor: hand;"><?php echo getTranslation("usermanagment:choose:affiliation",
                                        "Affiliation"); ?><i class="hidden"></i></th>
                                <th></th> <!--column for submit buttons -->
                            </tr>
                            </thead>
                            <tbody data-link="row" class="rowlink">
                            <?php
                            foreach ($user_list as $user) {

                                echo "<tr'><td>" . $user['family_name'] . ", " . $user['given_name'] . "</td>";
                                echo "<td>" . $user['email'] . "</td>";
                                echo "<td class='lu'>" . $user['date_updated'] . "</td>";
                                echo "<form METHOD='POST' action='../php/update_users.php' enctype='multipart/form-data'>";
                                echo "<input type='hidden' name='sub' value='".$user['openIdConnectSub']."'>";
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
                                $selected = ($user['affiliation'] == "") ? "selected" : "";
                                echo "<option value='NULL' $selected>-</option>";
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
<script>
// c&p and adjusted https://www.w3schools.com/howto/howto_js_sort_table.asp
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("user-table");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++; 
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
function switchClass(div) {
  var subDiv = div.querySelector('i');
  var className = subDiv.getAttribute("class");
  if(className=="hidden"|| className=="down") {
    $("i").attr('class', 'hidden');
    subDiv.className = "up";
  }
  else{
    $("i").attr('class', 'hidden');
    subDiv.className = "down";
  }
}

function selectFilter(){
    var el = document.getElementById('searchType');
    var i = el.options[el.selectedIndex].value;
    filter(i);
    var rows = $('#user-table tbody tr').length;
    var hidden = $('#user-table tbody tr[style*="display"]').length;
    $("#userCount").html(rows-hidden); 
}
var rows = $('#user-table tbody tr').length;
$("#userCount").html(rows);
</script>
<script src="../js/filter-users.js"></script>
