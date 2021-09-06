<?php

session_start();
require_once "./config/connection.php";

$productId = $_GET["id"];
$wishlistId = $_SESSION["wishlist"];
$date = date('Y-m-d');

if ($stmt = $connection->prepare("SELECT id FROM wishlist_product WHERE product_id = $productId AND wishlist_id = $wishlistId")) {
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Already Added";
    } else if ($stmt = $connection->prepare("INSERT INTO `wishlist_product` (`product_id`, `wishlist_id`, `date`) VALUE (?, ?, ?)")) {
        $stmt->bind_param("iis", $productId, $wishlistId, $date);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Added to Wishlist!";
        } else {
            echo "Not Added";
        }
    }
} else {
    echo $connection->error;
}
