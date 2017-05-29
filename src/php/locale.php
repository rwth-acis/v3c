<?php

// TODO: Make this a service to set the site's language

require_once '../config/config.php';

// Start session if necessary
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get language preferences
if (isset($_GET["sitelang"])) {
    $language = $_GET["sitelang"];
} else if (isset($_SESSION["lang"])) {
    $language  = $_SESSION["lang"];
} else {
    $language = "en";
}

if (strlen ($language) == 2) {
    // Save language preference for future page requests
    $_SESSION["lang"] = $language;
}

