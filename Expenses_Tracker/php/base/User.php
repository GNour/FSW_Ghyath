<?php

class User
{
    protected $id;
    protected $email;
    protected $categories;
    protected $expenses;

    public function __construct($id, $email)
    {
        $this->id = $id;
        $this->email = $email;
        $this->expenses = $this->getUserExpenses($id);
        $this->categories = $this->getUserCategories($id);

    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setExpenses($expenses)
    {
        return $this->expenses = $expenses;
    }

    public function setCategories($categories)
    {
        return $this->categories = $categories;
    }

    public function getExpenses()
    {
        require_once "../base/Expense.php";
        $expenses = [];
        foreach ($this->expenses as $key => $value) {
            $expenses[$key] = $value->get();
        }
        return $expenses;
    }

    public function getCategories()
    {
        require_once "../base/Category.php";
        $categories = [];
        foreach ($this->categories as $key => $value) {
            $categories[$key] = $value->get();
        }
        return $categories;
    }

    private function getUserCategories($id)
    {
        // Require_once was including the connection
        include "../config/connection.php";
        $categories = [];

        if ($stmt = $connection->query("SELECT `id`, `name` FROM `category` WHERE `user_id` =  " . $id)) {

            while ($row = $stmt->fetch_assoc()) {
                require_once "../base/Category.php";
                $category = new Category($row["id"], $row["name"]);
                $categories[$row["id"]] = $category;
            }

        }

        return $categories;

    }

    private function getUserExpenses($id)
    {
        include "../config/connection.php";

        $expenses = [];

        $stmt = $connection->query("SELECT * FROM expense WHERE expense.user_id = " . $id);
        while ($row = $stmt->fetch_assoc()) {
            require_once "../base/Expense.php";
            $expense = new Expense($row["id"], $row["category_id"], $row["date"], $row["amount"]);
            $expenses[$row["id"]] = $expense;
        }

        return $expenses;

    }

    public static function checkIfUserLoggedIn()
    {
        session_start();
        if (isset($_SESSION["user"])) {
            $user = new User($_SESSION["user"]->getId(), $_SESSION["user"]->getEmail());
            $_SESSION["user"] = $user;
            return array("ok" => 200, "message" => "Welcome back " . $_SESSION["user"]->getEmail() . " ");
        } else {
            return array("ok" => 500, "message" => "Please Login");
        }
    }

    public static function loginUser($email, $userPass)
    {
        require_once "../config/connection.php";

        $stmt = $connection->prepare("SELECT user.id FROM user WHERE user.email = ? AND user.password = ?");
        $stmt->bind_param("ss", $email, hash("sha256", $userPass));
        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id);
            $stmt->fetch();
            $stmt->close();

            $user = new User($id, $email);
            session_start();

            $_SESSION["user"] = $user;

            return array("ok" => 200, "message" => "Welcome " . $email . " ");
        } else {
            return array("ok" => 500, "message" => "Sorry Couldn't login you in");
        }

    }

    public static function registerUser($email, $userPass)
    {
        require_once "config/connection.php";

        if ($stmt = $connection->prepare('SELECT email FROM user WHERE email = ?')) {
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo ("Email already exists, Try to login");
                header("refresh:2;url=../login.html");
            } else {
                if ($stmt = $connection->prepare("INSERT INTO user (`email`, `password`) VALUES (?, ?)")) {
                    $stmt->bind_param("ss", $email, hash("sha256", $userPass));
                    $stmt->execute();

                }
                if ($stmt->affected_rows > 0) {

                    header("location: ../login.html");
                } else {
                    echo 'An error occured' . $stmt->error;
                }
            }

        }
    }

}
