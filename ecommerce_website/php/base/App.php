<?php

require_once "base/Store.php";
require_once "base/Product.php";
require_once "base/Wishlist.php";
require_once "base/Cart.php";

class App
{
    public static function loginUser($email, $password)
    {
        session_start();

        if (isset($_SESSION["user"])) {
            echo ("Already logged in");
            header("refresh:2;url=../test.php");
        } else {
            session_destroy();
            require_once "config/connection.php";

            $stmt = $connection->prepare("SELECT user.id, first_name, last_name, email, gender, cart.id, wishlist.id FROM user,wishlist,cart WHERE email = ? AND password = ? AND cart.user_id = user.id AND wishlist.user_id = user.id");
            $stmt->bind_param("ss", $email, hash("sha256", $password));
            $stmt->execute();

            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $firstName, $lastName, $email, $gender, $cartId, $wishlistId);
                $stmt->fetch();

                $stmt = $connection->prepare("SELECT id FROM store WHERE user_id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();

                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($storeId);
                    $stmt->fetch();
                    require_once "base/StoreOwner.php";

                    $storeOwner = new StoreOwner($id, $firstName, $lastName, $email, $gender, $storeId);
                    session_start();
                    $_SESSION["user"] = $storeOwner;
                } else {
                    require_once "base/User.php";
                    $user = new User($id, $firstName, $lastName, $email, $gender);
                    session_start();
                    $_SESSION["user"] = $user;
                }

                $_SESSION["cart"] = $cartId;
                $_SESSION["wishlist"] = $wishlistId;

                header("location: ../index.html");
            } else {
                echo 'Incorrect username and/or password!';
            }
        }

    }

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
