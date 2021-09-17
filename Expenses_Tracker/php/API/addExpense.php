<?php

require_once "../base/Expense.php";
require_once "../base/User.php";
session_start();

$user_id = $_SESSION["user"]->getId();
$content = json_decode(trim(file_get_contents("php://input")), true);
if (isset($content["amount"]) && isset($content["date"])) {
    echo json_encode(Expense::addExpense($user_id, $content["category_id"], $content["amount"], $content["date"]));
}
