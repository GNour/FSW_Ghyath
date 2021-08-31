<?php

include "./config.php";
session_start();

if (isset($_POST["email"]) && isset($_POST["pass"])
    && isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["gender"])) {

    if ($stmt = $connection->prepare('SELECT email FROM user WHERE email = ?')) {
        $stmt->bind_param('s', $_POST['email']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo ("Email already exists, Try to login");
            header("refresh:2;url=../index.html");
        } else {
            if ($stmt = $connection->prepare("INSERT INTO user (`email`, `password`, `first_name`, `last_name`, `gender`) VALUES (?, ?, ?, ?, ?)")) {
                $stmt->bind_param("sssss", $_POST["email"], hash('sha256', $_POST["pass"]), $_POST["firstName"], $_POST["lastName"], $_POST["gender"]);
                $stmt->execute();
            }

            if ($stmt->affected_rows > 0) {
                header("location: ../index.html");
            } else {
                echo 'An error occured' . $stmt->error;
            }
        }
    }
} else {
    echo "Your registeration form is not complete!";
}
