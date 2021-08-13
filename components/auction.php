<?php
//class auction
class auction extends objectToSale
{
    private $currentBid;
    private $endingTime;
    private $bestBidder;
    function __construct(string $productCateg, string $brand, string $model, string $capacity, string $size, float $startingPrice, string $picture, string $description, string $id, float $currentBid, string $endingTime, string $bestBidder)
    {
        parent::__construct($productCateg, $brand,  $model, $capacity, $size,  $startingPrice,  $picture, $description, $id);
        $this->currentBid = $currentBid;
        $this->endingTime = $endingTime;
        $this->bestBidder = $bestBidder;
    }
    function getCurrentBid()
    {
        return $this->currentBid;
    }
    function getEndingTime()
    {
        return $this->endingTime;
    }
    function getBestBidder()
    {
        return $this->bestBidder;
    }
}
