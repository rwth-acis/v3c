<?php
/**
 * Created by PhpStorm.
 * User: Sabine
 */

function getTranslation($key, $default)
{
    require_once "locale.php";
    $translation = gettext($key);
    if ($key != $translation) {
        return $translation;
    }
    return $default;
}
?>