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

$currentUser = "";


if ($_GET['name']) {
    session_start();

    if (isset($_SESSION['validLogin'])) {
        $currentUser = $_SESSION['validLogin'];
    }

    // Get all existing categories for specific user from database -

}

header('Content-Type: application/json');
echo json_encode($responseText);
