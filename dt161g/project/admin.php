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
$createMessage = "";
$removeMessage = "";
// fetch all members when the site loads or reloads.
$userArray = dbHandler::getInstance()->getMembersFromDataBase();

// Check if a message has been stored from the previous session and set the status message. The unset call makes sure the message doesnt persist if the page is updated again.
if (isset($_SESSION['createMessage'])) {
    $createMessage = $_SESSION['createMessage'];
    unset($_SESSION['createMessage']);
} elseif (isset($_SESSION['removeMessage'])) {
    $removeMessage = $_SESSION['removeMessage'];
    unset($_SESSION['removeMessage']);
}
//-------------------------------------------------------------------------
// This part is responsible for adding a new member to the database, as well as creating a new folder for the user on the server storage.
if (isset($_POST['userName'])) {
    $validUserName = true;
    $newUserName = strtolower(trim($_POST['userName']));
    $newUserPsw = trim($_POST['psw']);
    $newUserRoles = [];

    // Check selected roles. As there are only 2 roles in the database currently, it easy to keep track of their ids. This function can/should be expanded upon to actually fetch all possible roles from the database.
    if ($_POST['role'] === "admin") {
        $newUserRoles[] = 2;
    } else if ($_POST['role'] === "member") {
        $newUserRoles[] = 1;
    } else if ($_POST['role'] === "memberAdmin") {
        $newUserRoles = [1, 2];
    }
    // Check for unique user name
    foreach ($userArray as $key) {
        if ($key->getUserName() === $newUserName) {
            $validUserName = false;
            $_SESSION['createMessage'] = "A user with that name already exists!";
        }
    }
    // Perform the creation of the user.
    if ($validUserName) {
        dbHandler::getInstance()->addNewUser($newUserName, $newUserPsw, $newUserRoles);
        FileHandler::getInstance()->createUserFolder($newUserName);
        $_SESSION['createMessage'] = "New User has been created successfully.";
    }
    header("Location: admin.php");
}
//-------------------------------------------------------------------------
// This section handles the removal of a user from the database, as well as removing the user folder from the server storage.
if (isset($_POST['removeMemberSelect'])) {
    $userToRemove = "";
    $validRemoval = true;
    // Fetch the member object to be removed.
    foreach ($userArray as $uKey) {
        if ($_POST['removeMemberSelect'] === $uKey->getUserName()) {
            $userToRemove = $uKey;
        }
    }
    // Make sure the admin is not trying to remove him/her self:
    if ($userToRemove->getUserName() === $_SESSION['validLogin']) {
        $_SESSION['removeMessage'] = "You can not remove yourself!";
        $validRemoval = false;
    }
    // perform the removal.
    if ($validRemoval) {
        dbHandler::getInstance()->removeUser($userToRemove->getId());
        FileHandler::getInstance()->deleteUserFolder($userToRemove->getUserName());
        $_SESSION['removeMessage'] = "Selected member was removed succesfully!";
    }
    header("Location: admin.php");
}
//---------------------------------------------------------------------------
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
                                <td><?php echo htmlspecialchars($uKey->getUserName())  ?></td>
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
                            <input type="radio" name="role" id="onlyMember" value="member" checked />
                            <label for="Member">Member</label>
                            <input type="radio" name="role" id="onlyAdmin" value="Admin" />
                            <label for="Admin">Admin</label>
                            <input type="radio" name="role" id="bothRoles" value="memberAdmin" />
                            <label for="memberAndAdmin">Admin & Member</label>
                            <br>
                            <button type="submit" id="newMemberButton">Add new Member</button>
                        </form>
                        <p> <?php echo $createMessage ?></p>
                    </div>
                    <div id="removeMember">
                        <p class="bold">Remove Member: </p>
                        <p class="IntroText"><span class="red">Warning:</span>This will also remove any images this user has uploaded</p>
                        <form id="memberRemoveForm" action="admin.php" method="POST">
                            <select name="removeMemberSelect" id="memberRemoveSelector">
                                <?php foreach ($userArray as $uKey) : ?>
                                    <option><?php echo htmlspecialchars($uKey->getUserName()) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" id="removeMemberButton">Remove Member</button>
                        </form>
                        <p> <?php echo $removeMessage ?></p>
                    </div>
                </div>
        </section>
    </main>
    <footer>
        <?php require 'includeFooter.php' ?>
    </footer>
</body>

</html>