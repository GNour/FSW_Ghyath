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
    public function loginUser($email, $password)
    {
        session_start();

        if (isser($_SESSION["user"])) {
            header("location: ../home.php");
        }

        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $stmt = $connection->prepare("SELECT id, first_name, last_name, email, gender FROM user WHERE email = ? AND password = ?");
            $stmt->bind_param("ss", $_POST["email"], hash('sha256', $_POST["password"]));
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
                } else {
                    $user = new User($id, $firstName, $lastName, $email, $gender);
                }

                header("location: ../home.php");
            } else {
                echo 'Incorrect username and/or password!';
            }
        }
    }
}
