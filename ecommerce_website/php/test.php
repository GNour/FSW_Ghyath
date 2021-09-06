<?php

require_once "./base/App.php";
require_once "./base/Product.php";
require_once "./base/User.php";
require_once "./base/StoreOwner.php";
require_once "./base/Wishlist.php";
require_once "./base/Cart.php";

session_start();
$userId = $_SESSION["user"]->getId();

echo Product::getStoreProducts(1);
// echo App::getStores();
