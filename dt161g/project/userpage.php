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
$title = "DT161G - Projekt - Användarsida"

/*******************************************************************************
 * HTML section starts here
 ******************************************************************************/
?>
<!DOCTYPE html>
<html lang="sv-SE">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="css/style.css"/>
    <script src="js/main.js"></script>
</head>
<body>

<header>
    <h1><?php echo $title ?></h1>
</header>

<main>
    Denna sida skall endast kunna nås om man loggat in.<br>
    På denna sida så skall ni få en lista på de kategorier/mappar som ni har som användare.<br>
    Det skall också gå att skapa nya kategorier på denna sida.<br>
    På denna sida skall man också kunna ladda upp bilder och välja vilken kategori som bilden skall hamna i.
</main>

<footer>
</footer>

</body>
</html>



