<?php

require_once "../base/User.php";
require_once "../base/Category.php";
session_start();

$user_id = $_SESSION["user"]->getId();
$content = json_decode(trim(file_get_contents("php://input")), true);

if (isset($content["name"])) {
    echo json_encode(Category::addCategory($user_id, $content["name"]));
}
