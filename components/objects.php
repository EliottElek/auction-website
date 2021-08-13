<?php
//main item class
class objectToSale {
    private $productCateg;
   private $brand;
   private $model;
   private $capacity;
   private $size;
   private $price;
   private $picture;
   private $description;
   private $id;

   public function __construct(string $productCateg,string $brand, string $model,string $capacity,string $size, float $price, string $picture,string $description,string $id) {
    $this->productCateg = $productCateg;
    $this->brand = $brand;
    $this->model = $model;
    $this->capacity = $capacity;
    $this->size = $size;
    $this->price = $price;
    $this->picture = $picture;
    $this->description = $description;
    $this->id = $id;

}
function getProductCategory()
   {
       return $this->productCateg;
   }
    function getBrand()
   {
       return $this->brand;
   }
    function getModel()
   {
       return $this->model;
   }
    function getCapacity()
   {
       return $this->capacity;
   }
   function getSize()
   {
       return $this->size;
   }
   function getPrice()
   {
    return $this->price;
   }
   function getPicture()
   {
    return $this->picture;
   }
   function getDescription()
   {
    return $this->description;
   }
   function getId()
   {
    return $this->id;
   }
   function getDiscount(){
       // Overriden in class flash
       return 0;
   }
   function getEndingTime(){
    // Overriden in class flash
    return 0;
}
function setPrice(float $price){
    $this->price = round($price);
}
}
