<?PHP

/*******************************************************************************
 * Laboration 1, Kurs: DT161G
 * File: guestbook.php
 * Desc: Guestbook page for laboration 1
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
$title = "Laboration 1";

// Här skall alla server kod skrivas för gästboken.
session_start();
date_default_timezone_set('Europe/Stockholm');
//---------------------------------------------------------------------------
// $filename = "posts.json";
$filename = __DIR__ . "/../../writeable/posts.json";

// load posts from json file.
$posts = readFromFile($filename);

// Used for debugging and testing:
//setcookie('HasPosted', "PostedTrue", time() - 3600);

// Generate the random Captcha
$randCaptcha = generateCaptcha();

// initialize variables with empty strings.
$iName = '';
$iText = '';
$ErrorMessage = '';

// check wether something has been previously submitted
if (!empty($_POST)) {
    // check if the entered captcha was valid:
    if ($_POST['captcha'] === $_SESSION["sCap"]) {
        // store the values the user has entered.
        storePosts($posts);
        printToFile($posts, $filename);
        // set cookie
        setcookie('HasPosted', gethostname(), time() + (60 * 5));
        // Refresh the Page:
        header("Refresh:0");
    } else {
        // save the values.
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
function generateCaptcha()
{
    // Generate random captcha code:
    $captchaSeed = str_split('abcdefghijklmnopqrstuvwxyz'
        . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
        . '0123456789');
    $randomized = '';
    // loop through the array, calling rand function on the seed to select 5 values to add to the random captcha
    foreach (array_rand($captchaSeed, 5) as $key) {
        $randomized .= $captchaSeed[$key];
    }
    return $randomized;
}
//---------------------------------------------------------------------------
// function printStoredPosts(array $posts)
// {
//     foreach ($posts as $key) {

//         echo  "<tr>
//            <td>{$key['name']}</td>
//            <td>{$key['text']}</td>
//            <td> IP: {$key['ip']}<br> Tid: {$key['time']}</td>
//            </tr>";
//     }
// }
//---------------------------------------------------------------------------
function storePosts(array &$posts)
{
    $posts[] = [
        'name' => trim(htmlspecialchars($_POST["name"])),
        'text' => trim(htmlspecialchars($_POST["text"])),
        'ip' => gethostbyname(gethostname()),
        'time' => date("Y-m-d H:i:s", time())
    ];
}
//---------------------------------------------------------------------------
function readFromFile($filename)
{

    if (is_readable($filename)) {
        $postsJson = file_get_contents($filename);
        $parsedPosts = json_decode($postsJson, true);
        return $parsedPosts;
    } else {
        return [];
    }
}
//---------------------------------------------------------------------------
function printToFile(array &$posts, $filename)
{

    $postsJson = json_encode($posts);
    file_put_contents($filename, $postsJson);
    // file_put_contents($filename, $postsJson);
    // file_put_contents(__DIR__ . '/posts.json', $postsJson);

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
    <title>DT161G-Laboration1</title>
</head>

<body>
<header>
    <img src="img/mittuniversitetet.jpg" alt="miun logga" class="logo" />
    <h1><?php echo $title ?></h1>
</header>
<main>
    <aside>
        <h2>LOGIN</h2>
        <form action="index.php">
            <label><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname" required maxlength="10">
            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>
            <button type="submit">Login</button>
        </form>
        <h2>MENY</h2>
        <nav>
            <ul>
                <li>
                    <a href="index.php">HEM</a>
                </li>

            </ul>
        </nav>
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
            <form action="guestbook.php" method="POST">
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