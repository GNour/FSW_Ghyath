<?php

include "./config.php";
session_start();

if (isset($_POST["email"]) && isset($_POST["pass"])) {
    $stmt = $connection->prepare("SELECT first_name, last_name, gender FROM user WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $_POST["email"], hash('sha256', $_POST["pass"]));
    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($firstname, $lastname, $gender);
        $stmt->fetch();

        if ($gender == 'M') {
            $_SESSION['title'] = "Mr.";
        } else {
            $_SESSION['title'] = "Ms.";
        }
        $_SESSION['first_name'] = $firstname;
        $_SESSION['last_name'] = $lastname;

        header("location: ../home.php");
    } else {
        echo 'Incorrect username and/or password!';
    }
}
