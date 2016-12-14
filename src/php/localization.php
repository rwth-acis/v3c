<?php
/**
 * Created by PhpStorm.
 * User: Sabine
 */

//require_once $_SERVER['DOCUMENT_ROOT'] . "/locale/translations_de.php";

function getTranslation($key, $default)
{
    require_once "locale.php";
    /*
     * gettext
    $translation = gettext($key);
    if ($key != $translation) {
        return $translation;
    }
    */


    $filename = $_SERVER['DOCUMENT_ROOT'] . "/locale/translations_". $_SESSION["lang"]  .".php";

    if (file_exists($filename)) {
        //echo $filename;
        require_once $filename;
        $lang = getLanguage();

        if (array_key_exists ($key, $lang )) {
            return $lang[$key];
        }
    }

    return $default;
}
?>