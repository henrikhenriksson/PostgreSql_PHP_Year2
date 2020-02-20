<?php

/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: admin.php
 * Desc: Admin page for laboration 4
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

// Här skall det ske kontroll om man har loggat in och är behörig att se denna sida.
// Ni måste också kontrollera att användaren har rollen admin för att få se denna sida
// Annars redirekt till starsidan

// if (inte behörig och rätt roll){
header("Location: index.php"); /* Redirect browser */
exit;
// }
// else {
//   $title = "Laboration 4"
//   .............
// }
?>


<!DOCTYPE html>
<html lang="sv-SE">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DT161G-Laboration4-admin</title>
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
            <div id="login">
                <h2>LOGIN</h2>
                <form id="loginForm">
                    <label><b>Username</b></label>
                    <input type="text" placeholder="m" name="uname" id="uname" required maxlength="10" value="m" autocomplete="off">
                    <label><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
                    <button type="button" id="loginButton">Login</button>
                </form>
            </div>
            <div id="logout">
                <h2>LOGOUT</h2>
                <button type="button" id="logoutButton">Logout</button>
            </div>
            <h2>MENY</h2>
            <nav>
                <ul>
                    <li>
                        <a href="guestbook.php">GÄSTBOK</a>
                    </li>

                </ul>
            </nav>
        </aside>
        <section>
            <h2>Adminsida</h2>
            <p>Denna sida skall bara kunna ses av inloggade medlemar,<br>
                som har administratörsrättigheter.</p>
        </section>
    </main>
    <footer>
        Footer
    </footer>
</body>

</html>