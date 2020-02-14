<?PHP

/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: login.php
 * Desc: Login page for laboration 2
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
require "util.php";
// user_array holds username and password
// There are two users: m with password m and a with password a
$user_array = array(
    "m" => "m",
    "a" => "a"
);
// Set the responseText to an array as it will contain multiple items.
$responseText = [];
$responseText['valid'] = false;
$validUser = false;
$validPassword = false;
// Just to show how to iterate through an map array
foreach ($user_array as $username => $password) {
    //echo "Username=" . $$username . ", Password=" . $password;
    // check user input:
    if ($_GET['name'] === $username) {
        $validUser = true;
        if ($_GET['password'] === $password) {
            $validPassword = true;
        }
    }
}

if ($validUser && $validPassword) {
    session_start();

    // This array holds the links to be displayed when a user has logged in
    $link_array = [
        "Hem" => "index.php",
        "Gästbok" => "guestbook.php",
        "Medlemssida" => "members.php"
    ];

    // set session variable containing user name:
    $_SESSION['validLogin'] = $_GET['name'];
    // Add the links to a link array, used to make sure the menu items persists across page refreshes.
    $_SESSION['sessionLinks'] = $link_array;

    // Example code
    if (!isset($_SESSION['count'])) {
        $_SESSION['count'] = 1;
    } else {
        $_SESSION['count']++;
    }
    // add msg, link array and a bool confirming the login was successfull to the reply to be sent.
    $responseText['msg'] = "Welcome valid user {$_GET['name']}. Session count is: " . $_SESSION['count'];
    $responseText['links'] = $link_array;
    $responseText['valid'] = true;
} else if (!$validUser) {
    // inform the user that the login was unsuccesfully and why.
    $responseText['msg'] = "Your are not an authorized user!";
} else if ($validUser && !$validPassword) {
    $responseText['msg'] = "Incorrect Password!";
}

// send the reply.
header('Content-Type: application/json');
echo json_encode($responseText);
