<?php
/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: logout.php
 * Desc: Logout page for laboration 2
 *
 * Anders Student
 * ansu6543
 * ansu6543@student.miun.se
 ******************************************************************************/

// This array holds the links to be displayed when a user has logged out
$link_array = [
	"Hem" => "index.php",
    "Gästbok" => "guestbook.php",
];



// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

$responseText = "You are logged out and the session cookie has been destroyed";
header('Content-Type: application/json');
echo json_encode($responseText);

?>

