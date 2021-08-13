<?php
//flash class
class flash extends objectToSale
{
    private $discount;
    private $endingTime;
    function __construct(string $productCateg, string $brand, string $model, string $capacity, string $size, float $startingPrice, string $picture, string $description, string $id, int $discount, string $endingTime)
    {
        parent::__construct($productCateg, $brand,  $model, $capacity, $size,  $startingPrice,  $picture, $description, $id);
        $this->discount = $discount;
        $this->endingTime = $endingTime;
    }
    function getDiscount()
    {
        return $this->discount;
    }
    function getEndingTime()
    {
        return $this->endingTime;
    }

}
