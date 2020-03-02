<?php
/*
******************************************************************************
// * Laboration 4, Kurs: DT161G
// * File: includeLogin.php
// * Desc: Start page for laboration 2
// *
// * Henrik Henriksson
// * hehe0601
// * hehe0601@student.miun.se
****************************************************************************** */

// Check if there is an active session, decides if login should be hidden or not.
$loggedIn = isset($_SESSION['validLogin']) ? "hide" : "";
$loggedOut = isset($_SESSION['validLogin']) ? "" : "hide";

?>
<!-- This page holds tags that should be globally accessible by all pages -->
<div id="login" class="<?php echo $loggedIn; ?>">
    <p id="count"></p>

    <form id="loginForm">
        <label><b>Username:</b></label>
        <input type="text" placeholder="m" name="uname" id="uname" required maxlength="10" value="m" autocomplete="off">
        <label><b>Password:</b></label>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
        <button type="button" id="loginButton">Login</button>
    </form>
</div>
<div id="logout" class="<?php echo $loggedOut; ?>">
    <h2>LOGOUT</h2>
    <button type="button" id="logoutButton">Logout</button>
</div>