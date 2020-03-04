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
$responseText = [];


if ($_GET['name']) {
    session_start();

    if (isset($_SESSION['validLogin'])) {
        $currentUser = $_SESSION['currentUser'];

        $currentCategories = $currentUser->getCategories();

        // Get all existing categories for specific user from database.
        // Check for existing Categories.
        $validCategory = true;

        foreach ($currentUser->getCategories() as $key) {
            if ($_GET['name'] === $key->getCategoryName()) {
                $validCategory = false;
            }
        }

        if (!$validCategory) {
            $responseText['msg'] = "Sorry, that Category already exists for this user.";
        } else {
            // Add the Category to the user Database.
            DbHandler::getInstance()->addNewCategory($_GET['name'], $currentUser->getId());
            $responseText['msg'] = "New Category added succesfully.";
        }
    } else {
        $responseText['msg'] = "No valid user detected. New Category cannot be added.";
    }
}

header('Content-Type: application/json');
echo json_encode($responseText);
