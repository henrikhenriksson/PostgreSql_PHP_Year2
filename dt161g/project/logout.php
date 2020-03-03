<?php

/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: logout.php
 * Desc: Logout page for Projekt
 *
 * Anders Student
 * ansu6543
 * ansu6543@student.miun.se
 ******************************************************************************/

$responseText = [];
// This array holds the links to be displayed when a user has logged out
$link_array = [
    "Hem" => "index.php",
];

// Initialize the session.
session_start();

foreach ($_SESSION as $key => $value) {
    if ($key !== "sCap") {
        unset($_SESSION[$key]);
    }
}

// set Confirmation message and add links to display to the response.
$responseText['msg'] = "You are logged out and the session cookie has been destroyed";
$responseText['links'] = $link_array;
header('Content-Type: application/json');
echo json_encode($responseText);
