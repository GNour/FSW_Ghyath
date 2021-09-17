<?php

class Category
{
    protected $id;
    protected $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function get()
    {
        $category = [];
        $category["id"] = $this->id;
        $category["name"] = $this->name;

        return $category;
    }

    public static function addCategory($user_id, $name)
    {
        require_once "../config/connection.php";
        $stmt = $connection->prepare("INSERT INTO category (`user_id`, `name`) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $name);
        $stmt->execute();

        $inserted_id = $connection->insert_id;
        if ($stmt->affected_rows > 0) {

            return array("ok" => 200, "message" => "Added " . $name . " To Categories", "category_id" => $inserted_id, "name" => $name);
        } else {
            return array("ok" => 500, "message" => "Error adding category");
        }
    }

    public static function editCategory($id, $name)
    {
        $stmt = $connection->prepare("UPDATE category SET name = ? WHERE id = ?");
        $stmt = $connection->bind_param("si", $name, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Edited Category";
        } else {
            echo "Error Editing Expense";
        }
    }

    public static function deleteCategory($id)
    {
        $stmt = $connection->prepare("DELETE FROM category WHERE id = ?");
        $stmt = $connection->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Edited Category";
        } else {
            echo "Error Editing Expense";
        }
    }

}
