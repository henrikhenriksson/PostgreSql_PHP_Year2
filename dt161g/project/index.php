<?PHP

/*******************************************************************************
 * Project Assignment, Kurs: DT161G
 * File: index.php
 * Desc: Start page for dt161g Project Assignment
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
$title = "DT161G - Projekt";

/*******************************************************************************
 * HTML section starts here
 ******************************************************************************/
session_start();
require('util.php');
?>

<!DOCTYPE html>
<html lang="sv-SE">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DT161G-<?php echo $title ?></title>
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
            <?php require 'includeWelcome.php' ?>
        </section>
    </main>
    <footer>
        <?php require 'includeFooter.php' ?>
    </footer>
</body>

</html>