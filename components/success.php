<?php
require_once "config.php";
require "user.php";
require "objects.php";
require "adress.php";
require "card.php";
require "auction.php";
require "flash.php";
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
?>
<html>

<head>
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
    <style>
        <?php include "../assets/success.css" ?><?php include "../assets/mainPage.css" ?>
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
            <h1><span style="color : black">> Choose your payment method</span><img class="valid" src="https://img.pngio.com/validate-interface-searching-icon-png-and-vector-for-free-validate-png-512_511.png" alt=""></h1>
            <h1><span>> Place order</span><img class="valid" src="https://img.pngio.com/validate-interface-searching-icon-png-and-vector-for-free-validate-png-512_511.png" alt=""></h1>
        </div>
        <div class="check_mark">
  <div class="sa-icon sa-success animate">
    <span class="sa-line sa-tip animateSuccessTip"></span>
    <span class="sa-line sa-long animateSuccessLong"></span>
    <div class="sa-placeholder"></div>
    <div class="sa-fix"></div>
  </div>
</div>
<h1>Success !</h1>
<h2 style = "text-align:center"><?php echo $_SESSION["user"]->getFirstname()?>, your order has been completed with success. <br>
An email has been sent to you (<?php echo $_SESSION["user"]->getEmail()?>) to sum up your order.</h2>
<button id = "backtohomepage" onclick ='window.location.replace("mainPage.php");' >< Go back to home page</button>
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
<script src="https://smtpjs.com/smtp.js"></script>
<script>
    <?php include "../javascript/navApp.js" ?>
</script>
<script>
    <?php include "../javascript/mainPage.js" ?>
</script>

</html>