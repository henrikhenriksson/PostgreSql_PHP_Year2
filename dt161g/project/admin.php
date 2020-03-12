<?php

/*******************************************************************************
 * Project Assignment, Kurs: DT161G
 * File: member.php
 * Desc: Admin page for dt161g Project Assignment
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
session_start();
require('util.php');
// if no session is active (which it only will be if the user is successfully logged in), redirect the user to the index page.
if (!isset($_SESSION['validLogin']) || !$_SESSION['isAdmin'] = true) {
    header("Location: index.php"); /* Redirect browser */
    exit;
} else {
    $title = "DT161G- Adminsida";
}
// fetch all members when the site loads or reloads.
$userArray = dbHandler::getInstance()->getMembersFromDataBase();

if (isset($_SESSION['createMessage'])) {
    $createMessage = $_SESSION['createMessage'];
    unset($_SESSION['createMessage']);
} elseif (isset($_SESSION['removeMessage'])) {
    $removeMessage = $_SESSION['removeMessage'];
    unset($_SESSION['removeMessage']);
}

if (isset($_POST['userName'])) {

    $newUserName = strtolower($_POST['userName']);
    $validUserName = false;

    foreach ($userArray as $key) {
        if ($key->getUserName() == $newUserName) {
            $validUserName = false;
            $_SESSION['createMessage'] = "A user with that name already exists!";
        }
    }
    if ($validUserName) {

        FileHandler::getInstance()->createUserFolder($newUserName);
    }
}


?>

<!DOCTYPE html>
<html lang="sv-SE">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DT161G-<?php echo $title ?>-Admin</title>
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/main.js"></script>
</head>

<body>
    <header>
        <img src="img/mittuniversitetet.jpg" alt="miun logga" class="logo" />
        <h1><?php echo $title ?></h1>
        <?php require 'includeLogin.php'; ?>
    </header>
    <main>
        <aside>
            <!-- require the incluion of these pages: -->
            <?php require 'includeUsers.php'; ?>
        </aside>
        <section>
            <h2>Administratörssida</h2>
            <p class="IntroText">Denna sida skall bara kunna ses av inloggade administratörer. Här kan du som administratör se alla nuvarande medlemmar och lägga till eller ta bort medlemmar.<br>
                <div id="memberTable">
                    <p>Nuvarande medlemmar:</p>
                    <table>
                        <tr>
                            <th>Namn:</th>
                            <th>Roll:</th>
                        </tr>
                        <?php foreach ($userArray as $uKey) : ?>
                            <tr>
                                <td><?php echo $uKey->getUserName() ?></td>
                                <td>
                                    <?php foreach ($uKey->getRoleArray() as $rKey) : ?>
                                        <?php echo $rKey->getrole() ?>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <div id="newMember">
                        <p class="bold">Add New Member:</p>
                        <form id="addMemberForm" action="admin.php" method="POST">
                            <label><b>Username:</b></label>
                            <input type="text" placeholder="Enter Username" name="userName" id="uname" required maxlength="10" autocomplete="off" required>
                            <label><b>Password:</b></label>
                            <input type="password" placeholder="Enter Password" name="psw" id="psw" required minlength="1" required>
                            <br>
                            <p>Select Roles to assign: </p>
                            <input type="radio" name="role" id="onlyMember" checked />
                            <label for="Member">Member</label>
                            <input type="radio" name="role" id="onlyAdmin" />
                            <label for="Admin">Admin</label>
                            <input type="radio" name="role" id="bothRoles" />
                            <label for="memberAndAdmin">Admin & Member</label>
                            <br>
                            <button type="submit" id="newMemberButton">Add new Member</button>
                        </form>
                    </div>
                    <div id="removeMember">
                        <p class="bold">Remove Member: </p>
                        <p class="IntroText"><span class="red">Warning:</span>This will also remove any images this user has uploaded</p>
                        <form id="memberRemoveForm" action="admin.php" method="POST">
                            <select name="removeMemberSelect" id="memberRemoveSelector">
                                <?php foreach ($userArray as $uKey) : ?>
                                    <option><?php echo $uKey->getUserName() ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" id="removeMemberButton">Remove Member</button>
                        </form>
                    </div>
                </div>
        </section>
    </main>
    <footer>
        <?php require 'includeFooter.php' ?>
    </footer>
</body>

</html>