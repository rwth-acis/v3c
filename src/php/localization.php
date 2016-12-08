<?php
/**
 * Created by PhpStorm.
 * User: Sabine
 */

function setLanguage($language)
{
    if (!function_exists("gettext"))
    {
        echo "gettext not installed\n";
    }

    putenv("LANG=" . $language); // Linux
    putenv("LC_ALL=" . $language); // windows
    setlocale(LC_ALL, $language);

    // domain is the name of the files ($domain . ".po")
    $domain = "default";
    bindtextdomain($domain, '../../locale');
    bind_textdomain_codeset($domain, 'UTF-8');
    textdomain('default');
}

function getTranslation($key, $default)
{
    $translation = gettext($key);
    if ($key != $translation) {
        return $translation;
    }
    return $default;
}
?>