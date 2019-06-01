<?php

function get_db() {
    $db = mysqli_connect('localhost', 'root', 'root', 'ITECH3108_30331986_A1');

    if (!$db) die(mysqli_connect_error());
    else return $db;
}

function get_hash($pass) {
    $bytes = openssl_random_pseudo_bytes(30);
    $random_data = substr(base64_encode($bytes), 0, 22);
    $random_data = strtr($random_data, '+', '.');

    $local_salt = "$2y$12$" . $random_data;
    return crypt($pass, $local_salt);
}