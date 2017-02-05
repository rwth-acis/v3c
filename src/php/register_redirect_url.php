<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION["currentPage"] = filter_input(INPUT_POST, 'requestUri');