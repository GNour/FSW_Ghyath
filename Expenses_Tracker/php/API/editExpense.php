<?php

require_once "../base/Expense.php";

$content = json_decode(trim(file_get_contents("php://input")), true);
if (isset($content["amount"]) && isset($content["date"])) {
    echo json_encode(Expense::editExpense($content["id"], $content["category_id"], $content["amount"], $content["date"]));
}
