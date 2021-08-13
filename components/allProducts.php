<?php
// Initialize the session
require_once "config.php";
require "user.php";
require "objects.php";
require "flash.php";
session_start();
if (isset($_SESSION["loggedin-as-admin"]) && !$_SESSION["loggedin-as-admin"]) {
  header("location: mainPage.php");
  exit;
}
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
//we now select every products from every categories.
// these 'compteurs' allow to go trough every categories; at the end, '$compteur' will be equal
//to the sum of all '$comteur'
$compteur = 0;
$compteur2 = 0;
$compteur3 = 0;
$compteur4 = 0;
$compteur5 = 0;
$compteur6 = 0;
$compteur7 = 0;
$sql = mysqli_query($succes, $sql = "SELECT * FROM `phones` WHERE 1");
$row = mysqli_num_rows($sql);
while ($row > $compteur) {
  $result = mysqli_fetch_assoc($sql);
  $creations[$compteur] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
  $compteur = $compteur + 1;
}
$sql = mysqli_query($succes, $sql = "SELECT * FROM `tablets` WHERE 1");
$row = mysqli_num_rows($sql);
while ($row > $compteur2) {
  $result = mysqli_fetch_assoc($sql);
  $creations[$compteur + $compteur2] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
  $compteur2 = $compteur2 + 1;
}
$compteur = $compteur + $compteur2;


$sql = mysqli_query($succes, $sql = "SELECT * FROM `laptops` WHERE 1");
$row = mysqli_num_rows($sql);
while ($row > $compteur3) {
  $result = mysqli_fetch_assoc($sql);
  $creations[$compteur + $compteur3] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
  $compteur3 = $compteur3 + 1;
}
$compteur = $compteur + $compteur3;
$sql = mysqli_query($succes, $sql = "SELECT * FROM `earphones` WHERE 1");
$row = mysqli_num_rows($sql);
while ($row > $compteur4) {
  $result = mysqli_fetch_assoc($sql);
  $creations[$compteur + $compteur4] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
  $compteur4 = $compteur4 + 1;
}
$compteur = $compteur + $compteur4;

