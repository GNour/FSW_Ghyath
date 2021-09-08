<?php

require_once "./base/Product.php";
require_once "./base/StoreOwner.php";
session_start();

$storeId = $_SESSION["user"]->getStoreId();
echo Product::getStoreProducts($storeId);
