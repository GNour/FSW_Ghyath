<?php

class Cart
{
    private $id;
    private $userId;
    private $products;

    public function __construct($id, $userId, $total)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->total = $total;
    }

    public static function getUserCart($cartId, $userId)
    {
        require_once "base/Product.php";
        require_once "config/connection.php";
        echo "before";
        $productsArray = Product::getProductsOfUserCart($cartId);
        echo "after";
        $cart = new Cart($cartId, $userId, $productsArray);
        return json_encode($cart->convertToArray());
    }

    public function convertToArray()
    {
        $object = array("id" => $this->id,
            "userId" => $this->userId,
            "products" => $this->products);

        return $object;
    }
}
