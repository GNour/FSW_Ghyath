<?php

require_once "./base/Cart.php";
require_once "./base/User.php";
require_once "./base/StoreOwner.php";

session_start();
$cartId = $_SESSION["cart"];
$total = $_POST["total"];
if ($total > 0) {
    Cart::checkoutCart($cartId, $total);
} else {
    $obj = array();
    $obj["message"] = "Add products to your cart!";
    $obj["code"] = 500;
    echo json_encode($obj);
}
