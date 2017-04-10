<?php
/**
 * Copyright 2015 Adam Brunnmeier, Dominik Studer, Alexandra Wörner, Frederik Zwilling, Ali Demiralp, Dev Sharma, Luca Liehner, Marco Dung, Georgios Toubekis
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @file tools.php
 * File for some PHP helper functions that are generally useful
 */

/**
 * Creates the html table structure from the given result from the database
 * Used in courses.php, course.php, overview.php and getmodels.php
 * @param  resource $result Identifier for the result set from the database
 * @return string/html         HTML table containing the models which should be displayed
 */
function createTable($result, $type)
{
    $html = '<ul class="img-list">';

    foreach ($result as $entry) {
        if (substr($type, 0, 1) == "m") {
            $html .= getModelStructure($entry, $type);
        } else {
            if (substr($type, 0, 1) == "s") {
                $html .= getSubjectStructure($entry);
            } else {
                $html .= getCourseStructure($entry);
            }
        }
    }

    $html .= '</ul>';
    return $html;
}

/**
 * Creates the html structure of one course entry with the given data
 * @param  object $entry Course data from database
 * @return string/html        HTML containing the course information
 */
function getCourseStructure($entry)
{
    $html = "";
    // Decide if we are in ROLE space
    if (filter_input(INPUT_GET, "widget") == 'true') {
        $html = "&widget=true";
    }

    // id used to derive course id (from database) connected to clicked link
    return "<li><a href='course.php?id=$entry[id]" . $html . "' id='a_img$entry[id]'>
    <img src=$entry[img_url] alt=$entry[name] class='img-responsive img-fit'>
    <p style='font-weight: bold;'>$entry[name]</p>
</a></li>";
}

/**
 * Creates the html structure of one subject entry with the given data
 * @param  object $entry Subject data from database
 * @return string/html        HTML containing the subject information
 */
function getSubjectStructure($entry)
{
    $html = "";
    // Decide if we are in ROLE space
    if (filter_input(INPUT_GET, "widget") == 'true') {
        $html = "&widget=true";
    }

    // id used to derive course id (from database) connected to clicked link
    return "<li><a href='course_list.php?id=$entry[id]" . $html . "' id='a_img$entry[id]'>
    <img src=$entry[img_url] alt=$entry[name] class='img-responsive img-fit'>
    <p style='font-weight: bold;'>$entry[name]</p>
</a></li>";
}

/**
 * Print a button which links to the editcourse.php
 * @param $url
 * @param string $class css class which should be applied to the button
 * @param $text
 * @internal param type $arg id of the course
 */
function printLinkBtn($url, $class, $text)
{
    $widgetExtension = "";
    if (filter_input(INPUT_GET, "widget") == "true") {
        $widgetExtension = "&widget=true";
    }
    echo "<a href=$url $widgetExtension>";
    echo "<button class='$class' type='button'>$text</button>";
    echo "</a>";
}

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
// copy-pasted from
// http://stackoverflow.com/questions/9802788/call-a-rest-api-in-php/9802854#9802854
function httpRequest($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method) {
        case "POST":
        curl_setopt($curl, CURLOPT_POST, 1);

        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        break;
        case "PUT":
        curl_setopt($curl, CURLOPT_PUT, 1);
        break;
        default:
        if ($data) {
            $url = sprintf("%s?%s", $url, http_build_query($data));
        }
    }

    // Optional Authentication:
    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $res_exec = curl_exec($curl);
    // To avoid warnings:
    if (!isset($result)) {
        $result = new stdClass();
    }

    if ($res_exec == false) {
        $result->bOk = false;
        $result->sMsg = curl_error($curl);
    } else {
        $result->bOk = true;
        $result->sMsg = $res_exec;
        $result->iStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    }

    curl_close($curl);

    return $result;
}


/**
 * Requests a user-profile from the las2peer-login-service.
 * @param  string The token that is send to the OIDC-provider
 * @return struct {'bOk':boolean, 'sMsg':string}, sMsg is userprofile in JSON on success and errormessage on fail
 */
