<?PHP

/*******************************************************************************
 * Laboration 2, Kurs: DT161G
 * File: index.php
 * Desc: Start page for laboration 2
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
$title = "Laboration 2";
session_start();


$loggedIn = isset($_SESSION['validLogin']) ? "hide" : "";
$loggedOut = isset($_SESSION['validLogin']) ? "" : "hide";


/*******************************************************************************
 * HTML section starts here
 ******************************************************************************/
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
    </header>
    <main>
        <aside>
            <div id="login" class="<?php echo $loggedIn; ?>">
                <h2>LOGIN</h2>
                <form id="loginForm">
                    <label><b>Username</b></label>
                    <input type="text" placeholder="m" name="uname" id="uname" required maxlength="10" value="m" autocomplete="off">
                    <label><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
                    <button type="button" id="loginButton">Login</button>
                </form>
            </div>
            <div id="logout" class="<?php echo $loggedOut; ?>">
                <h2>LOGOUT</h2>
                <button type="button" id="logoutButton">Logout</button>
            </div>
            <h2>MENY</h2>
            <nav>
                <ul id="ul">
                    <?php if (isset($_SESSION['validLogin'])) : ?>
                        <?php foreach ($_SESSION['sessionLinks'] as $key => $value) : ?>
                            <li><a href="<?php echo $value; ?>">
                                    <?php echo $key; ?></a></li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li>
                            <a href="index.php">HEM</a>
                        </li>
                        <li>
                            <a href="guestbook.php">GÄSTBOK</a>
                        </li>

                    <?php endif; ?>
                </ul>
            </nav>
        </aside>
        <section>
            <h2>VÄLKOMMEN
            </h2>
            <p>Detta är andra laborationen</p>
            <p id="count"></p>
        </section>
    </main>
    <footer>
        Footer
    </footer>
</body>

</html>