//getting all auctions
$sql = mysqli_query($succes, $sql = "SELECT * FROM `auctions` WHERE 1");
$row = mysqli_num_rows($sql);
while ($row > $compteur5) {
  $result = mysqli_fetch_assoc($sql);
  $creations[$compteur + $compteur5] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
  $compteur5 = $compteur5 + 1;
}
$compteur = $compteur + $compteur5;
//getting all best offers
$sql = mysqli_query($succes, $sql = "SELECT * FROM `flashsales` WHERE 1");
$row = mysqli_num_rows($sql);
while ($row > $compteur6) {
  $result = mysqli_fetch_assoc($sql);
  $creations[$compteur + $compteur6] = new flash($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"], $result["discount"], $result["endingTime"]);
  $compteur6 = $compteur6 + 1;
}
$compteur = $compteur + $compteur6;
//getting all best offers
$sql = mysqli_query($succes, $sql = "SELECT * FROM `bestoffers` WHERE `status` != 'complete' ");
$row = mysqli_num_rows($sql);
while ($row > $compteur7) {
  $result = mysqli_fetch_assoc($sql);
  $creations[$compteur + $compteur7] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
  $compteur7 = $compteur7 + 1;
}
$compteur = $compteur + $compteur7;
mysqli_close($succes);
if (isset($_POST['deleteItem']) && $_POST['deleteItem']) {
  $index = $_POST['index'] - 1;
  $category = $creations[$index]->getProductCategory();
  $id = $creations[$index]->getId();
  // sql to delete a record
  $sql = "DELETE FROM `$category` WHERE `id` LIKE '$id'";

  if ($link->query($sql) === TRUE) {
    echo "product " . $creations[$index]->getModel() . "id= " . $creations[$index]->getId() . " deleted successfully";
    header("refresh: 0");
  } else {
    echo "Error deleting record: " . $link->error;
  }

  $link->close();
}
//if admin wants to add a new item
if (isset($_POST["addItemSubmit"]) && $_POST["addItemSubmit"]) {
  //we get all infos from the inputs
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
  //STEP1 we insert the item into the selected category
  // if classic buy now item
  if ($category == "buynow") {
    $sql = "INSERT INTO `$category2`(`category`, `id`, `brand`, `model`, `capacity`, `size`, `price`, `picture`, `description`) VALUES ('$category2',NULL,'$brand' ,'$model','$capacity','$size','$price','$picture','$description')";
    if ($link->query($sql) === TRUE) {
      echo "Item added successfully.";
      header("refresh: 0");
    } else {
      echo "Error adding record: " . $link->error;
    }
    //STEP2 then we load the id of the item 
    $sql = "SELECT `id` FROM `$category2` WHERE `description` LIKE '$description' AND `model`  LIKE '$model'";
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
      echo "ERROR: Could not be able to execute $sql. " . mysqli_error($link);
    }
    // }
    //STEP3 finally we add pictures to images table with id of the item
    $sql = "INSERT INTO `images` (`id`, `objectID`, `category`, `pictureLink`) VALUES (NULL, $itemID,'$category2','$pic1')";
    $sql2  = "INSERT INTO `images` (`id`, `objectID`, `category`, `pictureLink`) VALUES (NULL, $itemID,'$category2','$pic2')";
    $sql3  = "INSERT INTO `images` (`id`, `objectID`, `category`, `pictureLink`) VALUES (NULL, $itemID,'$category2','$pic3')";
    if ($link->query($sql) === TRUE && $link->query($sql2) === TRUE && $link->query($sql3) === TRUE) {
      echo "images added successfully.";
      //header("refresh: 0");
    } else {
      echo $sql;
      echo $sql2;
      echo $sql3;
      echo "Error adding record: " . $link->error;
    }
  } else if ($category == "flashsales") {
    // almost the same thing for flashsales except we allso add ending date and discount
    $discount = $_POST["discount"];
    $endingTime = $_POST["endingTime"];
    $sql = "INSERT INTO `flashsales`(`category`, `secCategory`, `id`, `brand`, `model`, `capacity`, `size`, `price`, `picture`, `description`, `discount`, `endingTime`) VALUES ('flashsales','$category2',NULL,'$brand','$model','$capacity','$size','$price','$picture','$description',$discount,'$endingTime')";
    if ($link->query($sql) === TRUE) {
      echo "Item added successfully.";
      header("refresh: 0");
    } else {
      echo $sql;
      echo "Error adding record: " . $link->error;
    }
    //STEP2
    $sql = "SELECT `id` FROM `flashsales` WHERE `description` LIKE '$description' AND `discount` LIKE $discount";
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
      echo "ERROR: Could not be able to execute $sql. " . mysqli_error($link);
    }
    // }
    //STEP3
    $sql = "INSERT INTO `images` (`id`, `objectID`, `category`, `pictureLink`) VALUES (NULL, $itemID,'flashsales','$pic1')";
    $sql2  = "INSERT INTO `images` (`id`, `objectID`, `category`, `pictureLink`) VALUES (NULL, $itemID,'flashsales','$pic2')";
    $sql3  = "INSERT INTO `images` (`id`, `objectID`, `category`, `pictureLink`) VALUES (NULL, $itemID,'flashsales','$pic3')";
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
  $link->close();
}
?>
<html>

<head>
  <link rel="icon" href="../images/icon.png">
  <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
  <style>
    <?php include "../assets/allProducts.css" ?><?php include "../assets/myAdresses.css" ?><?php include "../assets/myPayments.css" ?><?php include "../assets/mySales.css" ?><?php include "../assets/mainPage.css" ?>
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
  <script>
    WebFont.load({
      google: {
        families: [
          "Lato:100,300,400,700,900",
          "Karla:regular",
          "Cookie:regular",
        ],
      },
    });
  </script>
  <link rel="icon" src="../images/logo.png" />
  <title>Yourmarket</title>
  <script>
    function logOut() {
      $.post("logOut.php", function() {});
      window.location.reload();
    }

    function viewProfile() {
      window.location.replace("myProfile.php");
    }
  </script>
</head>

