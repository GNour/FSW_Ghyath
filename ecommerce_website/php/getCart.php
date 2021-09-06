<?php

require_once "./base/Product.php";
require_once "./base/User.php";
require_once "./base/StoreOwner.php";
session_start();

$userId = $_SESSION["user"]->getId();
$cart = Product::getProductsOfUserCart($userId);

echo ($cart);
