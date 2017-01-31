<?php
/**
 * Created by PhpStorm.
 * User: Sabine
 */

// returns a list of supported languages for dropdown with language code for dropdown flags
function getSelectableLanguages() {

    $path = $_SERVER['DOCUMENT_ROOT'] . "/locale/";
    require_once $path . "languages.php";

    $files = array_diff(scandir($path), array('.', '..'));

    $languages = array();

    // get every translation file and check which languages are supported
    foreach ($files as $file) {
        $pattern = "translations_";
        // languagecode might look like: "de" or "de_DE", "en", "en_us" ..
        // only use files that match pattern "translation_<languagecode>.php
        if (substr($file, 0, strlen($pattern)) === $pattern) {

            // extract language code (see pattern above)
            $languageCode = substr($file,
                strpos($file, $pattern) + strlen($pattern), // starting after pattern
                strlen($file) - strlen(".php") - strlen($pattern)); // exclude ending .php

            // get language name in the language itself
            // currently extracted from array in languages.php.
            // Could also use Locale::getDisplayLanguage
            $languages[$languageCode] = getLanguageFullName($languageCode);
        }
    }
    return $languages;
}

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

function template_substitution($template, $data)
{
    $result = $template;
    foreach ($data as $key => $value) {
        $result = str_replace($key, $value, $result);
    }
    return $result;
}

?>