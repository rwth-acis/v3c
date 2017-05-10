<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include '../php/db_connect.php';
include '../php/tools.php';
include '../php/access_control.php';


define('IN_PHPBB', true);
define('DISABLE_V3C_REDIRECT', true);
$phpbb_root_path = "../../forum/";
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/functions_user.'.$phpEx);

$accessControl = new AccessControl();
$access = $accessControl->canEnterLecturerMode() || $accessControl->isAdmin();


if ($access) { // sign in to phpbb
  $username = str_replace(' ', '', $_SESSION['given_name'] . $_SESSION['family_name']);
  $password = hash('sha256', $_SESSION['sub']); // super secret!

  if (!registerIfNotExistsToPhpBB($username, $password, $_SESSION['email'], $_SESSION['given_name'], $_SESSION['family_name'])) {
    echo "Sorry, registration in phpBB failed!";
    exit;
  }

  if (!loginToPhpBB($username, $password)) {
    echo "Sorry, cannot login to phpBB!";
    exit;
  }

  header("Location: http://virtus-vet.eu/forum");
  exit;
} else { // not authorized
  echo "Sorry, you do not have permission to access the forum!";
  exit;
}

function registerIfNotExistsToPhpBB($username, $password, $email, $given_name, $family_name) {
  $user_id_ary = array();
  $username_ary = array(0 => $username);
  if (user_get_id_name($user_id_ary, $username_ary) == "NO_USERS") { // user does not exist
    // register
    $user_row = array(
        'username'              => $username,
        'user_password'         => phpbb_hash($password),
        'user_email'            => $email,
        'group_id'              => (int) 4,
//        'user_lang'             => "en",
        'user_type'             => USER_NORMAL,
    );
    $user_id = user_add($user_row);
    return $user_id != false;
  }
  else { // already registered
    return true;
  }
}

function loginToPhpBB($username, $password) {
  global $user;
  global $auth;

  // Start session management
  $user->session_begin();
  $auth->acl($user->data);
  $user->setup();

  if($user->data['is_registered']) {
    // User is already logged in
    $user->session_kill();
    $user->session_begin();
  }

  $result = $auth->login($username, $password);

  return ($result['status'] == LOGIN_SUCCESS);
}

?>
