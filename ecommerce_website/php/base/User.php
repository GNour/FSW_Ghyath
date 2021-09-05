<?php

class User
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $gender;

    public function __construct($id, $firstName, $lastName, $email, $gender)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->gender = $gender;
    }

}
