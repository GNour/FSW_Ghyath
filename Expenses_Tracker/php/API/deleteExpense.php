<?php

include "../base/Expense.php";
$content = json_decode(trim(file_get_contents("php://input")), true);
if (isset($content["product_id"])) {
    echo json_encode(Expense::deleteExpense($content["product_id"]));
}
