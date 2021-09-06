<?php

session_start();
require_once "./config/connection.php";

$productId = $_GET["id"];
$wishlistId = $_SESSION["wishlist"];

if ($stmt = $connection->prepare("DELETE FROM wishlist_product WHERE product_id = $productId AND wishlist_id = $wishlistId")) {
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->affected_rows > 0) {
        echo "Removed From Wishlist!";
    } else {
        echo "Already Removed!";
    }
} else {
    echo $connection->error;
}
