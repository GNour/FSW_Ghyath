<?php
require_once "./base/Store.php";

$stores = Store::getStores();

echo $stores;
