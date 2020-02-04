<?PHP
/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: login.php
 * Desc: Login page for laboration 2
 *
 * Anders Student
 * ansu6543
 * ansu6543@student.miun.se
 ******************************************************************************/

// user_array holds username and password
// There are two users: m with password m and a with password a
$user_array = array(
    "m" => "m",
    "a" => "a"
);
// Just to show how to iterate through an map array
foreach ($user_array as $username => $password) {
    //echo "Username=" . $$username . ", Password=" . $password;
}

// This array holds the links to be displayed when a user has logged in
$link_array = [
	"Hem" => "index.php",
    "Gästbok" => "guestbook.php",
    "Medlemssida" => "members.php"
];


// Example code
session_start();
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
$responseText = "Session count is: " . $_SESSION['count'];

header('Content-Type: application/json');
echo json_encode($responseText);

?>