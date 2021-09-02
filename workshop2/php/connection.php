<?php

$server = "localhost";
$username = "root";
$password = "root";
$dbname = "workshop2";

$connection = new mysqli($server, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Failed");
}
