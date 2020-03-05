<?php

/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: includeImageForm.php
 * Desc: inclusion file for image upload form
 *
 * Henrik Henriksson 
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
require('util.php');

if (isset($_FILES['file'])) {
    session_start();
    $filehandler = FileHandler::getInstance();
    // Find the current user with a new database request to make sure the category list has been updated.
    $currentUser = "";
    $userArray = dbHandler::getInstance()->getMembersFromDataBase();
    foreach ($userArray as $uKey) {
        if ($_SESSION['validLogin'] == $uKey->getUserName()) {
            $currentUser = $uKey;
        }
    }

    $category = $_POST['category'];
    $filehandler->validateAndUpload($currentUser, $category, $_FILES);
}
$filehandler->sendReply();
