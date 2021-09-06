<?php

session_start();
require_once "./config/connection.php";

$productId = $_GET["id"];
$cartId = $_SESSION["cart"];

if ($stmt = $connection->prepare("DELETE FROM cart_product WHERE product_id = $productId AND cart_id = $cartId")) {
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->affected_rows > 0) {
        echo "Removed From Cart!";
    } else {
        echo "Already Removed!";
    }
} else {
    echo $connection->error;
}
