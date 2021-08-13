<?php
require_once "config.php";
require "user.php";
require "objects.php";
require "order.php";
require "auction.php";
require "bestoffer.php";
require "offerOnBestOffer.php";
$status = array();
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
if (isset($_POST["submitresearch"]) && $_POST["submitresearch"]) {
    $search = $_POST['researchInput'];
    header("location: results.php?research=$search");
  }
//loading the background image if the user is a buyer
$indexOfColor = 0;
if ($_SESSION["user"]->isBuyer()) {
  $id = $_SESSION["user"]->getId();
  $sqlseller = mysqli_query($succes, $sqlseller = "SELECT `backgroundindex` FROM `sellerprofiles` WHERE `sellerID` LIKE $id ");
  $row = mysqli_num_rows($sqlseller);
  $compteurA = 0;
  while ($row > $compteurA) {
    $result = mysqli_fetch_assoc($sqlseller);
    $indexOfColor = $result["backgroundindex"];
    $compteurA = $compteurA + 1;
  }
}
//loading all auctions linked to user
$id = $_SESSION["user"]->getId();
$bestbidder = $_SESSION["user"]->getFirstname() . " " . $_SESSION["user"]->getLastname();
$sql = mysqli_query($succes, $sql = "SELECT * FROM `auctions` WHERE `bestBidder` like '$bestbidder'");
$row = mysqli_num_rows($sql);
$compteur = 0;
while ($row > $compteur) {
    $result = mysqli_fetch_assoc($sql);
    $auctions[$compteur] = new auction($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"], $result["currentBid"], $result["endingTime"], $result["bestBidder"]);
    $compteur = $compteur + 1;
}
//loading all sales that the user has won
$id = $_SESSION["user"]->getId();
$bestbidder = $_SESSION["user"]->getFirstname() . " " . $_SESSION["user"]->getLastname();
$sql = mysqli_query($succes, $sql = "SELECT * FROM `bestoffers` WHERE `winnerID` like $id ");
$row = mysqli_num_rows($sql);
$compteurB = 0;
$wins = array();
while ($row > $compteurB) {
    $result = mysqli_fetch_assoc($sql);
    $wins[$compteurB] = new bestoffer($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"], $result["sellerID"]);
    $compteurB = $compteurB + 1;
}
//loading all offers that the user is currently making
$compteur2 = 0;
$id = $_SESSION["user"]->getId();
$sql = mysqli_query($succes, $sql = "SELECT * FROM `offersonbestoffers` WHERE `buyerID` LIKE $id");
$row = mysqli_num_rows($sql);
$compteur2 = 0;
$bestoffers = array();
$sellers = array();
while ($row > $compteur2) {
    $result = mysqli_fetch_assoc($sql);
    $bestoffers[$compteur2] = new offerOnBestOffer($result["sellerID"], $result["buyerID"], $result["offerID"], $result["startingprice"], $result["sellernego"], $result["buyernego"], $result["attemptsleft"]);
    //getting the buyer's first and lastname
    $idSeller = $result["sellerID"];
    $sql2 = mysqli_query($succes, $sql2 = "SELECT `firstname`, `lastname` FROM `users` WHERE `id` like '$idSeller'");
    $result2 = mysqli_fetch_assoc($sql2);
    $buyers[$compteur2] = $result2["firstname"] . " " . $result2["lastname"];
    //getting the item's model and brand
    $idItem = $result["offerID"];
    $sql3 = mysqli_query($succes, $sql3 = "SELECT `brand`, `model` FROM `bestoffers` WHERE `id` like $idItem");
    $result3 = mysqli_fetch_assoc($sql3);
    $items[$compteur2] = $result3["brand"] . " " . $result3["model"];
    $compteur2 = $compteur2 + 1;
}
//if he decides to negitiate
if (isset($_POST["negotiate"]) && $_POST["negotiate"]) {
    $index = $_POST["index"];
    $buyerId = $_SESSION["user"]->getId();
    $newPrice = $_POST["negotiatePrice"];
    $attemptsLeft = $bestoffers[$index]->getAttemptsLeft() - 1;
    if ($attemptsLeft<0){
        $attemptsLeft = 0;
    }
    //we update the sql
    $sql = "UPDATE `offersonbestoffers` SET `attemptsleft`=$attemptsLeft,`buyernego`= $newPrice WHERE `buyerID` LIKE $buyerId";

    if ($link->query($sql) === TRUE) {
        echo "best offer modified successfully";
        header("refresh: 0");
    } else {
        echo "Error deleting record: " . $link->error;
    }

    $link->close();
}
mysqli_close($succes);
//if he decides to delete his proposition
if (isset($_POST["deleteProposition"])&&$_POST["deleteProposition"]){
    $index = $_POST['index']-1;
    $sellerID = $bestoffers[$index]->getSellerId();
    $buyerID = $bestoffers[$index]->getBuyerId();
    $offerID = $bestoffers[$index]->getOfferId();
  
    // sql to delete the proposition
    $sql = "DELETE FROM `offersonbestoffers` WHERE `sellerID` LIKE '$sellerID' && `buyerID` LIKE '$buyerID' && `offerID` LIKE '$offerID'";
    
    if ($link->query($sql) === TRUE) {
      echo "Proposition deleted successfully";
      header("refresh: 0");
    } else {
      echo "Error deleting record: " . $link->error;
    }
    
    $link->close();
  }
  //if user accepts proposition
  if (isset($_POST["acceptProposition"]) && $_POST["acceptProposition"]) {
    $index = $_POST['indexAccept'] - 1;
    $sellerID = $bestoffers[$index]->getSellerId();
    $buyerID = $bestoffers[$index]->getBuyerId();
    $offerID = $bestoffers[$index]->getOfferId();
    $finalPrice = $bestoffers[$index]->getSellerNego();
    // sql to delete a record
    //we delete the offer
    $sql = "DELETE FROM `offersonbestoffers` WHERE `offerID` LIKE $offerID";
    //we indicate the the best offer is now complete
    $sql2 = "UPDATE `bestoffers` SET `status`= 'complete',`price`= $finalPrice,`winnerID`= '$buyerID' WHERE `id` LIKE $offerID";
    if ($link->query($sql) === TRUE && $link->query($sql2) === TRUE) {
      echo "Proposition deleted successfully";
      echo "Status modified successfully";
      header("refresh: 0");
    } else {
      echo "Error deleting record: " . $link->error;
    }
  
    $link->close();
  }
?>
<html>

<head>
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
    <style>
        <?php include "../assets/myProfile.css" ?><?php include "../assetsmyOrders.css" ?><?php include "../assets/myAdresses.css" ?><?php include "../assets/mySales.css" ?><?php include "../assets/mainPage.css" ?>
        #accept {
            width: 120px;
        }
  #cancel {
            width: 120px;
            background-color: red;
            border-radius: 3px;
            border: none;
            outline: none;
            height: 30px;
        }

        #cancel:hover {
            cursor: pointer;
            border: 1px solid black;
            transition: 0.3s ease;
        }
    </style>
    <link href="mainPage.css" rel="stylesheet" type="text/css" />
    <link href="myProfile.css" rel="stylesheet" type="text/css" />
    <title>Yourmarket</title>
    <script>
        function logOut() {
            $.post("logOut.php", function() {});
            window.location.reload();
        }
    </script>
