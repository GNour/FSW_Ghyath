<?php
echo "before require";
include "./base/App.php";
echo "after require";
if (isset($_POST["email"]) && isset($_POST["password"])
    && isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["gender"])) {
    echo "inside if";
    App::registerUser($_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["gender"], $_POST["password"]);
}
