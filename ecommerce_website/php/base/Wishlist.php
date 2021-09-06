<?php

class Wishlist
{
    private $id;
    private $userId;
    private $products;

    public function __construct($id, $userId, $products)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->products = $products;
    }

    public static function getUserWishlist($wishlistId, $userId)
    {
        require_once "base/Product.php";
        $productsArray = Product::getProductsOfUserWishlist($_SESSION["wishlist"]);
        $wishlist = new Wishlist($_SESSION["wishlist"], $_SESSION["user"]->getId(), $productsArray);
        return json_encode($wishlist->convertToArray());
    }

    public function convertToArray()
    {
        $object = array("id" => $this->id,
            "userId" => $this->userId,
            "products" => $this->products);

        return $object;
    }
}
