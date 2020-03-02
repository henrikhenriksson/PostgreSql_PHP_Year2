<?php

/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: userpage.php
 * Desc: Userpage page for Projekt
 *
 * Anders Student
 * ansu6543
 * ansu6543@student.miun.se
 ******************************************************************************/

session_start();
require('util.php');
/*******************************************************************************
 * HTML section starts here
 ******************************************************************************/

if (!isset($_SESSION['validLogin'])) {
    header("Location: index.php"); /* Redirect browser */
    exit;
} else {
    $title = "DT161G - Användarsida";
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
            <p>
                Denna sida skall endast kunna nås om man loggat in.<br>
                På denna sida så skall ni få en lista på de kategorier/mappar som ni har som användare.<br>
                Det skall också gå att skapa nya kategorier på denna sida.<br>
                På denna sida skall man också kunna ladda upp bilder och välja vilken kategori som bilden skall hamna i.
            </p>
        </section>
    </main>

    <footer>
        <?php require 'includeFooter.php' ?>
    </footer>

</body>

</html>