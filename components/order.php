<?php
//class order
class order
{
    private $customerID;
    private $name;
    private $price;
    private $adress;
    private $comment;
    private $orderDate;
    private $shippingDate;
    private $id;

    public function __construct(string $customerID, string $name, string $adress, string $orderDate, float $price, string $shippingDate,string $comment, string $id)
    {
        $this->customerID = $customerID;
        $this->name = $name;
        $this->adress = $adress;
        $this->comment = $comment;
        $this->orderDate = $orderDate;
        $this->shippingDate = $shippingDate;
        $this->price = $price;
        $this->id = $id;
    }
    function getCustomerID()
    {
        return $this->customerID;
    }
    function getName()
    {
        return $this->name;
    }
    function getAdress1()
    {
        return $this->adress;
    }
    function getComment()
    {
        return $this->comment;
    }
    function getOrderDate()
    {
        return $this->orderDate;
    }
    function getShippingDate()
    {
        return $this->shippingDate;
    }
    function getPrice()
    {
        return $this->price;
    }
    function getId()
    {
        return $this->id;
    }
}
