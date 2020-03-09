<?php

/*******************************************************************************
 * Project Assignment, Kurs: DT161G
 * File: userpage.php
 * Desc: Userpage page for dt161g Project Assignment
 *
 * Henrik Henriksson 
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

session_start();
require('util.php');

if (!isset($_SESSION['validLogin'])) {
    header("Location: index.php"); /* Redirect browser */
    exit;
} else {
    $title = "DT161G - Användarsida";
}
//---------------------------------------------------------------------------
$createMessage = "";
$removeMessage = "";
$currentUser;
// Always send a new request for members to the database to ensure added categories are listed.
$userArray = dbHandler::getInstance()->getMembersFromDataBase();

// get the current user:
foreach ($userArray as $uKey) {
    if ($_SESSION['validLogin'] == $uKey->getUserName()) {
        $currentUser = $uKey;
    }
}

if (isset($_SESSION['createMessage'])) {
    $createMessage = $_SESSION['createMessage'];
    unset($_SESSION['createMessage']);
} elseif (isset($_SESSION['removeMessage'])) {
    $removeMessage = $_SESSION['removeMessage'];
    unset($_SESSION['removeMessage']);
}

if (isset($_POST['newCategory'])) {
    // Check if the entered category already exists in the database:
    $validCategory = true;
    foreach ($currentUser->getCategories() as $cKey) {
        if ($_POST['newCategory'] === $cKey->getCategoryName()) {
            $validCategory = false;
        }
    }

    if (!$validCategory) {
        $createMessage = "Sorry, that Category already exists for this user.";
    } else {
        // Add the Category to the user Database.
        DbHandler::getInstance()->addNewCategory($_POST['newCategory'], $currentUser->getId());
        FileHandler::getInstance()->createCategoryFolder($currentUser->getUserName(), $_POST['newCategory']);
        $_SESSION['createMessage'] = "New Category added succesfully.";
        header("Location: userpage.php");
    }
}
if (isset($_POST['removeCategory'])) {

    $currentCategoryId = 0;
    foreach ($currentUser->getCategories() as $key) {
        if ($_POST['removeCategory'] === $key->getCategoryName()) {
            $currentCategoryId = $key->getId();
        }
    }
    // Send request to remove the category from the database.
    dbHandler::getInstance()->removeCategory($currentCategoryId);
    FileHandler::getInstance()->removeCategoryFolder($currentUser->getUserName(), $_POST['removeCategory']);
    $_SESSION['removeMessage'] = "Category removed succesfully.";
    header("Location: userpage.php");
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
    <title>DT161G-<?php echo $title ?>-member</title>
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/main.js"></script>
</head>

<body>

    <header>
        <img src="img/mittuniversitetet.jpg" alt="miun logga" class="logo" />
        <h1><?php echo $title ?></h1>
        <?php require 'includeLogin.php'; ?>
    </header>

    <main>
        <aside>
            <!-- require the incluion of these pages: -->
            <?php require 'includeUsers.php'; ?>
        </aside>
        <section>
            <p class="bold red">Du är inloggad som användare: <?php echo $_SESSION['validLogin'] ?></p>
            <p class="IntroText">
                Denna sida skall endast kunna nås om man loggat in.<br>
                På denna sida så skall ni få en lista på de kategorier/mappar som ni har som användare.<br>
                Det skall också gå att skapa nya kategorier på denna sida.<br>
                På denna sida skall man också kunna ladda upp bilder och välja vilken kategori som bilden skall hamna i.
            </p>
            <div id="categoryDiv">
                <p class="bold">Create a new Category</p>
                <form id="categoryForm" action="userpage.php" method="POST">
                    <input type="text" name="newCategory" id="newCategory" required>
                    <button type="submit" id="categoryButton">Create Category</button>
                </form>
                <p id="categoryStatus"><?php echo $createMessage ?></p>
            </div>
            <?php if ($currentUser->getCategories() != null) : ?>
                <div id="uploadDiv">
                    <form id="uploadForm">
                        <p class="bold">Select Image to Upload</p>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <p id="categoryChooserLabel">Select a Category</p>
                        <select name="categories" id="categorySelector">
                            <?php foreach ($currentUser->getCategories() as $key) : ?>
                                <option><?php echo $key->getCategoryName() ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <button type="button" id="uploadButton">Upload Image</button>
                    </form>
                    <p id="uploadStatus"></p>
                </div>
                <div id="removeCategory">
                    <p class="bold">
                        Remove selected category
                    </p>
                    <form id="removeForm" action="userpage.php" method="POST">
                        <select name="removeCategory" id="removalSelector">
                            <?php foreach ($currentUser->getCategories() as $key) : ?>
                                <option><?php echo $key->getCategoryName() ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" id="removeCategory">Remove Category</button>
                    </form>
                    <p id="categoryStatus"><?php echo $removeMessage ?></p>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <?php require 'includeFooter.php' ?>
    </footer>

</body>

</html>