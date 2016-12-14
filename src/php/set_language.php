<?php

if (!isset($_GET["setlang"])) {
    echo 'setlang was not set';
    return;
}

$lang = htmlspecialchars(stripcslashes(trim($_GET["setlang"])));

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION["lang"] = $lang;

echo 'changed langauge to ' . $lang;