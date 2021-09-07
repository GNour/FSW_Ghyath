<?php

class Store
{
    private $storeId;
    private $name;
    private $description;
    private $images;
    private $phoneNumber;
    private $email;
    private $street;
    private $city;
    private $country;
    private $userId;

    public function __construct($storeId, $name, $description, $storeImage,
        $storeHeaderImage, $phoneNumber, $email, $street, $city, $country, $userId) {
        $this->storeId = $storeId;
        $this->name = $name;
        $this->description = $description;
        $this->images[] = $storeImage;
        $this->images[] = $storeHeaderImage;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->street = $street;
        $this->city = $city;
        $this->country = $country;
        $this->userId = $userId;
    }

    public function convertToArray()
    {
        $object = array("id" => $this->storeId,
            "name" => $this->name,
            "description" => $this->description,
            "image" => $this->images[0],
            "headerImage" => $this->images[1],
            "phoneNumber" => $this->phoneNumber,
            "email" => $this->email,
            "street" => $this->street,
            "city" => $this->city,
            "country" => $this->country,
            "userId" => $this->userId);

        return $object;
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

}
