<?php

require_once "./config/connection.php";
require_once "./base/StoreOwner.php";

session_start();

$productId = $_GET["id"];
$storeId = $_SESSION["user"]->getStoreId();
if ($stmt = $connection->prepare("DELETE FROM product WHERE id = ? AND store_id = ?")) {
    $stmt->bind_param("ii", $productId, $storeId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->affected_rows > 0) {
        echo "Removed Product!";
    } else {
        echo "Already Removed!";
    }
} else {
    echo $connection->error;
}
