<?php
require_once "config.php";
require "user.php";
require "objects.php";
require "card.php";
require "bestoffer.php";
require "offerOnBestOffer.php";
session_start();
$indexOfColor = 0;
$_SESSION["adress"] = null;
if (isset($_POST["submitresearch"]) && $_POST["submitresearch"]) {
  $search = $_POST['researchInput'];
  header("location: results.php?research=$search");
}
//loading the background image if the user is a buyer
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
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}
//loading all sales on which user is the seller
$compteur = 0;
$id = $_SESSION["user"]->getId();
$sql = mysqli_query($succes, $sql = "SELECT * FROM `offersonbestoffers` WHERE `sellerID` LIKE $id ORDER BY `buyernego` DESC");
$row = mysqli_num_rows($sql);
$compteur = 0;
$orders = array();
$buyers = array();
$items = array();
//we get all these offers
while ($row > $compteur) {
  $result = mysqli_fetch_assoc($sql);
  $orders[$compteur] = new offerOnBestOffer($result["sellerID"], $result["buyerID"], $result["offerID"], $result["startingprice"], $result["sellernego"], $result["buyernego"], $result["attemptsleft"]);
  //getting the buyer's first and lastname
  $idBuyer = $result["buyerID"];
  $sql2 = mysqli_query($succes, $sql2 = "SELECT `firstname`, `lastname` FROM `users` WHERE `id` like '$idBuyer'");
  $result2 = mysqli_fetch_assoc($sql2);
  $buyers[$compteur] = $result2["firstname"] . " " . $result2["lastname"];
  //getting the item's model and brand
  $idItem = $result["offerID"];
  $sql3 = mysqli_query($succes, $sql3 = "SELECT `brand`, `model` FROM `bestoffers` WHERE `id` like '$idItem'");
  $result3 = mysqli_fetch_assoc($sql3);
  $items[$compteur] = $result3["brand"] . " " . $result3["model"];
  $compteur = $compteur + 1;
}
//if we negotiate, we change the values of the current proposition and attempts
if (isset($_POST["negotiate"]) && $_POST["negotiate"]) {
  $index = $_POST["index"];
  $buyerId = $orders[$index]->getBuyerId();
  $sellerId = $_SESSION["user"]->getId();
  $newPrice = $_POST["negotiatePrice"];
  $sql = "UPDATE `offersonbestoffers` SET `sellernego`= $newPrice WHERE `sellerID` LIKE $sellerId AND `buyerID` LIKE $buyerId";

  if ($link->query($sql) === TRUE) {
    echo "best offer modified successfully";
    header("refresh: 0");
  } else {
    echo "Error deleting record: " . $link->error;
  }
}
//if users decides to add an item to sell
if (isset($_POST["addItemSubmit"]) && $_POST["addItemSubmit"]) {
  //we get all infos from inputs
  $category = $_POST["selltypes"];
  $category2 = $_POST["categ"];
  $brand = $_POST["brand"];
  $model = $_POST["model"];
  $capacity = $_POST["capacity"];
  $size = $_POST["size"];
  $price = $_POST["price"];
  $picture = $_POST["mainpic"];
  $description = $_POST["description"];
  $pic1 = $_POST["pic1"];
  $pic2 = $_POST["pic2"];
  $pic3 = $_POST["pic3"];
  $sellerID = $_SESSION["user"]->getId();
  //STEP1 we insert the new object into best offers
  $sql = "INSERT INTO `bestoffers`(`category`, `secCategory`, `id`, `brand`, `model`, `capacity`, `size`, `price`, `picture`, `description`, `sellerID`) VALUES ('$category','$category2',NULL,'$brand','$model','$capacity','$size',$price,'$picture','$description',$sellerID)";
  if ($link->query($sql) === TRUE) {
    echo "Item added successfully.";
  } else {
    echo "Error adding record: " . $link->error;
  }
  //STEP2 we get the id of the object we just inserted (auto increment by database so cannot access it directly)
  $sql = "SELECT `id` FROM `bestoffers` WHERE `sellerID` LIKE $sellerID AND `model`  LIKE '$model'";
  if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result)) {
        $itemID = $row["id"];
        break;
      }
      mysqli_free_result($result);
    } else {
      echo "No records matching your query were found.";
    }
  } else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
  }
  // }
  //STEP3 we insert the 3 images to images table with the id of the object
  $sql = "INSERT INTO `images` (`id`, `objectID`, `category`, `pictureLink`) VALUES (NULL, $itemID,'bestoffers','$pic1')";
  $sql2  = "INSERT INTO `images` (`id`, `objectID`, `category`, `pictureLink`) VALUES (NULL, $itemID,'bestoffers','$pic2')";
  $sql3  = "INSERT INTO `images` (`id`, `objectID`, `category`, `pictureLink`) VALUES (NULL, $itemID,'bestoffers','$pic3')";
  if ($link->query($sql) === TRUE && $link->query($sql2) === TRUE && $link->query($sql3) === TRUE) {
    echo "images added successfully.";
    //header("refresh: 0");
  } else {
    echo $sql;
    echo $sql2;
    echo $sql3;
    echo "Error adding record: " . $link->error;
  }
}
//If user deletes a proposition
if (isset($_POST["deleteProposition"]) && $_POST["deleteProposition"]) {
  $index = $_POST['index'] - 1;
  $sellerID = $orders[$index]->getSellerId();
  $buyerID = $orders[$index]->getBuyerId();
  $offerID = $orders[$index]->getOfferId();
  // sql to delete a record
  $sql = "DELETE FROM `offersonbestoffers` WHERE `sellerID` LIKE '$sellerID' && `buyerID` LIKE '$buyerID' && `offerID` LIKE '$offerID'";

  if ($link->query($sql) === TRUE) {
    echo "Proposition deleted successfully";
    header("refresh: 0");
  } else {
    echo "Error deleting record: " . $link->error;
  }
}
//if users accepts the propostion
if (isset($_POST["acceptProposition"]) && $_POST["acceptProposition"]) {
  $index = $_POST['indexAccept'] - 1;
  $sellerID = $orders[$index]->getSellerId();
  $buyerID = $orders[$index]->getBuyerId();
  $offerID = $orders[$index]->getOfferId();
  $finalPrice = $orders[$index]->getBuyerNego();
  // we delete all the offers on this object because only one person can win
  $sql = "DELETE FROM `offersonbestoffers` WHERE `offerID` LIKE $offerID";
  //we change the status of best offer to 'complete', and its price to the buyer's proposition* 
  //$we take buyer's proposition because here the seller accepts, so he accepts the buyer's proposition.
  $sql2 = "UPDATE `bestoffers` SET `status`= 'complete',`price`= $finalPrice,`winnerID`= '$buyerID' WHERE `id` LIKE $offerID";
  if ($link->query($sql) === TRUE && $link->query($sql2) === TRUE) {
    echo "Proposition deleted successfully";
    echo "Status modified successfully";
    header("refresh: 0");
  } else {
    echo "Error deleting record: " . $link->error;
  }
}
//finally we load all offers that are complete
$old = array();
$winners = array();
$id = $_SESSION['user']->getId();
$sql2 = mysqli_query($succes, $sql = "SELECT * FROM `bestoffers` WHERE `sellerID` like $id AND `status` LIKE 'complete'");
$row = mysqli_num_rows($sql2);
$cpt = 0;
while ($row > $cpt) {
  $result = mysqli_fetch_assoc($sql2);
  $old[$cpt] = new bestoffer($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"], $result["sellerID"]);
  $winners[$cpt] = $result["winnerID"];
  $cpt = $cpt + 1;
}

$link->close();
mysqli_close($succes);
?>
<html>

<head>
  <link rel="icon" href="../images/icon.png">
  <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
  <style>
    <?php include "../assets/myProfile.css" ?><?php include "../assets/mySales.css" ?><?php include "../assets/myPayments.css" ?><?php include "../assets/myAdresses.css" ?><?php include "../assets/mainPage.css" ?>
    /* header{
      display:none;
    } */
  </style>
  <title>Yourmarket</title>
</head>

<body>
  <section>
    <div class="infos" style="display:none; transform:translateY(900%)">
      <input type="text" id="status" value='<?php echo $_SESSION["user"]->isBuyer() ?>'>
      <input type="text" id="indexofcolor" value='<?php echo $indexOfColor ?>'>
    </div>
    <div class="salesManager">
      <h3>sell a new item</h3>
      <div class="addCard" id="addcard">
        <img style="width:80px;height:80px;" class="addcardimg" src="http://cdn.onlinewebfonts.com/svg/img_414457.png" alt="">
      </div>
      <div class="mySalesManager" id="mySalesManager">
        <h3>View and manage your sales</h3>
        <table style="text-align: center; border: 1px solid black;background-color:white;">
          <tbody>
            <tr>
              <td><strong>negotiators rank</strong></td>
              <td><strong>offer number</strong></td>
              <td><strong>Item</strong></td>
              <td><strong>Original price</strong></td>
              <td><strong>negotiator</strong></td>
              <td><strong>his proposition</strong></td>
              <td><strong>your proposition</strong></td>
              <td><strong>attempts left</strong></td>
              <td colspan="3"><strong>your choice</strong></td>
              <td><strong>remove your offer</strong></td>

            </tr>
            <?php for ($i = 0; $i < $compteur; $i++) { ?>
              <form action="" method="post">
                <tr>
                  <td><?php echo $i + 1 ?></td>
                  <td><?php echo $orders[$i]->getOfferId() ?></td>
                  <td><?php echo $items[$i] ?></td>
                  <td><?php echo $orders[$i]->getStartingPrice() ?></td>
                  <td style="color:red; text-transform:uppercase"><?php echo $buyers[$i] ?></td>
                  <td style="color:red"><?php echo $orders[$i]->getBuyerNego() ?> £</td>
                  <td style="color:red"><?php echo $orders[$i]->getSellerNego() ?> £</td>
                  <td><?php echo $orders[$i]->getAttemptsLeft() ?></td>
                  <td><button class="accept">accept</button></td>
                  <td><input type="submit" class="negotiate" name="negotiate" value="negotiate"></td>
                  <td><input required type="number" min="<?php echo $orders[$i]->getBuyerNego() + 1 ?>" max="<?php echo $orders[$i]->getSellerNego() ?> - 1 ?>" class="negotiatePrice" name="negotiatePrice"></td>
                  <input type="number" style="display:none" name="index" value="<?php echo $i ?>">
              </form>
              <td><button class="cancelSale">remove</button></td>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="mySalesManager" id="mySalesManager">
      <h3>My old offers</h3>
        <div class="myOrders">
        <table style="width:100%;text-align: center; border: 1px solid black; background-color:white">
          <tbody>
            <tr>
              <td><strong>offer number</strong></td>
              <td><strong>final price</strong></td>
              <td><strong>winner id</strong></td>
              <td colspan="3"><strong>information</strong></td>
            </tr>
            <?php for ($i = 0; $i < $cpt; $i++) { ?>
              <form action="" method="post">
                <tr>
                  <td><?php echo $old[$i]->getId() ?></td>
                  <td><?php echo $old[$i]->getPrice() ?>£</td>
                  <td style="color:red; text-transform:uppercase"><?php echo $winners[$i]?></td>
                  <td colspan="3"><strong>Contact the seller to sell your item.</strong></td>
              </form>
            <?php } ?>
          </tbody>
        </table>
        </div>
      </div>
    </div>
    <div id="myModalAddObject" class="modal">
      <!-- Modal content -->
      <div class="modal-content" id="modalAddItem">
        <span class="close">&times;</span>
        <div style="display:flex" class="addForm" id="formAdd">
          <form action="" method="post">
            <h3>New object to sell</h3>
            <label>Please choose :</label>
            <select required name="selltypes" id="type-select">
              <option value="">--Please choose an option--</option>
              <option value="bestoffers">best offer</option>
              <option disabled value="Occasions">auction (not available)</option>
            </select>
            <label>Category :</label>
            <select required name="categ" id="type-select2">
              <option value="">--Please choose an option--</option>
              <option value="Phones">Phone</option>
              <option value="laptops">Laptop</option>
              <option value="tablets">Tablet</option>
              <option value="earphones">Earphones</option>
            </select>
            <label for="brand">brand :</label>
            <input required type="text" placeholder="ex: Apple" name="brand">
            <span style="color:red" ; class="help-block"><?php //echo $digit_err; 
                                                          ?></span>
            <label for="model">model :</label>
            <input required type="text" name="model" placeholder="ex: Iphone 10">
            <span style="color:red" class="help-block"><?php //echo $expdate_err; 
                                                        ?></span>
            <label for="size">size :</label>
            <input required type="text" placeholder="ex : 6.2in" name="size">
            <span style="color:red" ; class="help-block"><?php //echo $crypto_err; 
                                                          ?></span>
            <label for="capacity">capacity :</label>
            <input required type="text" placeholder="ex : 256Go" name="capacity">
            <span style="color:red" ; class="help-block"><?php //echo $lastname_err; 
                                                          ?></span>
            <label for="price">starting price :</label>
            <input required type="number" placeholder="ex : 499£" name="price">
            <span style="color:red" ; class="help-block"><?php //echo $lastname_err; 
                                                          ?></span>
            <label for="description">description :</label>
            <textarea required name="description" id="" cols="48" rows="10"></textarea>
            <br> <br>
            <label for="file"><strong>Link a main picture</strong></label>
            <input required type="text" name="mainpic">
            <label><strong>Links other pictures (3max)</strong></label>
            <input required type="text" name="pic1">
            <input required type="text" name="pic2">
            <input required type="text" name="pic3">
            <br>
            <br>
            <input type="submit" class="btn-primary" name="addItemSubmit" id="add" value="add new item">
            <button id="cancelAdding">cancel</button>
          </form>
        </div>
      </div>
    </div>
    <div id="myModalCancelAdding" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <form action="" method="post">
          <p>Are you sure you want to delete this proposition ? <br> You are free to cancel any proposition at any time. The negotiator will not know you canceled his proposition and can not do anything about it. <input style="display:none" id="nbproposition" name="index" value='1' /></p>
          <input type="submit" class="btn-primary" name="deleteProposition" id="cancel" value="Yes, I want to">
        </form>
      </div>
    </div>
    <div id="myModalAcceptAdding" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <form action="" method="post">
          <p>Are you sure you want to accept this proposition ? <input style="display:none" id="nbpropositionAccept" name="indexAccept" value='1' /></p>
          <input type="submit" class="btn-primary" name="acceptProposition" id="accept" value="Yes, I want to">
        </form>
      </div>
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
            <input required id="inputBar" type="search" name="researchInput" placeholder="search by model, brand, flash sales, auctions,...">
            <input type="submit" name="submitresearch" id="subBar" value="SEARCH">
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
          <li id="welcome"><span style="color: rgb(238, 207, 34);"><?php echo "welcome  " . $_SESSION["user"]->getFirstname() ?></span></li>
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
  <footer style="transform:translateY(100%)">
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
    <div class="partfooter" id="social-icons">
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
      <strong style="color:white;margin-left:40px;">© YOURMARKET. ALL RIGHTS RESERVED Apolline Cherrey & Eliott Morcillo 2021.</strong>
    </div>
  </footer>
</body>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js" integrity="sha512-8Wy4KH0O+AuzjMm1w5QfZ5j5/y8Q/kcUktK9mPUVaUoBvh3QPUZB822W/vy7ULqri3yR8daH3F58+Y8Z08qzeg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TimelineMax.min.js" integrity="sha512-lJDBw/vKlGO8aIZB8/6CY4lV+EMAL3qzViHid6wXjH/uDrqUl+uvfCROHXAEL0T/bgdAQHSuE68vRlcFHUdrUw==" crossorigin="anonymous"></script>
<script src="../javascript/animeHeader.js"></script>
<script src="https://smtpjs.com/smtp.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
  <?php include "../javascript/mainPage.js" ?>
</script>
<script>
  <?php include "../javascript/myProfile.js" ?>
</script>
<script>
  <?php include "../javascript/navApp.js" ?>
  <?php include "../javascript/mySales.js" ?>
</script>

</html>