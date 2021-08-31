<?php

include "./config.php";
session_start();

echo $_POST["email"], $_POST["pass"], $_POST["firstName"], $_POST["lastName"], $_POST["gender"];

if (isset($_POST["email"]) && isset($_POST["pass"])
    && isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["gender"])) {

    if ($stmt = $connection->prepare("INSERT INTO user (`email`, `password`, `first_name`, `last_name`, `gender`) VALUES (?, ?, ?, ?, ?)")) {
        $stmt->bind_param("sssss", $_POST["email"], hash('sha256', $_POST["pass"]), $_POST["firstName"], $_POST["lastName"], $_POST["gender"]);
        $stmt->execute();
    }

    if ($stmt->affected_rows > 0) {
        header("location: ../index.html");
    } else {
        echo $stmt->error;
        echo 'Incorrect username and/or password!';
    }
}
