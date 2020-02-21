<?PHP

/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: login.php
 * Desc: Login page for laboration 2
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
require('util.php');


$login = new LoginHandler($_GET['name'], $_GET['password']);

if ($login->validatePassword()) {
    session_start();

    // set session variable containing user name:
    $_SESSION['validLogin'] = $_GET['name'];
    // Add the links to a link array, used to make sure the menu items persists across page refreshes.
    $_SESSION['sessionLinks'] = $login->setLinkArray();
}

$responseText = $login->setResponseText();

$login->sendReply();
