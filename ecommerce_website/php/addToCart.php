<?php

session_start();
require_once "./config/connection.php";

$productId = $_GET["id"];
$cartId = $_SESSION["cart"];
$date = date('Y-m-d');

if ($stmt = $connection->prepare("SELECT id FROM cart_product WHERE product_id = $productId AND cart_id = $cartId")) {
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Already Added";
    } else if ($stmt = $connection->prepare("INSERT INTO `cart_product` (`product_id`, `cart_id`, `date`) VALUE (?, ?, ?)")) {
        $stmt->bind_param("iis", $productId, $cartId, $date);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Added to cart!";
        } else {
            echo "Not Added";
        }
    }
} else {
    echo $connection->error;
}
