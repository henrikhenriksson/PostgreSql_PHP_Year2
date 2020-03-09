<?PHP

/*******************************************************************************
 * Project Assignment, Kurs: DT161G
 * File: images.php
 * Desc: Image page for dt161g Project Assignment
 *
 * Henrik Henriksson 
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
session_start();
require('util.php');


$title = "DT161G - Bildsida";
$username = "No User is set!";
$currentUser = null;
$currentCategory = null;
$valid = false;
$users = dbHandler::getInstance()->getMembersFromDataBase();

if (isset($_GET["user"])) {
    $imageDir = "../../writeable/{$_GET['user']}";
    $username = "Invalid User!";
    foreach ($users as $key) {
        if ($key->getUserName() === $_GET["user"]) {
            $currentUser = $key;
            $username = $key->getUserName();
        }
    }

    if (isset($_GET["category"]) && $currentUser != null) {
        foreach ($currentUser->getCategories() as $cKey) {
            if ($cKey->getCategoryName() === $_GET["category"]) {
                $currentCategory = $cKey;
            }
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

        <?php require 'includeLogin.php'; ?>
    </header>

    <main>
        <aside>
            <?php require 'includeUsers.php'; ?>
        </aside>
        <section>
            <h3>
                Personlig sida för användare: <?php echo $username ?>
            </h3>
            <div id="ImageShowCase">
                <?php if ($currentUser != null && $currentCategory != null) : ?>
                    <?php foreach ($currentCategory->getImages() as $image) : ?>
                        <img src="<?php echo $imageDir ?>/<?php echo $currentCategory->getCategoryName() ?>/<?php echo $image->getImgName() ?>" alt="image loaded server." class="image">
                    <?php endforeach; ?>
                <?php elseif ($currentUser != null && !isset($_GET['category'])) : ?>
                    <?php foreach ($currentUser->getCategories() as $cKey) : ?>
                        <?php foreach ($cKey->getImages() as $cImage) : ?>
                            <img src="<?php echo $imageDir ?>/<?php echo $cKey->getCategoryName() ?>/<?php echo $cImage->getImgName() ?>" alt="image loaded server." class="image">
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Error: Invalid user or category</p>
                <?php endif; ?>

            </div>
        </section>
    </main>

    <footer>
        <?php require 'includeFooter.php' ?>
    </footer>

</body>

</html>