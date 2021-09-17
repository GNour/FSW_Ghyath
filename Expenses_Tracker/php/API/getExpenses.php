<?php

require_once "../base/User.php";
require_once "../base/Expense.php";
require_once "../base/Category.php";
session_start();

$json["expenses"] = $_SESSION["user"]->getExpenses();
$json["categories"] = $_SESSION["user"]->getCategories();
echo json_encode($json, JSON_PRETTY_PRINT);
