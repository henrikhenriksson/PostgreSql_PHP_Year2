<?PHP
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: index.php
 * Desc: Start page for Projekt
 *
 * Anders Student
 * ansu6543
 * ansu6543@student.miun.se
 ******************************************************************************/
$title = "DT161G - Projekt"

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
    <a href="images.php?user=test">Länk för användare test till bildsidan</a>
    <p>Länkens url blir då<br>
        images.php?user=test</p>
</main>

<footer>
</footer>

</body>
</html>
