<?php
// *******************************************************************************
// * Laboration 4, Kurs: DT161G
// * File: includeMenu.php
// * Desc: Start page for laboration 2
// *
// * Henrik Henriksson
// * hehe0601
// * hehe0601@student.miun.se
// ****************************************************************************** 

$users = dbHandler::getInstance()->getMembersFromDataBase()

?>

<h2>Användare</h2>
<!-- This page holds tags that should be globally accessible by all pages -->
<nav>
    <ul id="ul">
        <?php foreach ($users as $key) : ?>
            <li><a href="<?php echo "images.php?user={$key->getUserName()}"; ?>">
                    <?php echo strtoupper($key->getUserName()); ?></a></li>
        <?php endforeach; ?>
    </ul>
    <h2>Länkar:</h2>
    <?php if (isset($_SESSION['validLogin'])) : ?>
        <?php foreach ($_SESSION['sessionLinks'] as $key => $value) : ?>
            <li><a href="<?php echo $value; ?>">
                    <?php echo strtoupper($key); ?></a></li>
        <?php endforeach; ?>
    <?php else : ?>
        <li>
            <a href="index.php">HEM</a>
        </li>
    <?php endif; ?>
</nav>