<?php
require_once "./base/User.php";
require_once "./base/StoreOwner.php";

session_start();

$json = array();
if (isset($_SESSION["user"])) {
    $json["loggedIn"] = 1;
    if ($_SESSION["user"] instanceof StoreOwner) {
        $json["store"] = $_SESSION["user"]->getStoreId();
    }
    $json["cart"] = $_SESSION["cart"];
    $json["wishlist"] = $_SESSION["wishlist"];
} else {
    $json["loggedIn"] = 0;
}
echo json_encode($json);
