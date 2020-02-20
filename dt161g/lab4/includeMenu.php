<!-- *******************************************************************************
* Laboration 4, Kurs: DT161G
* File: includeMenu.php
* Desc: Start page for laboration 2
*
* Henrik Henriksson
* hehe0601
* hehe0601@student.miun.se
****************************************************************************** -->

<h2>MENY</h2>
<!-- This page holds tags that should be globally accessible by all pages -->
<nav>
    <ul id="ul">
        <!-- Check for valid session. If so - Set the appropriate menu: -->
        <?php if (isset($_SESSION['validLogin'])) : ?>
            <?php foreach ($_SESSION['sessionLinks'] as $key => $value) : ?>
                <li><a href="<?php echo $value; ?>">
                        <?php echo strtoupper($key); ?></a></li>
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