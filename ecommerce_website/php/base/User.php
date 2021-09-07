<?php

class User
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $gender;

    public function __construct($id, $firstName, $lastName, $email, $gender)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->gender = $gender;
    }

    public function getId()
    {
        return $this->id;
    }

    public static function loginUser($email, $userPass)
    {
        session_start();
        if (isset($_SESSION["user"])) {
            echo ("Already logged in");
            header("refresh:2;url=../test.php");
        } else {
            session_destroy();
            require_once "config/connection.php";

            $stmt = $connection->prepare("SELECT user.id, first_name, last_name, email, gender, cart.id, wishlist.id FROM user,wishlist,cart WHERE cart.user_id = user.id AND wishlist.user_id = user.id AND user.email = ? AND user.password = ?");
            $stmt->bind_param("ss", $email, hash("sha256", $userPass));
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

    public static function registerUser($firstName, $lastName, $email, $gender, $userPass)
    {
        require_once "config/connection.php";

        if ($stmt = $connection->prepare('SELECT email FROM user WHERE email = ?')) {
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo ("Email already exists, Try to login");
                header("refresh:2;url=../login.html");
            } else {
                if ($stmt = $connection->prepare("INSERT INTO user (`email`, `password`, `first_name`, `last_name`, `gender`) VALUES (?, ?, ?, ?, ?)")) {
                    $stmt->bind_param("ssssi", $email, hash("sha256", $userPass), $firstName, $lastName, $gender);
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

}