function getUserProfile($access_token)
{
    $result = new stdClass();
    $result->success = false;
    $result->message = '';

    $oidc_request = httpRequest("GET", $las2peerUrl . '/' . 'user' . '?access_token=' . $access_token);

    if ($oidc_request->bOk == false or $oidc_request->iStatus !== 200) {
        $result->bOk = false;
        $result->sMsg = $oidc_request->sMsg;
    } else {
        error_log('3dnrt/user call unsuccessfull: ' . $oidc_request->sMsg);
        $result->bOk = true;
        $result->message = $oidc_request->sMsg;
    }

    return $result;
}

/**
 * Function throws exceptions.
 * @param string $table Table from which to retrieve value
 * @param string $key
 * @param string $value
 * @return array {key1=>value1, key2=>value2, ...} or NULL if $key-$value is not found in $table
 */
function getSingleDatabaseEntryByValue($table, $key, $value)
{
    require '../php/db_connect.php';

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $sqlSelect = "SELECT * FROM " . $table . " WHERE " . $key . "='" . $value . "'";
    $sth = $db->prepare($sqlSelect);
    $sth->execute();
    $entry = $sth->fetch();

    return $entry;
}

/**
 * Function throws exceptions.
 * @param string $table Table from which to retrieve value
 * @param string $key
 * @param string $value
 * @return array {key1=>value1, key2=>value2, ...} or NULL if $key-$value is not found in $table
 */
function getSingleDatabaseEntryByValues($table, $arrayOfKeysAndValues)
{
    $db = require '../php/db_connect.php';

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $sqlSelect = "SELECT * FROM " . $table . " WHERE ";
    foreach($arrayOfKeysAndValues as $key => $value) {
        $sqlSelect .= $key . "='" . $value . "' AND ";
    }
    $sqlSelect .= " TRUE"; // end last AND block

    $sth = $db->prepare($sqlSelect);
    $sth->execute();
    $entry = $sth->fetch();

    return $entry;
}

/**
 * @return [bErr:bool, bIsConfirmed:bool, sMsg:string]
 */
function checkUserConfirmed($sub)
{

    $result = new stdClass();

    try {
        $user = getSingleDatabaseEntryByValue('users', 'openIdConnectSub', $sub);
    } catch (Exception $e) {
        $result->bErr = true;
        $result->bIsConfirmed = false;
        $result->sMsg = $e->getMessage();

        return $result;
    }

    // If $user is empty, the user is not known
    if (!$user) {
        $result->bErr = false;
        $result->bIsConfirmed = false;
        $result->sMsg = "User has no databaseentry.";
    } else {
        $result->bErr = false;
        $result->bIsConfirmed = ($user['confirmed'] == 1);
        $result->sMsg = "Value queried from database.";
    }

    return $result;
}

/**
 * This function throws an exception, when the database can not be accessed.
 *
 * @return id or NULL, if user is not found
 */
function getUserId($sub)
{

    $result = new stdClass();

    $user = getSingleDatabaseEntryByValue('users', 'openIdConnectSub', $sub);

    // If $user is empty, the user is not known
    if (!$user) {
        return null;
    } else {
        return $user->id;
    }
}

/**
 * This function fetches a course's course units and returns a databasae object with ordered by their respective dates.
 * @param $courseid
 */
function sortCourseUnits($courseid)
{
    require '../php/db_connect.php';

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $course_units_sql = "SELECT * FROM course_units WHERE id = '" . $courseid . "' ORDER BY date ASCENDING ";
    $course_units = $course_units_sql->fetchAll();

    return $course_units;
}


/**
 * This function returns the xml file for the specific widget.
 * @param $widget
 */

function getWidgetXML($widget)
{
    // TODO make it dynamic? 
    switch ($widget) {
        case 'hangout':
        return "http://virtus-vet.eu/src/widgets_xml/hangoutWidget.xml";
        break;
        case 'quiz':
        return "http://virtus-vet.eu/src/widgets_xml/qa.xml";
        break;
        case 'slides':
        return "http://virtus-vet.eu/src/widgets_xml/slides_widget.xml";
        break;
        case 'video':
        return "http://virtus-vet.eu/src/widgets_xml/hangoutWidget.xml";
        break;
    }
    return "";
}
