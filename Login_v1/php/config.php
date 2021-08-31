<?php

$server = "localhost";
$username = "root";
$password = "root";
$dbname = "logindb";

$connection = new mysqli($server, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Failed");
}
