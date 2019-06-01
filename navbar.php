<?php

if (!isset($_SESSION))
    session_start();

if (isset($_SESSION['username'])) {
    // logged in
    ?>
    <img src="<?= $_SESSION['photo_url'] ?>" height="60" width="60">
    Logged in as <?= $_SESSION['username'] ?>
    <a href="matches.php">matches</a>
    <a href="settings.php">settings</a>
    <a href="messages.php">messages</a>
    <a href="logout.php">log out</a>
    <?php
} else {
    // logged out
    ?>
    <a href="signup.php">sign up</a>
    <a href="login.php">log in</a>
    <?php
} ?>