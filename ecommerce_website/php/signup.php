<?php
require_once "./base/User.php";

if (isset($_POST["email"]) && isset($_POST["password"])
    && isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["gender"])
    && validatePassword() && validateEmail()) {
    User::registerUser($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["gender"], $_POST["password"]);
}

function validatePassword()
{
    if ($_POST["password"] == $_POST["confirmPassword"]) {
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
