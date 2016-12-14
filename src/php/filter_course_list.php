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
                           AND courses.lang = '$language'")->fetchAll();
echo"<table class=\"table table-striped table-bordered table-hover\">
                        <thead>
                        <tr>
                            <th>Course name</th>
                            <th>Created by</th>
                            <th>Start Dates</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody data-link=\"row\" class=\"rowlink\">";

$index = 0;
foreach ($courses as $course) {
// Add line brake after each date for more readability in the table
    $course_dates_array = explode("\n", $course["date_created"]);
    $index++;

    echo"                        <tr>
                                <td>
                                    <a href=\"course.php?id=\"".$course["id"] . "&lang=" . $course["lang"]."\">".$course["name"]."</a>
                                </td>
                                <td>".$course["orga"]."</td>
                                <td>";
    foreach ($course_dates_array as $start_date) {
        echo $start_date . "<br>";
    }
    echo"  </td>
                                <td class=\"rowlink-skip\"><input type=\"button\" data-id=\"".$course["id"]."\"
                                                                class=\"btn btn-edit btn-sm btn-success btn-block\"
                                                                value=\"Edit\"/></td>
                                <td class=\"rowlink-skip\"><input type=\"button\" data-id=\"".$course["id"]."\"
                                                                class=\"btn btn-delete btn-sm btn-warning btn-block\"
                                                                value=\"Delete\"></td>
                            </tr>
                            <tr>
                                <!-- Collapse div for course description -->
                                <td colspan=\"5\">
                                    <button type=\"button\" class=\"btn btn-info\" data-toggle=\"collapse\"
                                            data-target=\"#description-". $index."\">Description
                                    </button>
                                    <div id=\"description-".$index."\" class=\"collapse\">".
        $course["description"].
        "</div>
                                </td>
                            </tr>";
}

echo"</tbody>
   </table>";


?>
