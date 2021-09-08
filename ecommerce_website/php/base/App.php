<?php

require_once "base/Store.php";
require_once "base/Product.php";
require_once "base/Wishlist.php";
require_once "base/Cart.php";

class App
{

    public static function getStores()
    {
        require_once "config/connection.php";
        require_once "base/Store.php";

        $stmt = $connection->query('SELECT * FROM store');

        while ($row = $stmt->fetch_assoc()) {
            $store = new Store($row["id"], $row["name"], $row["description"], $row["store_image"], $row["store_header_image"],
                $row["phone_number"], $row["email"], $row["street"], $row["city"], $row["country"], $row["user_id"]);

            $stores[$row["id"]] = $store->convertToArray();
        }

        return json_encode($stores);
    }

}
