<?php
require_once "../base/User.php";
$content = json_decode(trim(file_get_contents("php://input")), true);

if (isset($content["email"]) && isset($content["password"])) {
    echo json_encode(User::loginUser($content["email"], $content["password"]));
}
