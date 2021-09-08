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

    public static function checkoutCart($cartId, $total)
    {
        require_once "config/connection.php";

        $obj = array();
        $products = "";
        if ($stmt = $connection->query("SELECT product.name FROM product, cart_product WHERE product.quantity = 0 AND product.id = cart_product.product_id AND cart_product.cart_id = " . $cartId)) {

            if ($stmt->num_rows > 0) {
                while ($row = $stmt->fetch_assoc()) {
                    $products .= $row["name"] . ", ";
                }
                $obj["message"] = $products . " out of stock! Remove it to continue";
                $obj["code"] = 500;
            } else {
                if ($stmt = $connection->prepare("INSERT INTO `checkout` (`cart_id`, `total`, `date`) VALUES (?, ?, ?)")) {
                    $stmt->bind_param("ids", $cartId, $total, date('Y-m-d H:i:s'));
                    $stmt->execute();

                    $checkoutId = $connection->insert_id;

                    if ($stmt = $connection->query("INSERT INTO checkout_product (`product_id`,`checkout_id`) SELECT cart_product.product_id, checkout.id FROM checkout, cart_product WHERE cart_product.cart_id = " . $cartId . " AND checkout.cart_id = cart_product.cart_id AND checkout.id = " . $checkoutId)) {
                        if ($stmt = $connection->prepare("DELETE FROM cart_product WHERE cart_id = ?")) {
                            $stmt->bind_param("i", $cartId);
                            $stmt->execute();

                            if ($stmt = $connection->prepare("UPDATE product SET quantity = quantity - 1 WHERE id IN (SELECT product.id FROM product, checkout_product WHERE product.id = checkout_product.product_id AND checkout_product.id = ?) AND quantity >= 0")) {
                                $stmt->bind_param("i", $checkoutId);
                                $stmt->execute();

                                $obj["message"] = "Checkedout!";
                                $obj["code"] = 200;
                            } else {
                                $obj["message"] = "One of the items is out of stock!";
                                $obj["code"] = 500;
                            }

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
            }

        }

        echo json_encode($obj);
    }
}
