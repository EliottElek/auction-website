<?php
class user
{
    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $buyer = false;

    public function __construct(int $id, string $fname, string $lname, string $mail, bool $buyer)
    {
        $this->id = $id;
        $this->firstname = $fname;
        $this->lastname = $lname;
        $this->email = $mail;
        $this->buyer = $buyer;
    }
    function getId()
    {
        return $this->id;
    }
    function getFirstname()
    {
        return $this->firstname;
    }
    function getLastname()
    {
        return $this->lastname;
    }
    function getEmail()
    {
        return $this->email;
    }
    function isBuyer()
    {
        return $this->buyer;
    }
    function setBuyer(bool $isbuyer)
    {
        $this->buyer = $isbuyer;
    }
}
