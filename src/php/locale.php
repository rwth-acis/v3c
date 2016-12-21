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
if (strlen ($language) <= 5) {
// save language preference for future page requests
    $_SESSION["lang"] = $language;
} else {
    echo "Selected language is not supported!";
}

