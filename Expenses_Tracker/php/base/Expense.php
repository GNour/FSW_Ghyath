<?php

class Expense
{
    protected $id;
    protected $category_id;
    protected $date;
    protected $amount;

    public function __construct($id, $category_id, $date, $amount)
    {
        $this->id = $id;
        $this->category_id = $category_id;
        $this->date = $date;
        $this->amount = $amount;
    }

    public function get()
    {
        $expense = [];
        $expense["id"] = $this->id;
        $expense["category_id"] = $this->category_id;
        $expense["date"] = $this->date;
        $expense["amount"] = $this->amount;
        return $expense;
    }

    public static function addExpense($user_id, $category_id, $amount, $date)
    {
        include "../config/connection.php";
        $stmt = $connection->prepare("INSERT INTO expense (`user_id`, `category_id`, `date`, `amount`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $user_id, $category_id, date("Y-m-d", strtotime($date)), $amount);
        $stmt->execute();
        $inserted_id = $connection->insert_id;
        if ($stmt->affected_rows > 0) {
            return array("ok" => 200, "message" => "Added " . $name . " To Expenses", "expense_id" => $inserted_id);
        } else {
            return array("ok" => 500, "message" => "Error adding expense");
        }
    }

    public static function editExpense($id, $category_id, $amount, $date)
    {
        include "../config/connection.php";
        if ($stmt = $connection->prepare("UPDATE expense SET expense.category_id = ?, expense.amount = ?, expense.date = ? WHERE expense.id = ?")) {
            $stmt->bind_param("issi", $category_id, $amount, date("Y-m-d", strtotime($date)), $id);
            $stmt->execute();
        }

        if ($stmt->affected_rows > 0) {
            return array("ok" => 200, "message" => "Edited");
        } else {
            return array("ok" => 500, "message" => "Error editing expense");
        }
    }

    public static function deleteExpense($id)
    {
        include "../config/connection.php";

        if ($stmt = $connection->query("DELETE FROM expense WHERE id = " . $id)) {
            return array("ok" => 200, "message" => "Delete " . $name . " From Expenses");
        } else {
            return array("ok" => 500, "message" => "Error Deleting Expense");
        }
    }
}
