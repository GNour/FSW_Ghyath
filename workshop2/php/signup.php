<?php

include "./connection.php";

if (validForm()) {

    $phone = str_replace(" ", "", $_POST["phone"]);
    $email = $_POST["email"];
    $password = hash('sha256', $_POST["password"]);
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $gender = intval($_POST["gender"]);
    $date = date('Y-m-d', strtotime($_POST["birthday"]));
    $city = $_POST["city"];

    if ($stmt = $connection->prepare('SELECT email FROM users WHERE email = ?')) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            header("refresh:2;url=../login.html");
        } else {
            if ($stmt = $connection->prepare("INSERT INTO users (`email`, `password`, `first_name`, `last_name`, `gender`, `phone_number`, `date_of_birth`, `city`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
                $stmt->bind_param("ssssisss", $email, $password, $first_name, $last_name, $gender, $phone, $date, $city);
                $stmt->execute();
            }

            if ($stmt->affected_rows > 0) {
                header("location: ../login.html");
            } else {
                echo 'An error occured' . $stmt->error;
            }
        }
    }
} else {
    header("location: ../index.html");
}

function validForm()
{
    if (isset($_POST["email"])
        && isset($_POST["first_name"])
        && isset($_POST["last_name"])
        && isset($_POST["gender"])
        && isset($_POST["phone"])
        && isset($_POST["password"])
        && isset($_POST["confirm_password"])
        && isset($_POST["city"])
        && isset($_POST["birthday"])
        && validateAge()
        && validatePassword()
        && validateEmail()
        && validateName()
        && validatePhone()) {
        return true;
    }
    return false;
}

function validatePassword()
{
    if ($_POST["password"] == $_POST["confirm_password"]) {
        return true;
    }
    return false;
}

function validateEmail()
{
    if (strlen($_POST["email"]) > 5 && strripos($_POST["email"], ".") > strripos($_POST["email"], "@") && strripos($_POST["email"], "@")) {
        return true;
    }

    return false;
}

function validateAge()
{

    if (is_string($_POST["birthday"])) {
        $birthday = strtotime($_POST["birthday"]);
    }

    if (time() - $birthday < 18 * 31556926) {
        return false;
    }

    return true;

}

function validateName()
{
    if (strlen($_POST["first_name"]) > 3 && strlen($_POST["last_name"]) > 3) {
        return true;
    }

    return false;
}

function validatePhone()
{
    $_POST["phone"] = str_replace(" ", "", $_POST["phone"]);
    if (strpos("+961", $_POST["phone"]) == 0 && (strlen($_POST["phone"]) == 12 || strlen($_POST["phone"]) == 11)) {
        return true;
    }
    return false;
}
