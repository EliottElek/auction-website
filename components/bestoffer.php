<?php
//class best offer
class bestoffer extends objectToSale
{
    private $sellerid;
    function __construct(string $productCateg, string $brand, string $model, string $capacity, string $size, float $startingPrice, string $picture, string $description, string $id, int $sellerid)
    {
        parent::__construct($productCateg, $brand,  $model, $capacity, $size,  $startingPrice,  $picture, $description, $id);
        $this->sellerid = $sellerid;
    }
    function getSellerId()
    {
        return $this->sellerid;
    }
}