</head>

<body>
    <section>
    <div class="infos" style="display:none; transform:translateY(900%)">
    <input type="text" id="status" value='<?php echo $_SESSION["user"]->isBuyer() ?>'>
    <input type="text" id="indexofcolor" value='<?php echo $indexOfColor ?>'>
  </div>
        <h1>My auctions</h1>
        <h3>(If no auctions are shown and you already bidded on one, this is probably that you are not the best current bidder)</h3>
        <div class="myOrders">
            <table style="text-align: center; border: 1px solid black; margin-top:-200px;">
                <tbody>
                    <tr>
                        <td><strong>product number</strong></td>
                        <td><strong>starting bid</strong></td>
                        <td><strong>current bid</strong></td>
                        <td><strong>ending time</strong></td>
                        <td><strong>status</strong></td>
                    </tr>
                    <?php for ($i = 0; $i < $compteur; $i++) { ?>
                        <tr>
                            <td><?php echo $auctions[$i]->getId() ?></td>
                            <td><?php echo $auctions[$i]->getPrice() ?>£</td>
                            <td><?php echo $auctions[$i]->getCurrentBid() ?>£</td>
                            <td><?php echo $auctions[$i]->getEndingTime() ?></td>
                            <?php if (getDiffDates($auctions[$i]->getEndingTime()) <= 0) { ?>
                                <td><strong style="color:green">auction won</strong></td>
                            <?php } else { ?>
                                <td><strong style="color:orange">currently best bidder</strong></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <h1>My best offers</h1>
        <div class="myOrders">
        <table style="text-align: center; border: 1px solid black;margin-top:-100px;">
          <tbody>
            <tr>
              <td><strong>offer number</strong></td>
              <td><strong>Item</strong></td>
              <td><strong>Original price</strong></td>
              <td><strong>seller</strong></td>
              <td><strong>your proposition</strong></td>
              <td><strong>his proposition</strong></td>
              <td><strong>attempts left</strong></td>
              <td colspan="3"><strong>your choice</strong></td>
            </tr>
            <?php for ($i = 0; $i < $compteur2; $i++) { ?>
              <form action="" method="post">
                <tr>
                  <td><?php echo $bestoffers[$i]->getOfferId() ?></td>
                  <td><?php echo $items[$i] ?></td>
                  <td><?php echo $bestoffers[$i]->getStartingPrice() ?></td>
                  <td style="color:red; text-transform:uppercase"><?php echo $buyers[$i] ?></td>
                  <td style="color:red"><?php echo $bestoffers[$i]->getBuyerNego() ?> £</td>
                  <td style="color:red"><?php echo $bestoffers[$i]->getSellerNego() ?> £</td>
                  <td><?php echo $bestoffers[$i]->getAttemptsLeft() ?></td>
                  <td><button class="accept">accept</button></td>
                  <td><input type="submit" class="negotiate" name="negotiate" value="negotiate"></td>
                  <td><input type="number" min="<?php echo $bestoffers[$i]->getBuyerNego() + 1 ?>" max="<?php $bestoffers[$i]->getSellerNego() - 1 ?>" class="negotiatePrice" name="negotiatePrice"></td>
                  <input type="number" style="display:none" name="index" value="<?php echo $i ?>">
                  <td><button class = "cancelSale">remove</button></td>
              </form>
            <?php } ?>
          </tbody>
        </table>
        </div>
        <h1>My won best offers</h1>
        <div class="myOrders">
        <table style="text-align: center; border: 1px solid black;margin-top:-100px;">
          <tbody>
            <tr>
              <td><strong>offer number</strong></td>
              <td><strong>final price</strong></td>
              <td><strong>seller id</strong></td>
              <td colspan="3"><strong>information</strong></td>
            </tr>
            <?php for ($i = 0; $i < $compteurB; $i++) { ?>
              <form action="" method="post">
                <tr>
                  <td><?php echo $wins[$i]->getId() ?></td>
                  <td><?php echo $wins[$i]->getPrice() ?>£</td>
                  <td style="color:red; text-transform:uppercase"><?php echo $wins[$i]->getSellerId() ?></td>
                  <td colspan="3"><strong>Contact the seller to get your item.</strong></td>
              </form>
            <?php } ?>
          </tbody>
        </table>
        </div>
        <div id="myModalCancelAdding" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <form action="" method="post">
          <p>Are you sure you want to delete this proposition ? <br> You are free to cancel any proposition at any time. The buyer will not know you canceled this proposition and can not do anything about it. <input style = "display:none" id="nbproposition" name = "index" value ='1' /></p>
          <input type="submit" onclick="delayReload()" class="btn-primary" name="deleteProposition" id="cancel" value="Yes, I want to">
        </form>
      </div>
    </div>
    <div id="myModalAcceptAdding" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <form action="" method="post">
          <p>Are you sure you want to accept this proposition ? <input style="display:block" id="nbpropositionAccept" name="indexAccept" value='1' /></p>
          <input type="submit" class="btn-primary" name="acceptProposition" id="accept" value="Yes, I want to">
        </form>
      </div>
    </div>
    </section>
    <header>
    <div class="navbar">
      <ul id="nav_items">
        <li id="burger">
          <div class="bar" id="bar1"></div>
          <div class="bar" id="bar2"></div>
          <div class="bar" id="bar3"></div>
        </li>
        <li id="logoli"><a href="mainPage.php"><img id="logo" src="../images/logoYourMarket.png" alt=""></a></li>
        <li id="categories" class="dropdown-categories">
          <a href="productsChoice.php">Categories</a>
          <div id="dropdown-child-categories1" class="dropdown-child-categories">
            <div class="hd"></div>
            <div class="button-categ">
              <button class="navbtn" onclick='window.location.replace("phones.php");'>Phones</button>
              <button class="navbtn" onclick='window.location.replace("tablets.php");'>Tablets</button>
              <button class="navbtn" onclick='window.location.replace("laptops.php");'>Laptops</button>
              <button class="navbtn" onclick='window.location.replace("earphones.php");'>Earpods</button>
            </div>
            <div class="pictures">
              <img id="navImage" src="../images/iphone.jpg" alt="">
              <p style="color:black;"><br>
                Buy new, occasion, or reconditionned products.</p>
            </div>
          </div>
        </li>
        <li id="buyings" class="dropdown-categories">
          <a href="#">Buying</a>
          <div id="dropdown-child-categories2" class="dropdown-child-categories">
            <div class="hd"></div>
            <div class="button-categ">
              <button class="navbtn" onclick='window.location.replace("allAuctions.php");'>Auctions</button>
              <button class="navbtn" onclick='window.location.replace("buyNow.php");'>Buy it now</button>
              <button class="navbtn" onclick='window.location.replace("bestOffers.php");'>Best offer</button>
              <button class="navbtn" onclick='window.location.replace("flashSales.php");'>Flash sales</button>
            </div>
            <div class="pictures">
              <img id="navImage2" src="../images/Auction-label.png" alt="">
              <p style="color:black;">Find the buying way that corresponds you the most.</p>
            </div>
          </div>
        </li>
        <li id="sellli">
          <?php if (isset($_SESSION["user"]) && $_SESSION["user"]->isBuyer()) { ?>
            <a href="mySales.php">Sell</a>
          <?php } else { ?>
            <strike style="font-size: 18px;">Sell</strike>
          <?php } ?>
        </li>
        <!-- <li><input id = "researchInput" type="text" placeholder="Make a research here..."></li> -->
        <li id="searchbar">
          <form id="searchBar" action="" method="post">
            <input required id="inputBar" type="search" name = "researchInput" placeholder = "search by model, brand, flash sales, auctions,...">
            <input type="submit" name = "submitresearch" id = "subBar" value = "SEARCH">
          </form>
        </li>
        <li class="dropdown" id="drop1">
          <a href="myChart.php"><img id="myAccountImg" src="../images/logoBasket1.png" alt="">
            <div class="nbarticles"><?php echo count($_SESSION["cartObjects"]) ?></div>
          </a>
          <div id="my-basket" class="dropdown-child">
            <table>
              <thead>
                <tr>
                  <th style="color:white" colspan="2">Your basket</th>
                </tr>
              </thead>
              <tbody>

                <?php if (count($_SESSION["cartObjects"]) > 0) {
                  for ($i = 0; $i < count($_SESSION["cartObjects"]); $i++) { ?>
                    <tr>
                      <td><img class="miniPic" src="<?php echo $_SESSION["cartObjects"][$i]->getPicture() ?>" alt=""></td>
                      <td style="color:white"><?php echo $_SESSION["cartObjects"][$i]->getModel() ?></td>
                    </tr>
                  <?php } ?>
                  <td style="color: white;">Shipping cost: </td>
                  <td style="color: white;">
                    <?php
                    if (round($_SESSION["totalPrice"] + $_SESSION["totalPrice"] * 20 / 100 + $_SESSION["totalPrice"] * 1.5 / 100, 2) < 1500) {
                      echo round(($_SESSION["totalPrice"] * 1 / 100), 2) . "£";
                    } else {
                      echo "offered !";
                    }
                    ?></td>
                  </tr>
                  <tr>
                    <td style="color: white;">Total price : </td>
                    <td style="color: white;"><?php echo round(($_SESSION["totalPrice"] + $_SESSION["totalPrice"] * 20 / 100 + $_SESSION["totalPrice"] * 1.5 / 100), 2); ?> £</td>
                  </tr>
                  <tr>
                    <td colspan="2"><button onclick='window.location.replace("myChart.php")'>view chart</button></td>
                  </tr>

                <?php } else { ?>
                  <tr style="color:white">
                    <td>Your basket </td>
                    <td>is empty. </td>
                  </tr>
                <?php }
                ?>
              </tbody>
            </table>
          </div>
        </li>
        <?php if ($_SESSION["user"] != null) { ?>
          <li style="margin:0px" id="welcome"><span style="margin:0px;color: rgb(238, 207, 34);"><?php echo "welcome  " . $_SESSION["user"]->getFirstname() ?></span></li>
        <?php } ?>
        <li class="dropdown" id="drop2">
          <a href="myProfile.php"><img id="myAccountImg" src="../images/user.png" alt=""></a>
          <div class="dropdown-child">
            <button onclick="viewProfile()">My profile</button>
            <button id="logout" onclick="logOut()">Log out</button>
          </div>
        </li>
      </ul>
    </div>
  </header>
    <div class="mobile-nav">
        <button class="navbtn" onclick='window.location.replace("mainPage.php");'>Home</button>
        <button class="navbtn" onclick='window.location.replace("phones.php");'>Phones</button>
        <button class="navbtn" onclick='window.location.replace("tablets.php");'>Tablets</button>
        <button class="navbtn" onclick='window.location.replace("laptops.php");'>Laptops</button>
        <button class="navbtn" onclick='window.location.replace("earphones.php");'>Earpods</button>
        <button class="navbtn" onclick='window.location.replace("allAuctions.php");'>Auctions</button>
        <button class="navbtn" onclick='window.location.replace("buyNow.php");'>Buy it now</button>
        <button class="navbtn" onclick='window.location.replace("flashSales.php");'>Best offer</button>
    </div>
    <footer>
    <div class="partfooter">
      <ul>
          <li><a href="contactUs.php"><strong>CONTACT US</strong></a></li><br>
        <li>
          <a href="termsAndConditions.php"><strong>Terms and Conditions </strong><br>
            View the terms and conditions policy of yourmaket
          </a>
        </li>
        <li>
          <a href="myProfile.php">Your Personal Informations</a>
        </li>
        <li>
         <strike><a href="">Cookies</a></strike>
        </li>
      </ul>
    </div>
    <div class="partfooter">
      <ul>
        <li>
          <a href="productsChoice.php"><strong>Our products</strong></a>
        </li>
        <li><a href="phones.php">Phones</a></li>
        <li><a href="tablets.php">Tablets</a></li>
        <li><a href="laptops.php">Laptops</a></li>
        <li><a href="earphones.php">Earphones</a></li>
      </ul>
    </div>
    <div class="partfooter" id = "social-icons">
      <ul>
        <li>
          <a href=""><img src="https://kfc-uk-brand.s3.eu-west-1.amazonaws.com/drupal/production/styles/original/s3/2020-01/facebook%402x.png?itok=S7iABeSk" alt=""></a>
        </li>
        <li>
          <a href=""><img src="https://kfc-uk-brand.s3.eu-west-1.amazonaws.com/drupal/production/styles/original/s3/2020-01/twitter%402x.png?itok=l-WVH-OHs" alt=""></a>
        </li>
        <li>
          <a href=""><img src="https://kfc-uk-brand.s3.eu-west-1.amazonaws.com/drupal/production/styles/original/s3/2020-01/instagram%402x.png?itok=-X1GQLDm" alt=""></a>
        </li>
        <li>
          <a href=""><img src="https://kfc-uk-brand.s3.eu-west-1.amazonaws.com/drupal/production/styles/original/s3/2020-01/snap%402x.png?itok=lIXo-Gjs" alt=""></a>
        </li>
        <li>
          <a href=""><img src="https://kfc-uk-brand.s3.eu-west-1.amazonaws.com/drupal/production/styles/original/s3/2020-01/youtube-play%402x.png?itok=uKge9liC" alt=""></a>
        </li>
      </ul>
      <strong style = "color:white;margin-left:40px;">© YOURMARKET. ALL RIGHTS RESERVED Apolline Cherrey & Eliott Morcillo 2021.</strong>
    </div>
  </footer>
</body>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js" integrity="sha512-8Wy4KH0O+AuzjMm1w5QfZ5j5/y8Q/kcUktK9mPUVaUoBvh3QPUZB822W/vy7ULqri3yR8daH3F58+Y8Z08qzeg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TimelineMax.min.js" integrity="sha512-lJDBw/vKlGO8aIZB8/6CY4lV+EMAL3qzViHid6wXjH/uDrqUl+uvfCROHXAEL0T/bgdAQHSuE68vRlcFHUdrUw==" crossorigin="anonymous"></script>
<script src="../javascript/animeHeader.js"></script>
<script src="https://smtpjs.com/smtp.js"></script>
<script>
    <?php include "../javascript/navApp.js" ?>
</script>
<script>
    <?php include "../javascript/mainPage.js" ?>
</script>
<script>
  <?php include "../javascript/myProfile.js" ?>
</script>
<script>
  <?php include "../javascript/myAuctions.js" ?>
</script>
</html>