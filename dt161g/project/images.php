<?PHP
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: images.php
 * Desc: Image page for Projekt
 *
 * Anders Student
 * ansu6543
 * ansu6543@student.miun.se
 ******************************************************************************/
$title = "DT161G - Projekt - Bildsida";
$username = "No User is set!";
if (isset($_GET["user"])) {
    $username = $_GET["user"];
}

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
    för användare: <?php echo $username ?>
</header>

<main>
</main>

<footer>
</footer>

</body>
</html>
