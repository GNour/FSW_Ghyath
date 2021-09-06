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

            $stmt = $connection->prepare("SELECT id, first_name, last_name, email, gender FROM user WHERE email = ? AND password = ?");
            $stmt->bind_param("ss", $email, hash("sha256", $password));
            $stmt->execute();

            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $firstName, $lastName, $email, $gender);
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

                header("location: ../index.html");
            } else {
                echo 'Incorrect username and/or password!';
            }
        }

    }

    public static function registerUser($firstName, $lastName, $email, $gender, $password)
    {
        require_once "config/connection.php";
        if ($connection->ping()) {
            echo "ok";
        } else {
            echo $connection->error;
        }
        if ($stmt = $connection->prepare('SELECT email FROM user WHERE email = ?')) {
            echo "before select";
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $stmt->store_result();
            echo "after select";

            if ($stmt->num_rows > 0) {
                echo ("Email already exists, Try to login");
                header("refresh:2;url=../login.html");
            } else {
                if ($stmt = $connection->prepare("INSERT INTO user (`email`, `password`, `first_name`, `last_name`, `gender`) VALUES (?, ?, ?, ?, ?)")) {
                    $stmt->bind_param("ssssi", $email, hash("sha256", $password), $firstName, $lastName, $gender);
                    $stmt->execute();

                }
                if ($stmt->affected_rows > 0) {
                    $user_id_inserted = $connection->insert_id;
                    echo $user_id_inserted;
                    $stmt->close();
                    if ($cart = $connection->prepare("INSERT INTO `cart` (`user_id`) VALUES (?)")) {
                        $cart->bind_param("i", $user_id_inserted);
                        echo $cart->error;
                        $cart->execute();
                    } else {
                        echo 'An error occured' . $cart->error;
                    }

                    if ($wishlist = $connection->prepare("INSERT INTO `wishlist` (`user_id`) VALUES (?)")) {
                        $wishlist->bind_param("i", $user_id_inserted);
                        $wishlist->execute();
                    } else {
                        echo 'An error occured' . $wishlist->error;
                    }

                    header("location: ../login.html");
                } else {
                    echo 'An error occured' . $stmt->error;
                }
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
