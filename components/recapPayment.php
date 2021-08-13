<?php
require_once "config.php";
require "user.php";
require "objects.php";
require "adress.php";
require "card.php";
require "flash.php";
require "auction.php";
session_start();
$message = "";
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}
if (isset($_POST["submitresearch"]) && $_POST["submitresearch"]) {
  $search = $_POST['researchInput'];
  header("location: results.php?research=$search");
}
//we get all credits cards linked to user
$sql = mysqli_query($succes, $sql = "SELECT * FROM `cards` WHERE `userID` like " . $_SESSION['user']->getId());
$row = mysqli_num_rows($sql);
$compteur = 0;
while ($row > $compteur) {
  $result = mysqli_fetch_assoc($sql);
  $cards[$compteur] = new card($result["lastname"], $result["digit"], $result["expdate"], $result["crypto"]);
  $compteur = $compteur + 1;
}
function returnHiddenDigits(string $digits)
{
  $digitsToArray = str_split($digits, 1);
  for ($i = 0; $i < count($digitsToArray) - 4; $i++) {
    if ($i % 4 == 0) {
      $digitsToArray[$i] = " X";
    } else {
      $digitsToArray[$i] = "X";
    }
  }
  $digitsToArray[count($digitsToArray) - 4] = " " . $digitsToArray[count($digitsToArray) - 4];
  return implode("", $digitsToArray);
}
if ((isset($_POST["nextStep"])) && $_POST["nextStep"]) {
  if (isset($_POST["selectCard"])) {
    for ($i = 0; $i < $compteur; $i++) {
      if ($_POST["selectCard"] == "select" . ($i + 1)) {
        $message = "card nb " . ($i + 1);
        $_SESSION["selectedCard"] = $cards[$i];
        header("location: placeOrder.php");
      }
    }
  } else {
    $message = "You must select a payment method.";
  }
}
$lastname_err = $digit_err = $expdate_err = $crypto_err = "";
$lastname = $digit = $expdate = $crypto = "";
mysqli_close($succes);
//check for adress
if (isset($_POST['addCardSubmit']) && $_POST['addCardSubmit']) {
  if (empty(trim($_POST["lastname"]))) {
    $lastname_err = "Please enter a lastname.";
  } else {
    $lastname = trim($_POST["lastname"]);
  }
  //check for country
  if (empty(trim($_POST["digit"]))) {
    $digit_err = "Please enter a digit.";
  } else {
    $digit = trim($_POST["digit"]);
  }
  //check for city
  if (empty(trim($_POST["expdate"]))) {
    $expdate_err = "Please enter an expire date.";
  } else {
    $expdate = trim($_POST["expdate"]);
  }
  //check for postal
  if (empty(trim($_POST["crypto"]))) {
    $crypto_err = "Please enter a cryptogram.";
  } else {
    $crypto = trim($_POST["crypto"]);
  }
  if (empty($lastname_err) && empty($digit_err) && empty($expdate_err) && empty($crypto_err)) {
    $sql = "INSERT INTO `cards`(`id`, `userID`, `lastname`, `digit`, `expdate`, `crypto`) VALUES (NULL,?,?,?,?,?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
      $id = $_SESSION["user"]->getId();
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "issss", $id, $lastname, $digit, $expdate, $crypto);
      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Redirect to login page
        header("location: recapPayment.php");
      } else {
        echo "Something went wrong.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }
  mysqli_close($link);
}
?> 

