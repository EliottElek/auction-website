<?php
//class credit card
class card
{
    private $lastname;
    private $digit;
    private $expdate;
    private $crypto;

    public function __construct(string $lastname, string $digit, string $expdate, string $crypto)
    {
        $this->lastname = $lastname;
        $this->digit = $digit;
        $this->expdate = $expdate;
        $this->crypto = $crypto;
    }
    function getLastname()
    {
        return $this->lastname;
    }
    function getDigit()
    {
        return $this->digit;
    }
    function getExpDate()
    {
        return $this->expdate;
    }
    function getCrypto()
    {
        return $this->crypto;
    }
}
