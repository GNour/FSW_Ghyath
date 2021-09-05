<?php

class Cart
{
    private $id;
    private $userId;
    private $total;
    private $products;

    public function __construct($id, $userId, $total)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->total = $total;
    }
}
