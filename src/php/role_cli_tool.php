<?php
/**
* ROLE command line tool
* This script allows to recreate the whole ROLE database from the V3C database in case of data loss.
* Also, single courses and units can be repopulated in case if an error occurred.
* Use with caution!
*
* Recreate whole DB: php role_cli_tool.php database
* Recreate course: php role_cli_tool.php course <id>
* Recreate unit:  php role_cli_tool.php unit <id>
*/

if (php_sapi_name() != "cli") {
    die("Please use this tool from command line!\n");
}

include "role_database_sync.php";
$role = new RoleSync();

if (sizeof($argv) < 2) die("Invalid usage!\n");

if ($argv[1] == "database") {
  echo "Recreating whole database. Please wait ...\n";
  $role->recreateRole();
  echo "Done.\n";
}
else if ($argv[1] == "course") {
  if (sizeof($argv) < 3) die("Invalid usage!\n");
  $id = $argv[2];

  echo "Recreating course. Please wait ...\n";
  $role->recreateCourseSpace($id);
  echo "Done.\n";
}
else if ($argv[1] == "unit") {
  if (sizeof($argv) < 3) die("Invalid usage!\n");
  $id = $argv[2];

  echo "Recreating unit. Please wait ...\n";
  $role->recreateUnitActivity($id);
  echo "Done.\n";
}
else {
  die("Invalid usage!\n");
}

?>
