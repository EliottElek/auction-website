<?php
//class adress 
class adress
{
    private $country;
    private $city;
    private $postal;
    private $adress;

    public function __construct(string $country, string $city, string $postal, string $adress)
    {
        $this->country = $country;
        $this->city = $city;
        $this->postal = $postal;
        $this->adress = $adress;
    }
    function getCountry()
    {
        return $this->country;
    }
    function getCity()
    {
        return $this->city;
    }
    function getPostal()
    {
        return $this->postal;
    }
    function getAdress()
    {
        return $this->adress;
    }
}
