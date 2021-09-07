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

    public static function registerUser($firstName, $lastName, $email, $gender, $password)
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

}
