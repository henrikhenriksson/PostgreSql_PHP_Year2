<?PHP
/*******************************************************************************
 * Laboration 1, Kurs: DT161G
 * File: index.php
 * Desc: Start page for laboration 1
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
$title = "Laboration 1"


/*******************************************************************************
 * HTML section starts here
 ******************************************************************************/
?>
<!DOCTYPE html>
<html lang="sv-SE">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"/>
    <title>DT161G-Laboration1</title>
</head>
<body>
<header>
    <img src="img/mittuniversitetet.jpg" alt="miun logga" class="logo"/>
    <h1><?php echo $title ?></h1>
</header>
<main>
    <aside>
        <h2>LOGIN</h2>
        <form action="index.php">
            <label><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname"
                   required maxlength="10">
            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw"
                   required>
            <button type="submit">Login</button>
        </form>
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
        <h2>VÄLKOMMEN
        </h2>
        <p>Detta är första laborationen</p>
    </section>
</main>
<footer>
    Footer
</footer>
</body>
</html>
