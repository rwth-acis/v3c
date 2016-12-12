<?php
// use sessions
//session_start();
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
$_SESSION["Language"]  = $language;

/*
$folder = '../../locale';
$domain = "default";
$encoding = "UTF-8";

putenv("LANG=" . $language);
putenv("LC_ALL=" . $language);
setlocale(LC_ALL, $language);

if ($gettextinstalldir != "") {
    require_once($gettextinstalldir);
    T_setlocale(LC_MESSAGES, $language);

}

bindtextdomain($domain, $folder);
bind_textdomain_codeset($domain, $encoding);

textdomain($domain);
*/