<?php
require_once "config.php";
require "user.php";
require "objects.php";
require "auction.php";
require "flash.php";
session_start();
if (isset($_POST["submitresearch"]) && $_POST["submitresearch"]) {
  $search = $_POST['researchInput'];
  header("location: results.php?research=$search");
}
//if user orders, we redirect to the recap pages
if (isset($_POST["ordernow"]) && $_POST["ordernow"]) {
  header("location: recapAdress.php");
}
//if user wants to delete an item in his cart
if (isset($_POST['deleteItem']) && $_POST['deleteItem']) {
  //we get the index of the object we want to delete
  $index = $_POST["index"];
  $_SESSION["totalPrice"] = $_SESSION["totalPrice"] - $_SESSION["cartObjects"][$index]->getPrice();
  $_SESSION["nbObjects"] = $_SESSION["nbObjects"] - 1;
  array_splice($_SESSION["cartObjects"], $index, 1);
}
//  $_SESSION["loggedin"] = false;
?>
<html>

<head>
  <link rel="icon" href="../images/icon.png">
  <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
  <style>
    <?php include "../assets/myProfile.css" ?><?php include "../assets/myChart.css" ?><?php include "../assets/myAdresses.css" ?><?php include "../assets/mainPage.css" ?>
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
    <?php if ($_SESSION["user"] != null) { ?>
      <h1>Here is your basket <?php echo $_SESSION["user"]->getFirstname() ?>(<?php echo $_SESSION["nbObjects"] ?> items)</h1>
    <?php } else { ?>
      <h1>Here is your basket (<?php echo $_SESSION["nbObjects"] ?> items)</h1>
    <?php } ?>
    <div class="chart">
      <table>
        <thead>
          <tr>
            <td>Picture</td>
            <td>Model</td>
            <td>Brand</td>
            <td>Capacity</td>
            <td>Quantity</td>
            <td>Price (before tax)</td>
          </tr>
        </thead>
        <tbody>
          <?php if (count($_SESSION["cartObjects"]) > 0) {
            for ($i = 0; $i < count($_SESSION["cartObjects"]); $i++) {
              if (!empty($_SESSION["cartObjects"][$i])) { ?>
                <tr class="objectrow">
                  <td><a href="selectedObject.php?Id=<?= $_SESSION["cartObjects"][$i]->getId(); ?>&category=<?= $_SESSION["cartObjects"][$i]->getProductCategory(); ?>"><img class="chartPic" src='<?php echo $_SESSION["cartObjects"][$i]->getPicture() ?>' alt=""></a></td>
                  <td><?php echo $_SESSION["cartObjects"][$i]->getModel() ?></td>
                  <td><?php echo $_SESSION["cartObjects"][$i]->getBrand() ?></td>
                  <td><?php echo $_SESSION["cartObjects"][$i]->getCapacity() ?></td>
                  <td>1</td>
                  <td><?php echo $_SESSION["cartObjects"][$i]->getPrice() ?>??</td>
                  <td><button class="trashbtn" id="trashbtn"><img src="../images/trash.png" alt=""></button></td>
                </tr>
            <?php }
            } ?>
          <?php } else { ?>
            <tr>
              <td colspan="7">Your basket is empty.</td>
            </tr>
          <?php }
          ?>
          <tr>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td style="font-size:16px;border : 1px solid black;">Price (before tax): </td>
            <td style="font-size:18px; color:black; border : 1px solid black;"><?php echo $_SESSION["totalPrice"]; ?> ??</td>
          </tr>
          <tr>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td style="font-size:16px;border : 1px solid black;">Total tax: </td>
            <td style="font-size:18px; color:black; border : 1px solid black;"><?php echo round(($_SESSION["totalPrice"] * 20 / 100), 2) ?> ?? </td>
          </tr>
          <tr>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td style="font-size:16px;border : 1px solid black;">Shipping cost: </td>
            <td style="font-size:18px; color:black; border : 1px solid black;">


              <?php
              if (round($_SESSION["totalPrice"] + $_SESSION["totalPrice"] * 20 / 100 + $_SESSION["totalPrice"] * 1.5 / 100, 2) < 1500) {
                echo round(($_SESSION["totalPrice"] * 1 / 100), 2) . "??";
              } else {
                echo "offered !";
              }
              ?></td>
          </tr>
          <tr>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td style="font-size:18px;border : 1px solid black;">Total price : </td>
            <td style="font-size:22px; color:red; border : 1px solid black;"><?php echo round(($_SESSION["totalPrice"] + $_SESSION["totalPrice"] * 20 / 100 + $_SESSION["totalPrice"] * 1.5 / 100), 2); ?> ??</td>
          </tr>
          <tr>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td class="empty"></td>
            <td colspan="2">
              <form action="" method="post">
                <?php if (count($_SESSION["cartObjects"]) > 0) { ?>
                  <input type="submit" style="text-align:center" name="ordernow" id="ordernow" value="order now !">
                <?php } else { ?>
                  <input type="submit" style="text-align:center" name="ordernow" id="ordernow" value="nothing to order :(" disabled>
                <?php } ?>
              </form>
            </td>

          </tr>
        </tbody>
      </table>
    </div>
    <div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <form action="" method="post">
          <p>Are you sure you want to delete this item ? <input style="display:none" id="index" name="index" value='1' /></p>
          <input type="submit" onclick="delayReload()" class="btn-primary" name="deleteItem" id="add" value="Yes, I want to">
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
                      echo round(($_SESSION["totalPrice"] * 1 / 100), 2) . "??";
                    } else {
                      echo "offered !";
                    }
                    ?></td>
                  </tr>
                  <tr>
                    <td style="color: white;">Total price : </td>
                    <td style="color: white;"><?php echo round(($_SESSION["totalPrice"] + $_SESSION["totalPrice"] * 20 / 100 + $_SESSION["totalPrice"] * 1.5 / 100), 2); ?> ??</td>
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
      <strong style="color:white;margin-left:40px;">?? YOURMARKET. ALL RIGHTS RESERVED Apolline Cherrey & Eliott Morcillo 2021.</strong>
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
  <?php include "../javascript/myChart.js" ?>
</script>

</html>