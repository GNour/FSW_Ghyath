<?php

class Wishlist
{
    private $id;
    private $userId;
    private $products;

    public function __construct($id, $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }
}
