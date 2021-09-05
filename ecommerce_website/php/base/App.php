<?php
require_once "../config/connection.php";
require_once "./User.php";
require_once "./StoreOwner.php";
require_once "./Store.php";
require_once "./Product.php";
require_once "./Wishlist.php";
require_once "./Cart.php";

class App
{
    public static function loginUser($email, $password)
    {
        session_start();

        if (isset($_SESSION["user"])) {
            header("location: ../../index.html");
        }

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

                $storeOwner = new StoreOwner($id, $firstName, $lastName, $email, $gender, $storeId);
                $_SESSION["user"] = $storeOwner;

            } else {
                $user = new User($id, $firstName, $lastName, $email, $gender);
                $_SESSION["user"] = $user;
            }

            header("location: ../../index.html");
        } else {
            echo 'Incorrect username and/or password!';
        }
    }

    public static function registerUser($firstName, $lastName, $email, $gender, $password)
    {

        if ($stmt = $connection->prepare('SELECT email FROM user WHERE email = ?')) {
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo ("Email already exists, Try to login");
                header("refresh:2;url=../../login.html");
            } else {
                if ($stmt = $connection->prepare("INSERT INTO user (`email`, `password`, `first_name`, `last_name`, `gender`) VALUES (?, ?, ?, ?, ?)")) {
                    $stmt->bind_param("sssss", $email, hash("sha256", $password), $firstName, $lastName, $gender);
                    $stmt->execute();
                }
                if ($stmt->affected_rows > 0) {
                    header("location: ../../login.html");
                } else {
                    echo 'An error occured' . $stmt->error;
                }
            }

        }
    }
}
