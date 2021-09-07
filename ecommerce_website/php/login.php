<?php

require_once "./base/User.php";

if (isset($_POST["email"]) && isset($_POST["password"]) && validateEmail()) {
    User::loginUser($_POST["email"], $_POST["password"]);
}

function validateEmail()
{
    if (strlen($_POST["email"]) > 5 && strripos($_POST["email"], ".") > strripos($_POST["email"], "@") && strripos($_POST["email"], "@")) {
        return true;
    }

    return false;
}
