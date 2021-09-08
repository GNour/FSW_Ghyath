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

    public static function checkoutCart($cart_id, $total)
    {
        require_once "config/connection.php";

        $obj = array();
        if ($stmt = $connection->prepare("INSERT INTO `checkout` (`cart_id`, `total`, `date`) VALUES (?, ?, ?)")) {
            $stmt->bind_param("ids", $cart_id, $total, date('Y-m-d H:i:s'));
            $stmt->execute();

            $checkoutId = $connection->insert_id;

            if ($stmt = $connection->query("INSERT INTO checkout_product (`product_id`,`checkout_id`) SELECT cart_product.product_id, checkout.id FROM checkout, cart_product WHERE cart_product.cart_id = " . $cart_id . " AND checkout.cart_id = cart_product.cart_id AND checkout.id = " . $checkoutId)) {
                if ($stmt = $connection->prepare("DELETE FROM cart_product WHERE cart_id = ?")) {
                    $stmt->bind_param("i", $cart_id);
                    $stmt->execute();

                    $obj["message"] = "Checkedout!";
                    $obk["code"] = 200;

                } else {
                    $obj["message"] = "Couldn't Delete Products From Cart!";
                    $obj["code"] = 500;
                }
            } else {
                $obj["message"] = "Couldn't Insert Into checkout_product";
                $obj["code"] = 500;
            }
        } else {
            $obj["message"] = "Couldn't Checkout!";
            $obj["code"] = 500;
        }

        echo json_encode($obj);
    }
}