<body>
  <section>
    <div class="infos" style="display:none; transform:translateY(900%)">
      <input type="text" id="status" value='<?php echo $_SESSION["user"]->isBuyer() ?>'>
      <input type="text" id="indexofcolor" value='<?php echo $indexOfColor ?>'>
    </div>
    <br><br>
    <h3 id="welcome">ADMIN SESSION - Products</h3>
    <br>
    <div class="showObjects">
      <div class="object" id="addFirst">
        <h3>sell a new item</h3>
        <div style = "transform:translateX(25%); background-color:whitesmoke" class="addCard" id="addcard">
          <img style="width:80px;height:80px;" class="addcardimg" src="http://cdn.onlinewebfonts.com/svg/img_414457.png" alt="">
        </div>
      </div>
      <?php
      for ($i = 0; $i < $compteur; $i++) {
        if ($creations[$i]->getProductCategory() == "flashsales") { ?>
          <div class="object">
            <h1 class="textDiscount">Best offer !</h1>
            <div class="iconDiscount">
              <h1>-<?php echo $creations[$i]->getDiscount() ?>%</h1>
            </div>
            <table>
              <thead>
                <tr>
                  <th><?php echo $creations[$i]->getModel() ?></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><a href="selectedObject.php?Id=<?= $creations[$i]->getId(); ?>&category=flashsales"><img class="image" src='<?php echo $creations[$i]->getPicture() ?>' alt=""></a></td>
                </tr>
                <tr>
                  </td>
                </tr>
                <tr>
                  <td><strike><?php echo $creations[$i]->getPrice() ?>£</strike> <strong style="color:red; margin-left:25px; border: solid 1px red; padding:3px; border-radius:5px"><?php echo ($creations[$i]->getPrice() - $creations[$i]->getPrice() * ($creations[$i]->getDiscount() / 100)) ?>£</strong></td>
                </tr>
                <tr>
                  <td style='color:red'><strong>Ends in <?php echo getDiffDates($creations[$i]->getEndingTime()) ?> days</strong></td>
                </tr>
                <tr>
                  <td><button class="deleteItem">delete item</button></td>
                </tr>
              </tbody>
            </table>
          </div>
        <?php } else { ?>
          <div class="object">
            <?php if ($creations[$i]->getProductCategory() == "auctions") { ?>
              <img class="iconpng" src="../images/Auction-label.png" alt="">
            <?php } else {  ?>
              <img style="transform:translateX(150%)" class="iconpng" src="../images/buy_now.png" alt="">
            <?php } ?>
            <table>
              <thead>
                <tr>
                  <th><?php echo $creations[$i]->getModel() ?></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><a href="selectedObject.php?Id=<?= $creations[$i]->getId(); ?>&category=<?= $creations[$i]->getProductCategory(); ?>"><img class="image" src='<?php echo $creations[$i]->getPicture() ?>' alt=""></a></td>
                </tr>
                </td>
                </tr>
                <tr>
                  <td>Starting at <?php echo $creations[$i]->getPrice() ?>£</td>
                </tr>
                <tr>
                  <td><button class="deleteItem">delete item</button></td>
                </tr>
              </tbody>
            </table>
          </div>
      <?php }
      }
      ?>
    </div>
    <div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <form action="" method="post">
          <p>Are you sure you want to delete this item ? <input style="display:none" id="nbcard" name="index" value='1' /></p>
          <input type="submit" onclick="delayReload()" class="btn-primary" name="deleteItem" id="delete" value="Yes, I want to">
        </form>
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
            <select required name="selltypes" id="type-select" onchange="discountOrBuyNow()">
              <option value="">--Please choose an option--</option>
              <option value="buynow">buy now</option>
              <option value="flashsales">flash sale</option>
            </select>
            <label id="flash1" style='display:none' for="endingTime">Ending time :</label>
            <input id="flash2" style='display:none' type="date" min="2021-01-01" name="endingTime">
            <label id="flash3" style='display:none' for="discount">Discount :</label>
            <input id="flash4" style='display:none' type="number" name="discount" placeholder="ex: 40%">
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
  <a id="btnToTop" href="#top"><img src="https://icon-library.com/images/back-to-top-icon-png/back-to-top-icon-png-19.jpg" alt=""></a>
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
  <?php include "../javascript/allProducts.js" ?>
</script>

</html>