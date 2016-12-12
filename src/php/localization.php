<?php
/**
 * Created by PhpStorm.
 * User: Sabine
 */

function getTranslation($key, $default)
{
    require_once "locale.php";
    /*
    $translation = gettext($key);
    if ($key != $translation) {
        return $translation;
    }
    */
    $lang = array(
        # general
        "general:button:home" => "Startseite",
        "general:button:courses" => "Kurse",
        "general:button:signin" => "Anmelden",
        "main:welcome:headline" =>"Willkommen im V3C Projekt!",
        "main:welcome:v3cgoal" => "Das “Virtual Vocational Education and Training – VIRTUS” Projekt entwickelt eine innovative, voll funktionsfähige vitruelle Ausbildungs- und Trainigsplattform. Es bietet angemessen modular zertifizierete Kurse in Modular Employable Skills (MES), angepasst an eine weite Bandbreite an Umständen wie reginale Wachstumspotentiale und/oder Geschäftsumstrukturierung. Das Ziel ist die Erhöhung der Anzahl der Teilnehmerzahl Erwachsener in Ausbildungen.",
        "main:welcome:v3ccourses" => "Das virtuell VET Center bietet derzeit folgende modular zertifizierte Kurse:",
        "main:welcome:tourism" => "Tourismus und Gastgewerbe",
        "main:welcome:social" => "Social Entrepreneurship",
        "main:welcome:courses" => "Kurse",
        "main:welcome:listcourses" => "Für eine vollständige Liste aller Kurse klicken Sie hier."

    );

    if ($_SESSION["Language"] == "de") {

        if (array_key_exists ($key, $lang )) {
            return $lang[$key];
        }
    }

    return $default;
}
?>