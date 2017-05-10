<?php
// This script is included in phpBBs common.php and redirects to the Virtus Website if the user is not authenticated

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request->enable_super_globals();
$url =  $_SERVER['REQUEST_URI'];
$request->disable_super_globals();

if (!defined('DISABLE_V3C_REDIRECT') && !endsWith($url, "ucp.php?mode=login")) {
  $user->session_begin();
  $auth->acl($user->data);
  $user->setup();

  if(!$user->data['is_registered']) {
    header("Location: http://virtus-vet.eu/");
    exit;
  }
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

?>
