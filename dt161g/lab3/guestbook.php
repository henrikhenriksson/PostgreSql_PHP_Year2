<?PHP

/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: guestbook.php
 * Desc: Guestbook page for laboration 2
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
session_start();
$title = "Laboration 3";

// Här skall alla server kod skrivas för gästboken.
date_default_timezone_set('Europe/Stockholm');
//---------------------------------------------------------------------------
// Set filename path to the writable folder
$filename = __DIR__ . "/../../writeable/posts.json";
// load posts from json file.
$posts = readFromFile($filename);

// Used for debugging and testing:
//setcookie('HasPosted', "PostedTrue", time() - 3600);

// Generate the random Captcha
$len = 5;
$randCaptcha = generateCaptcha(5);

// initialize variables with empty strings.
$iName = '';
$iText = '';
$ErrorMessage = '';

// check whether something has been previously submitted
if (!empty($_POST)) {
    // check if the entered captcha was valid:
    if ($_POST['captcha'] === $_SESSION["sCap"]) {
        // store the values the user has entered.
        storePosts($posts);
        printToFile($posts, $filename);
        // set cookie, currently set to 5 minutes for testing.
        setcookie('HasPosted', gethostname());
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
$_SESSION["sCap"] = $randCaptcha;

//---------------------------------------------------------------------------
// Function Defenitions:
//---------------------------------------------------------------------------

// this function generates a unique captcha of 5 chars from a selection specified in the seed variable.
function generateCaptcha(int $len)
{
    // Generate random captcha code:
    $captchaSeed = str_split('abcdefghijklmnopqrstuvwxyz'
        . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
        . '0123456789');
    $randomized = '';
    // loop through the array, calling rand function on the seed to select 5 values to add to the random captcha
    foreach (array_rand($captchaSeed, $len) as $key) {
        $randomized .= $captchaSeed[$key];
    }
    return $randomized;
}
//---------------------------------------------------------------------------
// store the post to the guestbook array, making sure to reformat any special characters as scripting protection.
function storePosts(array &$posts)
{
    $posts[] = [
        'name' => trim(htmlspecialchars($_POST["name"])),
        'text' => trim(htmlspecialchars($_POST["text"])),
        'ip' => getIP(),
        'time' => date("Y-m-d H:i:s", time())
    ];
}
//---------------------------------------------------------------------------
// checks for the users ip adress, also attempts to get the correct ip address even if the user has a proxy.
function getIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from remote address
    else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}

//---------------------------------------------------------------------------
// Read from file. First checks to make sure the file is readable.
function readFromFile($filename)
{

    if (is_readable($filename)) {
        $postsJson = file_get_contents($filename);
        return json_decode($postsJson, true);
    } else {
        return [];
    }
}
//---------------------------------------------------------------------------
// print the guestbook posts array to file.
function printToFile(array &$posts, $filename)
{
    $postsJson = json_encode($posts);
    file_put_contents($filename, $postsJson);
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
                <?php foreach ($posts as $key) : ?>
                    <tr>
                        <td><?php echo $key['name'] ?></td>
                        <td><?php echo $key['text'] ?> </td>
                        <td> <?php echo "IP:{$key['ip']}" ?> <br>
                            <?php echo "Tid: {$key['time']}" ?> </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <!-- Only print the form if the user has not previously posted: -->
            <?php if (!(isset($_COOKIE["HasPosted"]))) : ?>
                <form action="guestbook.php" method="POST" id="form" class="<?php echo $loggedout ?>">
                    <fieldset>
                        <legend>Skriv i gästboken</legend>
                        <label>Från: </label>
                        <input type="text" placeholder="Skriv ditt namn" name="name" value="<?php echo $iName; ?>" required>
                        <br>
                        <label for="text">Inlägg</label>
                        <textarea id="text" name="text" rows="10" cols="50" placeholder="Skriva meddelande här" required><?php echo $iText; ?></textarea>
                        <br>
                        <label>Captcha: <span class="red"><?php echo $randCaptcha; ?></span></label>
                        <input type="text" placeholder="Skriva captcha här" name="captcha" required>
                        <button type="submit">Skicka</button>
                        <br>
                        <h3 class="red"><?php echo $ErrorMessage; ?></h3>
                    </fieldset>
                </form>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        Footer
    </footer>
</body>

</html>