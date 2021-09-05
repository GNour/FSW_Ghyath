<?php

require_once "./base/App.php";
echo "after require";

if (isset($_POST["email"]) && isset($_POST["password"])) {
    echo "inside if";
    App::loginUser($_POST["email"], $_POST["password"]);
}
