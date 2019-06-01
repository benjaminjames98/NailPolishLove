<?php

session_start();

if (!isset($_SESSION['username'])) {
    // if not already logged in, redirect
    header("Location: login.php");
    die();
}