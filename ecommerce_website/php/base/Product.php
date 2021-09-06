<?php

class Product
{
    private $id;
    private $name;
    private $description;
    private $price;
    private $quantity;
    private $imagePrimary;
    private $imageHover;
    private $storeId;

    public function __construct($id, $name, $description, $price, $quantity, $storeId, $imagePrimary, $imageHover)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->storeId = $storeId;
        $this->imagePrimary = $imagePrimary;
        $this->imageHover = $imageHover;
    }

    public static function getProductsOfUserWishlist($wishlistId)
    {
        require_once "config/connection.php";
        $stmt = $connection->query('SELECT product.* FROM product, wishlist_product WHERE product.id = wishlist_product.product_id AND wishlist_product.wishlist_id = ' . $wishlistId);

        while ($row = $stmt->fetch_assoc()) {

            if ($imgQuery = $connection->query('SELECT path FROM image WHERE product_id = ' . $row["id"])) {

                while ($img = $imgQuery->fetch_assoc()) {
                    $imgs[] = $img["path"];
                }

            } else {
                echo $connection->error;
            }

            $product = new Product($row["id"], $row["name"], $row["description"], $row["price"], $row["quantity"],
                $row["store_id"], $imgs[0], $imgs[1]);

            $products[$row["id"]] = $product->convertToArray();
        }
        return $products;
    }

    public static function getProductsOfUserCart($cartId)
    {
        require_once "config/connection.php";
        if ($stmt = $connection->query('SELECT product.* FROM product, cart_product WHERE product.id = cart_product.product_id AND cart_product.cart_id = ' . $cartId)) {
            while ($row = $stmt->fetch_assoc()) {
                if ($imgQuery = $connection->query('SELECT path FROM image WHERE product_id = ' . $row["id"])) {

                    while ($img = $imgQuery->fetch_assoc()) {
                        $imgs[] = $img["path"];
                    }

                } else {
                    echo $connection->error;
                }

                $product = new Product($row["id"], $row["name"], $row["description"], $row["price"], $row["quantity"],
                    $row["store_id"], $imgs[0], $imgs[1]);

                $products[$row["id"]] = $product->convertToArray();
            }
        } else {
            echo "else";
            return $connection->error;
        }
        return json_encode($products);
    }

    public static function getStoreProducts($storeId)
    {
        require_once "config/connection.php";
        $stmt = $connection->query('SELECT product.* FROM product,store WHERE product.store_id = store.id AND store_id = ' . $storeId);

        while ($row = $stmt->fetch_assoc()) {

            if ($imgQuery = $connection->query('SELECT path FROM image WHERE product_id = ' . $row["id"])) {

                while ($img = $imgQuery->fetch_assoc()) {
                    $imgs[] = $img["path"];
                }

            } else {
                echo $connection->error;
            }

            $product = new Product($row["id"], $row["name"], $row["description"], $row["price"], $row["quantity"],
                $row["store_id"], $imgs[0], $imgs[1]);

            $products[$row["id"]] = $product->convertToArray();
        }
        $stmt = $connection->query('SELECT * FROM store WHERE id = ' . $storeId);

        while ($row = $stmt->fetch_assoc()) {
            $store["name"] = $row["name"];
            $store["city"] = $row["city"];
            $store["street"] = $row["street"];
            $store["country"] = $row["country"];
            $store["phone"] = $row["phone_number"];
            $store["email"] = $row["email"];
            $store["header"] = $row["store_header_image"];
        }
        $products["store"] = $store;

        return json_encode($products);
    }

    public function convertToArray()
    {
        $object = array("id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "image" => $this->imagePrimary,
            "hoverImage" => $this->imageHover,
            "price" => $this->price,
            "quantity" => $this->quantity,
            "storeId" => $this->storeId);

        return $object;
    }

    public function setQuantitySelected($qty)
    {
        $this->quantitySelected = $qty;
    }

    public function setSubTotal()
    {
        $this->subTotal = $this->price * $this->quantity;
    }
}
