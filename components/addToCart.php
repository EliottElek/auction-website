<?php
session_start();
require_once "config.php";
require "user.php";
require "objects.php";
$myNewChart = addToCart();
function addToCart()
{
    //we add object to cart, increment price and number of objects
    $object = $_SESSION["object"];
    $_SESSION["totalPrice"]  = $_SESSION["totalPrice"] + $_SESSION["priceToAdd"];
    array_push($_SESSION["cart"], $_SESSION["objectCATEG"] . $_SESSION["objectID"]);
    $_SESSION["cartObjects"][$_SESSION["nbObjects"]] = $object;
    $_SESSION["nbObjects"] = $_SESSION["nbObjects"] + 1;
    mysqli_close($_SESSION["succes"]);
    echo implode("-", $_SESSION["cart"]);
    return $_SESSION["cart"];
}
