<?php
/**
 * Created by PhpStorm.
 * User: Rouchdi
 * Date: 12/14/2016
 * Time: 3:09 PM
 */

session_start();

//create database connection (needs to be done before mysql_real_escape_string)
$conn = require '../php/db_connect.php';


$language = filter_input(INPUT_POST, 'lang');
$subject_id = filter_input(INPUT_POST, 'subject_id');

//$courses = $db->query("SELECT courses.*, users.given_name AS creator_firstname, users.family_name AS creator_lastname
//                           FROM courses JOIN users ON courses.creator=users.email
//                           WHERE courses.domain='$subject_id'
//                           AND courses.lang = '$language'")->fetchAll();

$courses = $db->query("SELECT courses.*, organizations.name AS orga, organizations.email AS orga_email 
                           FROM courses JOIN organizations ON courses.creator=organizations.email 
                           WHERE courses.domain='$subject_id'
                           ORDER BY id ASC")->fetchAll();
//AND courses.lang = '$language'
echo "<table class=\"table table-striped table-bordered table-hover\">
                        <thead>
                        <tr>
                            <th>Course name</th>
                            <th>Created by</th>
                            <th>Start Dates</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody data-link=\"row\" class=\"rowlink\">";

$index = 0;
for ($cntr = 0; $cntr < count($courses); $cntr++) {
    $initCntr = $cntr;
    $lang_array = array($courses[$cntr]["lang"]);
    while ($cntr <= count($courses)) {
        if ($courses[$cntr]["id"] == $courses[$cntr + 1]["id"]) {
            if ($language == $courses[$cntr + 1]["lang"]) {
                $initCntr = $cntr + 1;
                array_unshift($lang_array, $courses[$cntr + 1]["lang"]);

            } else {
                array_push($lang_array, $courses[$cntr + 1]["lang"]);
            }
            $cntr++;
        } else {
            break;
        }
    }
    print_r($lang_array);
    // Add line brake after each date for more readability in the table
    $course_dates_array = explode("\n", $courses[$initCntr]["date_created"]);
    $index++;
    $langCheck = false;
    foreach ($lang_array as $lang) {
        if ($lang == $language) {
            $langCheck = true;
            break;
        }
    }
    if ($langCheck) {

        echo "<tr>
            <td>
                <a href='course.php?id=" . $courses[$initCntr]["id"] . "&lang=" . $courses[$initCntr]["lang"] . "'>" . $courses[$initCntr]["name"] . "</a>
            </td>
            <td>" . $courses[$initCntr]["orga"] . "</td>
            <td>";
        foreach ($course_dates_array as $start_date) {
            echo $start_date . "<br>";
        }
        echo "</td><td class=\"language-flag-rows\">";
        //<img class=\"language-flag-element\" src=\"../images/flags/s_".$courses[$initCntr]["lang"].".png\"></td>
        $i = 0;
        foreach ($lang_array as $c_lang) {
            echo "<a href=\"course.php?id=" . $courses[$initCntr]["id"] . "\"&lang=\"" . $c_lang . "\"><img class=\"language-flag-element language-flag-onhover ";
            if ($i == 0) {
                echo "language-flag-active\" ";
                $i++;
            } else {
                echo "\" ";
            }
            echo "src=\"../images/flags/s_" . $c_lang . ".png\"></a>";
        }
        echo "</td><td class=\"rowlink-skip\"><input type=\"button\" data-id=\"" . $courses[$initCntr]["id"] . "\"
                                                                class=\"btn btn-edit btn-sm btn-success btn-block\"
                                                                value=\"Edit\"/></td>
                                <td class=\"rowlink-skip\"><input type=\"button\" data-id=\"" . $courses[$initCntr]["id"] . "\"
                                                                class=\"btn btn-delete btn-sm btn-warning btn-block\"
                                                                value=\"Delete\"></td>
                            </tr>
                            <tr>
                                <!-- Collapse div for course description -->
                                <td colspan=\"6\">
                                    <button type=\"button\" class=\"btn btn-info\" data-toggle=\"collapse\"
                                            data-target=\"#description-" . $index . "\">Description
                                    </button>
                                    <div id=\"description-" . $index . "\" class=\"collapse\">" .
            $courses[$initCntr]["description"] .
            "</div>
                                </td>
                            </tr>";
    }

}

echo "</tbody>
   </table>";


?>
