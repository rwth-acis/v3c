<?php

include 'user_management.php';
require_once 'authentication.php';

//3 is learner role and therefore standard role for user profile creation.
$role = 3;
$access_token = filter_input(INPUT_POST, 'access_token');


// Session data should only be updated, if the user got a new access token
if (isset($access_token) && $access_token != 'null') {

    // Setup session and cache access_token as login-validation, also for other pages
    session_start();
    // Store which type of login service is used for authentication
    // Currently only the 'LearningLayers' service is supported
    $_SESSION['service_type'] = filter_input(INPUT_POST, 'service_type');
    // Also store the access token, because this will be needed to authenticate
    // the user. This makes sense, when the token is valid only for a limited
    // timespan.
    $_SESSION['access_token'] = $access_token;

    // Retrieve user data from the authentication service (e.g. Learning Layers)
    $authentication = new Authentication();
    $userProfile = $authentication->getUserProfile();

    // from fake login: As we cannot connect to the Learning Layers server, we
    // have to store sub and email in a session variable
    $_SESSION['sub'] = $userProfile->sub;
    $_SESSION['email'] = $userProfile->email;
    $_SESSION['given_name'] = $userProfile->given_name;
    $_SESSION['family_name'] = $userProfile->family_name;
    // fake_end		

    ////// Search database for user and create new entry if it doesn't have      
    require '../php/db_connect.php';
    $userManagement = new UserManagement();
    // FIRST OF ALL, CHECK WHETHER THE USER IS KNOWN TO THE SYSTEM
    // THIS IS DONE BY CHECKING WHETHER THE UNIQUE OPEN ID CONNECT SUB EXISTS IN OUR DATABASE
    $user = $userManagement->readUser($userProfile->sub);
    //set user ROLE and affiliation;
    $_SESSION['role'] = $user->role;
    $_SESSION['affiliation'] = $user->affiliation;
    // If $user is empty, the user is not known
    if (!$user) {
        // CREATE A NEW USER DATABASE ENTRY IF USER WAS NOT KNOWN TO THE SYSTEM
        $userManagement->createUser($userProfile, $role);
    } else {
        // VERIFY, THAT LOCAL DATABASE ENTRY HOLDS THE SAME INFORMATION AS REMOTE ENTRY IN OIDC DATABASE
        if ($user['email'] != $_SESSION['email'] || $user['given_name'] != $_SESSION['given_name'] || $user['family_name'] != $_SESSION['family_name']) {
            $success = $userManagement->updateUser($user, $user->role);
        }
    }
}

// TODO: this is not good solution to know in the frontend about user-privileges
require '../php/access_control.php';
$accessControl = new AccessControl();
echo '{"canEnterLecturerMode":' . $accessControl->canEnterLecturerMode() . '}';