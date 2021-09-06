<?php

require_once "./base/Product.php";

$storeId = $_GET["store"];
echo Product::getStoreProducts($storeId);
