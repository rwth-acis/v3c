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
 *  @file access_control.php
 *  Class which is able to decide whether a user can access a feature or not
 */

require_once 'user_management.php';
require_once 'tools.php';
require_once 'authentication.php';

class AccessControl
{

    // Roles as represented in the database
    const ADMIN_ROLE = 1;
    const TEACHER_ROLE = 2;
    const LEARNER_ROLE = 3;
    // const OPERATOR_ROLE = 4;

    // Currently, a guest is considered a learner
    // const GUEST_ROLE = 0;

    /**
     * @var USER_STATUS The last status describing the users access control rights
     */
    private $lastStatus = USER_STATUS::NO_SESSION;
    /**
     * @var Authentication A variable to store an Authentication instance
     */
    private $authentication;

    /**
     * @return Authentication Getter for $authentication which makes sure the
     * variable is not empty
     */
    public function getAuthentication()
    {
        if (!isset ($this->authentication)) {
            $this->authentication = new Authentication();
        }
        return $this->authentication;
    }

    /**
     * @return Object object with property names that correspond to the column
     * names of our users table for the user of the current session
     */
    private function getSessionUser()
    {
        $userManagement = new UserManagement();
        return $userManagement->readUser($_SESSION['sub']);
    }

    /**
     * @return Object object with property names that correspond to the column
     * names of our users table for the user of the current session
     */
    public function getUserOrganization()
    {
        $userManagement = new UserManagement();
        return $userManagement->getOrganization($_SESSION['sub']);
    }

    /**
     * Evaluates the status of a authenticated user further (is it a tutor or not?)
     * @param Object $user A user object from our database
     * @return int The status of the authenticated user
     */
    private function getUserStatus($user)
    {
        if (!$user) {
            // User has no database entry
            $status = USER_STATUS::USER_IS_LEARNER;
        } else {
            if ($user->role == 3) {
                $status = USER_STATUS::USER_IS_LEARNER;
            } else {
                $status = USER_STATUS::USER_IS_TUTOR;
            }
        }

        $this->lastStatus = $status;

        return $status;
    }

    /**
     * Checks whether the user of the current session is a lecturer
     * @return boolean true, if it is a lecturer
     */
    private function isLecturer()
    {
        if (!$this->getAuthentication()->isAuthenticated()) {
            $this->lastStatus = USER_STATUS::NO_SESSION;
            return false;
        } else {
            return $this->getUserStatus($this->getSessionUser()) == USER_STATUS::USER_IS_TUTOR;
        }
    }

    /**
     * Checks whether the user of the current session is a lecturer and whether it
     * is the owner of the give course
     * @param String $course_id ID of the course whose owner the user has to be
     * @return boolean true, if user is a lecturer and the owner of the course
     */
    private function isLecturerAndCourseOwner($course_id)
    {
        $ret = false;
        if (!$this->getAuthentication()->isAuthenticated()) {
            $this->lastStatus = USER_STATUS::NO_SESSION;
            return false;
        }

        $user = $this->getSessionUser();
        if ($user->role == AccessControl::ADMIN_ROLE) {
            return true;
        }

        if ($user->role == AccessControl::TEACHER_ROLE || $this->getUserStatus($user) == USER_STATUS::USER_IS_TUTOR) {

            $course = getSingleDatabaseEntryByValues('courses', array(
                'id' => $course_id
                ));

            $creator = getSingleDatabaseEntryByValue('organizations', 'email', $course['creator']);

            if ($user->affiliation == $creator['id']) {
                return true;
            } else {
                $this->lastStatus = USER_STATUS::USER_NOT_CREATOR_COURSE;
                return false;
            }
        }
    }

    /**
     * @return boolean true, if user has administrator role
     */

    public function isAdmin()
    {
        if (!$this->getAuthentication()->isAuthenticated()) {
            $this->lastStatus = USER_STATUS::NO_SESSION;
            return false;
        }
        $user = $this->getSessionUser();

        return (isset($user) && ($user->role == AccessControl::ADMIN_ROLE));

    }


    /**
     * @return boolean true, if user is allowed to create courses
     */
    public function canCreateCourse()
    {
        return $this->isLecturer();
    }

    /**
     * @param String $course_id ID of a course
     * @return boolean true, if user is allowed to update the course whose ID is
     * given
     */
    public function canUpdateCourse($course_id)
    {
        return $this->isLecturerAndCourseOwner($course_id);
    }

    /**
     * @param String $course_id ID of a course
     * @return boolean true, if user is allowed to delete the course whose ID is
     * given
     */
    public function canDeleteCourse($course_id)
    {
        return $this->isLecturerAndCourseOwner($course_id);
    }

    /**
     * @return boolean true, if user is allowed to use the lecturer mode
     */
    public function canEnterLecturerMode()
    {
        return $this->isLecturer();
    }

    /**
     * @return USER_STATUS Returns the status of the last access control check
     */
    public function getLastErrorStatus()
    {
        return $this->lastStatus;
    }
}

/**
 * Class with constants for all possible user access control states
 */
abstract class USER_STATUS
{
    const NO_SESSION = 0;
    const LAS2PEER_CONNECT_ERROR = 1;
    const OIDC_UNAUTHORIZED = 2;
    const OIDC_ERROR = 3;
    const DATABASE_ERROR = 4;
    const USER_IS_LEARNER = 5;
    const USER_IS_TUTOR = 6;
    const USER_NOT_CREATOR_COURSE = 7;
    const USER_IS_ADMIN = 8;
}
