<?php
require_once "./User.php";

class StoreOwner extends User
{
    private $storeId;

    public function __construct($id, $firstName, $lastName, $email, $gender, $storeId)
    {
        parent::__construct($id, $firstName, $lastName, $email, $gender);

        $this->storeId = $storeId;
    }
}
