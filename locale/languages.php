<?php
/**
 * Created by PhpStorm.
 * User: Sabine
 * Date: 11.01.2017
 * Time: 17:34
 */
function getLanguageFullName ($languageCode) {
    $languageMap = array(
        "en" => "English",
        "de" => "Deutsch",
        "es" => "Español",
        "it" => "Italiano",
        "gr" => "ελληνικά"
    );

    // return code if no mapping is included above
    $languageName = $languageCode;
    if (array_key_exists($languageCode, $languageMap)) {
        $languageName = $languageMap[$languageCode];
    }
    return $languageName;
}

?>