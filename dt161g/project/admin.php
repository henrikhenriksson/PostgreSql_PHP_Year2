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
?>

<!DOCTYPE html>
<html lang="sv-SE">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DT161G-<?php echo $title ?>-member</title>
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
            <h2>Medlemssida</h2>
            <p>Denna sida skall bara kunna ses av inloggade administratörer</p>
        </section>
    </main>
    <footer>
        <?php require 'includeFooter.php' ?>
    </footer>
</body>

</html>