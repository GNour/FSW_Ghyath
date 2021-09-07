<?php

require_once "base/Store.php";
require_once "base/Product.php";
require_once "base/Wishlist.php";
require_once "base/Cart.php";

class App
{

    public static function createStore($name, $description, $country, $city, $street, $phone, $email, $imagePrimary, $imageHeader)
    {
        require_once "config/connection.php";
        require_once "base/User.php";
        session_start();

        print_r($_SESSION["user"]);
        if ($stmt = $connection->prepare('INSERT INTO `store` (`name`, `description`, `store_image`, `store_header_image`, `phone_number`, `email`, `user_id`, `street`, `city`, `country`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )')) {
            $stmt->bind_param('ssssssisss', $name, $description, $imagePrimary, $imageHeader, $phone, $email, $_SESSION["user"]->getId(), $street, $city, $country);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                header("location: ./logout.php");
            } else {
                echo 'An error occured' . $stmt->error;
            }

        }
    }

    public static function addProduct($name, $description, $price, $quantity, $images)
    {
        require_once "config/connection.php";
        require_once "base/StoreOwner.php";
        session_start();

        if ($stmt = $connection->prepare('INSERT INTO `product` (`name`, `description`, `price`, `quantity`, `store_id`) VALUES ( ?, ?, ?, ?, ?)')) {
            $stmt->bind_param('sssss', $name, $description, $price, $quantity, $_SESSION["user"]->getStoreId());
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $productId = $connection->insert_id;
                foreach ($images as $image) {
                    if ($stmt = $connection->prepare('INSERT INTO `image` (`path`, `product_id`) VALUES ( ?, ?)')) {
                        $stmt->bind_param('si', $image, $productId);
                        $stmt->execute();
                    }
                }
                echo "Added " . $name . " Successfully !";
            } else {
                echo 'Error adding' . $name;
            }
        }
    }

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
