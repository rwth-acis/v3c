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
 * @file register_as_tutor.php
 * Sends emails to admins to request being "confirmed" in database.
 */

ob_start();

require '../php/db_connect.php';
require '../config/config.php';

////// Get email from calling user    die(true);
session_start();
if (!isset($_SESSION['access_token'])) {
    die('User needs to be logged in to register as tutor.');
}

// Read all data, that should be used in mails and/or stored in our database.
// Most data comes from post request (as user input from not_authorized.php)
// mail and username are already stored in this session (taken from Learning 
// Layers service)
$mail = $_SESSION['email'];
$name = $_SESSION['given_name'] . ' ' . $_SESSION['family_name'];
$affiliation = filter_input(INPUT_POST, 'affiliation');
$city = filter_input(INPUT_POST, 'city');
$street = filter_input(INPUT_POST, 'street');
$phone = filter_input(INPUT_POST, 'phone');

// This script will upgrade the account of the given email in our database to a 
// tutor/lecturer version 
include 'confirm_registration.php';

$bAtLeastOne = false;
// Send a mail to admins to inform that someone upgraded his/her account
// The admins are defined in config/config.php
foreach ($admins as $admin) {
    $mail_to = $admin["0"];
    $admin_name = $admin["1"] . " " . $admin["2"];
    $confirmation_link = $baseUrl . "/src/views/confirm_registration.php?mail=" . $mail;
    $subject = "V3C Lecturer";
    // The following text can be used to request lecturer rights from an admin. 
    // In the current implementation it is sufficient to just inform admins, 
    // that somebody upgraded an account.
//     $message = "Hello " . $admin_name . ",\n\n" .
//       $mail . "\n wants to be granted lecturer rights at V3C.\n" .
//       "If the email address belongs to a lecturer, please confirm his or her account by clicking the following link: " . $confirmation_link . "\n" . 
//       "After a short delay, the account should then be confirmed automatically." . "\n\n" .
//       "This mail was automatically generated by the V3C system. Please do not respond to this mail.";
    // Create the message content with all information we have about the user
    $message = "Hello " . $admin_name . ",\n\n" .
        $name . " has upgraded his/her V3C account to a lecturer account.\n\n" .
        "The following data is known:\n" .
        "Email: " . $mail . "\n";
    if ($affiliation != '') {
        $message .= "Affiliation: " . $affiliation . "\n";
    }
    if ($city != '') {
        $message .= "City: " . $city . "\n";
    }
    if ($street != '') {
        $message .= "Street: " . $street . "\n";
    }
    if ($phone != '') {
        $message .= "Phone: " . $phone . "\n";
    }
    $message .= "\nThis mail was automatically generated by the V3C system. Please do not respond to this mail.";

    $bAtLeastOne = mail($mail_to, $subject, $message) or $bAtLeastOne;
}

ob_end_clean();

echo json_encode(['result' => $bAtLeastOne]);