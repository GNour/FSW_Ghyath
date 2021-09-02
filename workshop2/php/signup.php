<?php

include "./connection.php";
extract($_POST);

echo validateAge();

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
        && isset($_POST["birthday"])) {
        return true;
    }
    return false;
}

function validatePassword()
{
    if ($password == $confirmPassword) {
        return true;
    }
    return false;
}

function validateEmail()
{
    if (strlen($email) > 5 && strripos(".", $email) > strripos("@", $email) && strripos("@") != -1) {
        return true;
    }

    return false;
}

function validateAge()
{

    // $birthday can be UNIX_TIMESTAMP or just a string-date.
    if (is_string($birthday)) {
        $birthday = strtotime($birthday);
    }

    // check
    // 31536000 is the number of seconds in a 365 days year.
    if (time() - $birthday < $age * 31536000) {
        return false;
    }

    return true;

}

function validateName()
{
    if (strlen($first_name) > 3 && strlen($last_name) > 3) {
        return true;
    }

    return false;
}

function validatePhone()
{
    if (strpos("+961", $phone) == 0 && (strlen($phone) == 12 || strlen($phone) == 11)) {
        return true;
    }
    return false;
}
