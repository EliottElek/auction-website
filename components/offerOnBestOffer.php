<?php
//class offer on best offer
class offerOnBestOffer
{
    private $sellerid;
    private $buyerid;
    private $offerid;
    private $startingprpice;
    private $sellernego;
    private $buyernego;
    private $attemptsleft;

    function __construct(int $sellerid, int $buyerid, int $offerid, float $startingprpice, float $sellernego, float $buyernego, int $attemptsleft)
    {
        $this->sellerid = $sellerid;
        $this->buyerid = $buyerid;
        $this->offerid = $offerid;
        $this->startingprpice = $startingprpice;
        $this->sellernego = $sellernego;
        $this->buyernego = $buyernego;
        $this->attemptsleft = $attemptsleft;
    }
    function getSellerId()
    {
        return $this->sellerid;
    }
    function getBuyerId()
    {
        return $this->buyerid;
    }
    function getOfferId()
    {
        return $this->offerid;
    }
    function getStartingPrice()
    {
        return $this->startingprpice;
    }
    function getSellerNego()
    {
        return $this->sellernego;
    }
    function getBuyerNego()
    {
        return $this->buyernego;
    }
    function getAttemptsLeft()
    {
        return $this->attemptsleft;
    }
}
