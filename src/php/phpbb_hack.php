<?php
// This script is included in phpBBs common.php and redirects to the Virtus Website if the user is not authenticated

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!defined('DISABLE_V3C_REDIRECT')) {
  $user->session_begin();
  $auth->acl($user->data);
  $user->setup();

  if(!$user->data['is_registered']) {
    header("Location: http://virtus-vet.eu/");
    exit;
  }
}

?>