<html>
<head>
  <link rel="icon" href="../images/icon.png">
  <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
  <style>
    <?php include "../assets/myProfile.css" ?><?php include "../assets/myChart.css" ?><?php include "../assets/myAdresses.css" ?><?php include "../assets/myPayments.css" ?><?php include "../assets/mainPage.css" ?>.card:hover {
      transition: 0.3s ease-in;
      transform: scale(1.0);
      cursor: unset;
    }
  </style>
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
    <div class="st">
      <h1><span>Choose your delivery adress</span><img class="valid" src="https://img.pngio.com/validate-interface-searching-icon-png-and-vector-for-free-validate-png-512_511.png" alt=""></h1>
      <h1><span style="color : black">> Choose your payment method</span><img class="valid" src="https://cdn1.iconfinder.com/data/icons/essentials-line-vol-1/64/Check-Accept-Correct-512.png" alt=""></h1>
      <h1><span>> Place order</span><img class="valid" src="https://cdn1.iconfinder.com/data/icons/essentials-line-vol-1/64/Check-Accept-Correct-512.png" alt=""></h1>
    </div>

    <h3 style="color:red"><?php echo $message; ?></h3>
    <div class="showOptionsCards">
      <?php if ($compteur > 0) { ?>
        <div class="Adress">
          <div style="width:90%;margin:auto; display:flex; flex-direction :row; justify-content:space-around" class="images">
            <img style="margin:5px;width:55px; height:55px" src="../images/cardboard.png" alt="">
            <img style="margin:5px;width:55px; height:55px" src="../images/rightArrow.png" alt="">
            <img style="margin:5px;width:55px; height:55px" src="../images/house.png" alt="">
          </div>
          <p>adress : <?php echo $_SESSION["deliveryAdress"]->getAdress() ?></p>
          <p>postal :<?php echo $_SESSION["deliveryAdress"]->getPostal() ?></p>
          <p> city :<?php echo $_SESSION["deliveryAdress"]->getCity() ?></p>
          <p>country :<?php echo $_SESSION["deliveryAdress"]->getCountry() ?></p>
        </div>
        <form action="" method="post">
          <div class="cardsForm">
            <?php for ($i = 0; $i < $compteur; $i++) { ?>
              <div class="card" style="margin-top:30px;">
                <div class="back">
                  <span id="crypto"><?php echo $cards[$i]->getCrypto() ?></span>
                  <div class="bar" id="bar"></div>
                </div>
                <div class="front">
                  <img class="mastercard" id="cb" src="../images/logo-cb.jpg" alt="">
                  <span id="digits"><?php echo returnHiddenDigits($cards[$i]->getDigit()) ?></span>
                  <span id="expdate"><?php echo $cards[$i]->getExpDate() ?></span>
                  <span id="lastname"><?php echo $cards[$i]->getLastname() ?></span>
                  <img class="mastercard" id="master" src="../images/mastercard.svg" alt="">
                  <input style="cursor:pointer;margin-bottom:20px;" type="radio" name="selectCard" value='<?php echo "select" . ($i + 1) ?>'>
                </div>
              </div>
            <?php } ?>
          </div>
          <input type="submit" value="finish" id="next2" name="nextStep" class="nextStep">
        </form>
      <?php } else { ?>
        <div class="addCard" id="addcard">
          <img style="width:120px;height:120px; transform:translateY(-5%)" class="addcardimg" src="https://cdn2.iconfinder.com/data/icons/payment-filled/1024/card_add-512.png" alt="">
          <h3>add a new card</h3>
        </div>
      <?php } ?>
      <div class="addForm" id="formAdd">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <h3>New payment method</h3>
          <label for="adress">Type of payment :</label>
          <select name="types" id="type-select">
            <option value="">--Please choose an option--</option>
            <option value="mastercard">Mastercard</option>
            <option disabled value="paypal">Paypal (not available yet)</option>
          </select>
          <label for="digits">front digits :</label>
          <input required type="text" placeholder="ex: 5137 8082 0364 4365" name="digit" maxlength="16">
          <span style="color:red" ; class="help-block"><?php echo $digit_err; ?></span>
          <label for="expdate">expiration date :</label>
          <input required type="month" min="2021-01" value="2021-01" name="expdate">
          <span style="color:red" class="help-block"><?php echo $expdate_err; ?></span>
          <label for="cryptogram">cryptogram :</label>
          <input required type="text" placeholder="ex: 232" name="crypto" maxlength="3">
          <span style="color:red" ; class="help-block"><?php echo $crypto_err; ?></span>
          <label for="name">lastname on the card :</label>
          <input required type="text" placeholder="ex: Demarco" name="lastname">
          <span style="color:red" ; class="help-block"><?php echo $lastname_err; ?></span>
          <input required type="submit" class="btn-primary" name="addCardSubmit" id="add" value="add new card">
          <button id = "cancel">cancel</button>
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
  <?php include "../javascript/recapPayments.js" ?>
</script>

</html>