<?php

/* 
 * Copyright 2015 Adam Brunnmeier, Dominik Studer, Alexandra Wörner, Frederik Zwilling, Ali Demiralp, Dev Sharma, Luca Liehner, Marco Dung, Georgios Toubekis
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *  http://www.apache.org/licenses/LICENSE-2.0
 * 
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 * 
 *  @file not_authorized.php
 *  HTML to be included in pages where the user cannot access the content based 
 *  on insufficient user rights. E.g. a user might not be allowed to upload models,
 *  then this page is included in upload.php.
 * 
 *  WARNING: $accessControl has to be instantiated in the calling 
 */

// $accessControl has to be instantiated in the calling HTML page.
// Will retrieve an error code for the access control problem.
$status = $accessControl->getLastErrorStatus();

// Create a human understandable error description for the error code in $status
switch ($status) {
    case USER_STATUS::NO_SESSION:
        $err_msg = 'This feature can only be used as a lecturer. If you are a lecturer, please click the "Sign in" button to log in.';
        break;
    case USER_STATUS::LAS2PEER_CONNECT_ERROR:
        $err_msg = 'Unable to check your login, sorry!';
        break;
    case USER_STATUS::OIDC_UNAUTHORIZED:
        $err_msg = 'Your logindata is invalid. Probably the session has expired and you have to login again.';
        break;
    case USER_STATUS::OIDC_ERROR:
        $err_msg = 'Some error with your account-validation occured, sorry!';
        break;
    case USER_STATUS::DATABASE_ERROR:
        $err_msg = 'Your tutor-status could not be checked, sorry! You may try again later.';
        break;
    case USER_STATUS::USER_NOT_CONFIRMED:
        $err_msg = 'You do not have sufficient permission to perform this action';
        break;
    case USER_STATUS::USER_IS_TUTOR:
        $err_msg = '';
        break;
    case USER_STATUS::USER_NOT_CREATOR_COURSE:
        $err_msg = 'A different Company created this course. Only content creators affiliated with this company are able to modify or delete this course.';
        break;
}
?>

<!-- 
A container for all output of not_authorized.php
See bootstrap documentation for infos about container
authorization-error-container limits the size of the content (otherwise looks 
weird on very large screens)
-->
<div class="container authorization-error-container">

    <?php

    // Show the error only for certain error states
    switch ($status) {
        case USER_STATUS::NO_SESSION:
        case USER_STATUS::LAS2PEER_CONNECT_ERROR:
        case USER_STATUS::OIDC_UNAUTHORIZED:
        case USER_STATUS::OIDC_ERROR:
        case USER_STATUS::DATABASE_ERROR:
        case USER_STATUS::USER_NOT_CONFIRMED:
        case USER_STATUS::USER_NOT_CREATOR_COURSE:
            // show error
            ?>
            <div class="alert alert-danger" role="alert">
                <p><?php echo $err_msg ?></p>
            </div>
            <?php
    }


    ?>

</div>

<!-- Functionality for btn_request_lecturer (To upgrade an account to lecturer rights) -->
<script src="../js/upgrade-account.js"></script>