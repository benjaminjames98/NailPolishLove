<?php

session_start();

if (isset($_SESSION['username'])) {
    // if already logged in, redirect
    header("Location: matches.php");
    die();
}