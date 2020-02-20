<?PHP

/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: guestbook.php
 * Desc: Guestbook page for laboration 2
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
session_start();
require('util.php');
$title = "Laboration 4";
//---------------------------------------------------------------------------
// initiate a new database handler.
$dbHandler = new dbHandler();

// determine wether or not the user is logged in, or if a cookie is set. Only valid users that are logged in should be able to post more than once.
$setShoworHide = (!(isset($_COOKIE['miunCookie'])) || isset($_SESSION['validLogin'])) ? "" : "hide";

// initialize variables with empty strings.
$iName = '';
$iText = '';
$ErrorMessage = '';

// check whether something has been previously submitted
if (!empty($_POST)) {
    // check if the entered captcha was valid:
    if ($_POST['captcha'] === $_SESSION["sCap"]) {
        // store the values the user has entered.
        $newPost = new Post($_POST['name'], $_POST['text']);
        $array = $newPost->getPostArray();
        $dbHandler->storePostToDatabase($array);
        // set cookie if post was successfull.
        setcookie('miunCookie', gethostname());
        // Refresh the Page:
        header("Location: guestbook.php");
    } else {
        // save the values, in case the user enteres incorrect captchka
        $iName = $_POST['name'];
        $iText = $_POST['text'];
        $ErrorMessage = "Incorrect Captchka, please try again [No Robots!]";
    }
}
// save the previous captchka
$_SESSION["sCap"] = Captcha::generateCaptcha();

//---------------------------------------------------------------------------

/*******************************************************************************
 * HTML section starts here
 ******************************************************************************/
?>
<!DOCTYPE html>
<html lang="sv-SE">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" />
    <title>DT161G-<?php echo $title ?></title>
    <!-- dont forget to include the damn script! -->
    <script src="js/main.js"></script>
</head>

<body>
    <header>
        <img src="img/mittuniversitetet.jpg" alt="miun logga" class="logo" />
        <h1><?php echo $title ?></h1>
    </header>
    <main>
        <aside>
            <?php require 'includeLogin.php'; ?>
            <?php require 'includeMenu.php'; ?>
        </aside>
        <section>
            <h2>GÄSTBOK</h2>
            <table>
                <tr>
                    <th class="th20">FRÅN
                    </th>
                    <th class="th40">INLÄGG
                    </th>
                    <th class="th40">LOGGNING
                    </th>
                </tr>
                <!-- create a  new table row for each post in the posts array -->
                <?php foreach ($dbHandler->getPostsFromDatabase() as $key) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($key->getname()) ?></td>
                        <td><?php echo htmlspecialchars($key->getMessage()) ?> </td>
                        <td> <?php echo "IP:{$key->getIP()}" ?> <br>
                            <?php echo "Tid: {$key->getTime()}" ?> </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <form action="guestbook.php" method="POST" id="form" class="<?php echo $setShoworHide ?>">
                <fieldset>
                    <legend>Skriv i gästboken</legend>
                    <label>Från: </label>
                    <input type="text" placeholder="Skriv ditt namn" name="name" value="<?php echo $iName; ?>" required>
                    <br>
                    <label for="text">Inlägg</label>
                    <textarea id="text" name="text" rows="10" cols="50" placeholder="Skriva meddelande här" required><?php echo $iText; ?></textarea>
                    <br>
                    <label>Captcha: <span class="red"><?php echo $_SESSION['sCap']; ?></span></label>
                    <input type="text" placeholder="Skriva captcha här" name="captcha" required>
                    <button type="submit">Skicka</button>
                    <br>
                    <h3 class="red"><?php echo $ErrorMessage; ?></h3>
                </fieldset>
            </form>
        </section>
    </main>
    <footer>
        Footer
    </footer>
</body>

</html>