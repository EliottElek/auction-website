<?php
require_once "config.php";
require "user.php";
require "objects.php";
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
  $sql = mysqli_query($succes, $sql = "SELECT `backgroundindex` FROM `sellerprofiles` WHERE `sellerID` LIKE $id ");
  $row = mysqli_num_rows($sql);
  $compteur = 0;
  while ($row > $compteur) {
    $result = mysqli_fetch_assoc($sql);
    $indexOfColor = $result["backgroundindex"];
    $compteur = $compteur + 1;
  }
  mysqli_close($succes);
}
//if the user cnages his background
if (isset($_POST["validateBackground"]) && $_POST["validateBackground"]) {
  if (!empty($_POST['selectColor'])) {
    $newIndexColor = $_POST["selectColor"];
    $sellerid = $_SESSION["user"]->getId();
    //we modify user's background in the database
    $sql = "UPDATE `sellerprofiles` SET `backgroundindex`= $newIndexColor WHERE `sellerID`= $sellerid";

    if ($link->query($sql) === TRUE) {
      echo "seller background successfully modified.";
      header("refresh: 0");
    } else {
      echo "Error changing record: " . $link->error;
    }
  }
}
?>
<html>

<head>
  <link rel="icon" href="../images/icon.png">
  <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
  <style>
    <?php include "../assets/myProfile.css" ?><?php include "../assets/myAdresses.css" ?><?php include "../assets/mainPage.css" ?>
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
  <div class="infos" style="display:none; transform:translateY(900%)">
    <input type="text" id="status" value='<?php echo $_SESSION["user"]->isBuyer() ?>'>
    <input type="text" id="indexofcolor" value='<?php echo $indexOfColor ?>'>
  </div>
  <section>
    <?php if ($_SESSION['user']->isBuyer()) { ?>
      <div class="profileImage">
        <a href="" class="profileModif" id="profileModif"><img id = "profPic" src="../images/userPic.png" alt=""></a>
      </div>
    <?php } ?>
    <?php if ($_SESSION["loggedin-as-admin"]) { ?>
      <br>
      <h3 id="welcome">ADMIN SESSION</h3>
      <div class="showOptionsProfile">
        <a href="allOrders.php">
          <div class="option" id="my-orders">
            <img id="cardboard" src="../images/cardboard.png" alt="">
            <div class="text">
              <h4>All orders</h4>
              <p>View all orders</p>
            </div>
          </div>
        </a>
        <a href="allProfiles.php">
          <div class="option" id="my-security">
            <img src="../images/profiles.png" alt="">
            <div class="text">
              <h4>Profiles</h4>
              <p>View and manage all profiles.</p>
            </div>
          </div>
        </a>
        <a href="allProducts.php">
          <div class="option" id="my-payments">
            <img src="../images/items.png" alt="">
            <div class="text">
              <h4>Products
              </h4>
              <p>View and manage all products.</p>
            </div>
          </div>
        </a>
        <a href="allAdresses.php">
          <div class="option" id="my-adresses">
            <img src="../images/position.png" alt="">
            <div class="text">
              <h4>Adresses</h4>
              <p>View and manage all adresses</p>
            </div>
          </div>
        </a>
        <a href="allSales.php">
          <div class="option" id="my-sales">
            <img src="../images/money.png" alt="">
            <div class="text">
              <h4>Sales
              </h4>
              <p>View and manage all sales</p>
            </div>
          </div>
        </a>
        <a href="allAuctionsAdmin.php">
          <div class="option" id="my-auctions">
            <img src="../images/auction.png" alt="">
            <div class="text">
              <h4>Auctions
              </h4>
              <p>View and manage all auctions</p>
            </div>
          </div>
        </a>
      </div>
    <?php } else { ?>
      <br>
      <div class="showOptionsProfile">
        <a href="myOrders.php">
          <div class="option" id="my-orders">
            <img id="cardboard" src="../images/cardboard.png" alt="">
            <div class="text">
              <h4>My orders</h4>
              <p>Follow your orders</p>
            </div>
          </div>
        </a>
        <a href="settings.php">
          <div class="option" id="my-security">
            <img src="../images/settings.png" alt="">
            <div class="text">
              <h4>Settings</h4>
              <p>Modify e-mail, password, phone number, and other infos</p>
            </div>
          </div>
        </a>
        <a href="myPayments.php">
          <div class="option" id="my-payments">
            <img src="../images/cards.png" alt="">
            <div class="text">
              <h4>My payments
              </h4>
              <p>Manage payment methods and settings</p>
            </div>
          </div>
        </a>
        <a href="myAdresses.php">
          <div class="option" id="my-adresses">
            <img src="../images/position.png" alt="">
            <div class="text">
              <h4>My adresses</h4>
              <p>Modify your adresses and your delivery preferences</p>
            </div>
          </div>
        </a>
        <?php if ($_SESSION["user"]->isBuyer()) { ?>
          <a href="mySales.php">
            <div class="option" id="my-sales">
              <img src="../images/money.png" alt="">
              <div class="text">
                <h4>My sales
                </h4>
                <p>View and manage the objects you sell</p>
              </div>
            </div>
          </a>
        <?php } else { ?>
          <div class="diabledoption" id="my-sales">
            <img src="../images/money.png" alt="">
            <div class="text">
              <h5>My sales (not available as buyer only)
              </h5>
              <p>Log in as a seller to view your sales</p>
              <p> (or :Settings -> become a seller)</p>
            </div>
          </div>
        <?php } ?>
        <a href="myAuctions.php">
          <div class="option" id="my-auctions">
            <img src="../images/auction.png" alt="">
            <div class="text">
              <h4>My auctions and best offers
              </h4>
              <p style="transform:translateY(-40%);">View and manage your auctions and best offers</p>
            </div>
          </div>
        </a>
      </div>
    <?php } ?>
    <div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content" id="customProfile">
        <span class="close">&times;</span>
        <form action="" method="post">
          <div style="background-image:url('https://images.unsplash.com/photo-1595757816291-ab4c1cba0fc2?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1000&q=80'); 
        " class="sample" id="orange"></div><input type="radio" name="selectColor" value='1'><br>
          <div style="background-image:url('https://img.freepik.com/vecteurs-libre/fond-blanc-elegant-lignes-brillantes_1017-17580.jpg?size=626&ext=jpg&ga=GA1.2.1282066085.1610236800'); 
        " class="sample" id="white"></div><input type="radio" name="selectColor" value='2'><br>
          <div style="background-image:url('https://www.enjpg.com/img/2020/light-blue-background-4.jpg'); 
        " class="sample" id="yellow"></div><input type="radio" name="selectColor" value='3'><br>
          <div style="background-image:url('https://i.pinimg.com/originals/3a/fc/fc/3afcfcafb55d99e30d9a7ffab4ed96c7.jpg'); 
        " class="sample" id="green"></div><input type="radio" name="selectColor" value='4'>
          <div style="background-image:url('https://i.pinimg.com/originals/ba/32/e3/ba32e3025d97b4da3bc0a68474c43217.jpg'); 
        " class="sample" id="12"></div><input type="radio" name="selectColor" value='5'>
          <div style="background-image:url('https://cdn4.vectorstock.com/i/1000x1000/95/18/seamless-geometric-pattern-repeating-background-vector-9789518.jpg'); 
        " class="sample" id="13"></div><input type="radio" name="selectColor" value='6'>
          <div style="background-image:url('http://unblast.com/wp-content/uploads/2020/05/Light-Wood-Background-Texture-4.jpg'); 
        " class="sample" id="14"></div><input type="radio" name="selectColor" value='7'>
          <div style="background-image:url('https://cdn.hipwallpaper.com/i/40/76/J6SsKx.jpg'); 
        " class="sample" id="15"></div><input type="radio" name="selectColor" value='8'>
          <div style="background-image:url('https://www.desktopbackground.org/download/1920x1080/2015/07/31/987869_magic-blue-sea-bright-spots-backgrounds-large-wallpapers-1920-1166_1920x1166_h.jpg'); 
        " class="sample" id="16"></div><input type="radio" name="selectColor" value='9'>
          <input type="submit" name="validateBackground" id="validateBackground" value="save changes">
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
      <strong style = "color:white;margin-left:40px;">?? YOURMARKET. ALL RIGHTS RESERVED Apolline Cherrey & Eliott Morcillo 2021.</strong>
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
</html>