<?PHP

/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: images.php
 * Desc: Image page for Projekt
 *
 * Henrik Henriksson 
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
session_start();
require('util.php');

$title = "DT161G - Bildsida";
$username = "No User is set!";
$valid = false;
$users = dbHandler::getInstance()->getMembersFromDataBase();

if (isset($_GET["user"])) {
    $username = "Invalid User!";
    foreach ($users as $key) {
        if ($key->getUserName() === $_GET["user"]) {
            $username = $_GET["user"];
        }
    }
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
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/main.js"></script>
</head>

<body>
    <header>
        <h1><?php echo $title ?></h1>
        <p>
            Personlig sida för användare: <?php echo $username ?>
        </p>
    </header>

    <main>
    </main>

    <footer>
    </footer>

</body>

</html>