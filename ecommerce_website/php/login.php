<?php

require_once "./base/App.php";

if (isset($_POST["email"]) && isset($_POST["password"])) {
    App::loginUser($_POST["email"], $_POST["password"]);
}
