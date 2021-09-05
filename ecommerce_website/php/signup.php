<?php

require_once "./base/App.php";

if (isset($_POST["email"]) && isset($_POST["pass"])
    && isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["gender"])) {

    App::registerUser($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["gender"], $_POST["password"]);
}
