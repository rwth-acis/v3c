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
 *  @file user_management.php
 *  Class for CRUD operations for users
 */

class UserManagement
{

    private $db;

    /**
     * Constructor for UserManagement
     */
    function __construct()
    {
        $this->db = require 'db_connect.php';
    }

    /**
     * Reading a user from our database
     * @param String $sub The Open ID Connect SUB
     * @return Object object with property names that correspond to the column
     * names of our users table
     */
    public function readUser($sub)
    {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sqlSelect = "SELECT * FROM `users` WHERE openIdConnectSub='" . $sub . "'";
        // This will escape symbols in the SQL statement (also supposed to prevent 
        // SQL injection attacks). Returns a PDOStatement
        $stmt = $this->db->prepare($sqlSelect);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Create a user entry in our database
     * @param type $userProfile Object with properties email, sub, given_name,
     * family_name
     * @param type $role Integer representing the user's desired role, where 1=Admin, 2=Teacher, 3=Learner, 4=Operator
     */
    public function createUser($userProfile, $role)
    {
        echo "Email: " . $userProfile->email . " sub: " . $userProfile->sub . "given_name: " . $userProfile->given_name . " last_name: " . $userProfile->last_name . " role: " . $role;

        // CREATE A NEW USER DATABASE ENTRY
        $stmt = $this->db->prepare("INSERT INTO users (email, openIdConnectSub, given_name, family_name, role)
                          VALUES (:email, :sub, :given_name, :family_name, :role");
        $stmt->bindParam(":email", $userProfile->email, PDO::PARAM_STR);
        $stmt->bindParam(":sub", $userProfile->sub, PDO::PARAM_STR);
        $stmt->bindParam(":given_name", $userProfile->given_name, PDO::PARAM_STR);
        $stmt->bindParam(":family_name", $userProfile->family_name, PDO::PARAM_STR);
        $stmt->bindParam(":role", $role, PDO::PARAM_INT);

        $success = $stmt->execute();
        if ($success === false) {
            error_log('Error: user insertion in database failed!');
            die('Could not create new user.');
        }
    }

    /**
     * Update a user entry in our database
     * @param type $userProfile Object with properties email, sub, given_name,
     * family_name
     * @param type $role Integer representing the user's desired role, where 1=Admin, 2=Teacher, 3=Learner, 4=Operator
     */
    public function updateUser($userProfile, $role)
    {
        $sqlUpdate = "UPDATE users SET email = '" . $userProfile->email . "', given_name = '" . $userProfile->given_name . "', family_name ='" . $userProfile->family_name . "', role = '" . $role . "' WHERE openIdConnectSub = '" . $userProfile->sub . "'";
        $stmt = $this->db->prepare($sqlUpdate);
        $success = $stmt->execute();
        if ($success === false) {
            error_log('Error: user update in database failed!');
            die('Could not update user data.');
        }
    }

    /**
     * Delete a user entry in our database
     * @param type $sub openIdConnect Sub identifying a user.
     */
    public function deleteUser($sub)
    {
        $sqlDelete = "DELETE * FROM users WHERE openIdConnectSub = " . $sub;
        $stmt = $this->db->prepare($sqlDelete);
        $success = $stmt->execute();
        if ($success === false) {
            error_log('Error: user deletion from database failed!');
            die('Could not delete user from database.');
        }
    }
}