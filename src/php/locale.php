<?php
// use sessions
/*if () {
    session_start();
}
*/
require '../config/config.php';
// get language preference
if (isset($_GET["lang"])) {
    $language = $_GET["lang"];
}
else if (isset($_SESSION["lang"])) {
    $language  = $_SESSION["lang"];
}
else {
    $language = "en";
}

// save language preference for future page requests
$_SESSION["lang"]  = $language;

