<?php

/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: logout.php
 * Desc: Logout page for laboration 2
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
$responseText = [];
// This array holds the links to be displayed when a user has logged out
$link_array = [
    "Hem" => "index.php",
    "Gästbok" => "guestbook.php",
];

// Initialize the session.
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

// set Confirmation message and add links to display to the response.
$responseText['msg'] = "You are logged out and the session cookie has been destroyed";
$responseText['links'] = $link_array;
header('Content-Type: application/json');
echo json_encode($responseText);
