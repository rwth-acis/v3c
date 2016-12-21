<?php
/**
 * Created by PhpStorm.
 * User: Sabine
 */

//require_once $_SERVER['DOCUMENT_ROOT'] . "/locale/translations_de.php";

function getTranslation($key, $default)
{
    // set the current language to session if not dne already:
    require_once "locale.php";

    // file includes all translated keys
    $filename = $_SERVER['DOCUMENT_ROOT'] . "/locale/translations_". $_SESSION["lang"]  .".php";

    $translation = $default;

    if (file_exists($filename)) {
        require_once $filename;
        $lang = getLanguage();

        if (array_key_exists ($key, $lang )) {
            $translation =  $lang[$key];
        }
    }

    return $translation;
}

function template_substitution($template, $data) {
    $result = $template;
    foreach ($data as $key => $value) {
        $result = str_replace($key, $value, $result);
    }
    return $result;
}

?>