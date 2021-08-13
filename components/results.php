<?php
// Initialize the session
require_once "config.php";
require "user.php";
require "objects.php";
require "flash.php";
session_start();
if (isset($_POST["submitresearch"]) && $_POST["submitresearch"]) {
    $search = $_POST['researchInput'];
    header("location: results.php?research=$search");
  }
// Check if the user is logged in, if not then redirect him to login page
if ($_SESSION["email"] == "eliott.morcillo@gmail.com") {
    $actual_user = new user($_SESSION["id"], $_SESSION["firstname"], $_SESSION["lastname"], $_SESSION["email"], true);
    $_SESSION["message"] = "Welcome " . $_SESSION["firstname"];
} else {
    $actual_user = new user($_SESSION["id"], $_SESSION["firstname"], $_SESSION["lastname"], $_SESSION["email"], false);
    $_SESSION["message"] = "Welcome " . $_SESSION["firstname"];
}
//if the research is not null
if (isset($_GET['research']) and !empty($_GET['research'])) {
    $research = $_GET['research'];
    $compteur = 0; //select from category buy now
    $compteur2 = 0; //select from category auctions
    $compteur3 = 0; //select from category flash sales
    $compteur4 = 0; //select from category bestoffers
    $compteur5 = 0; //select from phones with keyword
    $compteur6 = 0; //select from laptops with keyword
    $compteur7 = 0; //select from earphones with keyword
    $compteur8 = 0; //select from tablets with keyword
    $compteur9 = 0;//select from bestoffers with keyword
    $compteur10 = 0;//select from flashsales with keyword
    $compteur11 = 0;//select from auctions with keyword
    $sql = mysqli_query($succes, $sql = "SELECT * FROM `$research` WHERE 1");
    if ($sql) {
        $row = mysqli_num_rows($sql);
        while ($row > $compteur) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
            $compteur = $compteur + 1;
        }
    }
    $sql = mysqli_query($succes, $sql = "SELECT * FROM `auctions` WHERE `secCategory` LIKE '$research'");
    if ($sql) {
        $row = mysqli_num_rows($sql);
        while ($row > $compteur2) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur + $compteur2] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
            $compteur2 = $compteur2 + 1;
        }
        $compteur = $compteur + $compteur2;
    }
    $sql = mysqli_query($succes, $sql = "SELECT * FROM `flashsales` WHERE `secCategory` LIKE '$research'");
    if ($sql) {
        $row = mysqli_num_rows($sql);
        while ($row > $compteur3) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur + $compteur3] =  new flash($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"], $result["discount"], $result["endingTime"]);
            $compteur3 = $compteur3 + 1;
        }
        $compteur = $compteur + $compteur3;
    }
    $sql = mysqli_query($succes, $sql = "SELECT * FROM `bestoffers` WHERE `secCategory` LIKE '$research'");
    if ($sql) {
        $row = mysqli_num_rows($sql);
        while ($row > $compteur4) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur + $compteur4] =  new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
            $compteur4 = $compteur4 + 1;
        }
        $compteur = $compteur + $compteur4;
    }
    $sql = mysqli_query($succes, $sql = "SELECT * FROM `phones` WHERE `brand` LIKE '%$research%' OR `model` LIKE '%$research%' OR `capacity` LIKE '%$research%' OR `size` LIKE '%$research%'");
    if ($sql) {
        $row = mysqli_num_rows($sql);
        while ($row > $compteur5) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur + $compteur5] =  new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
            $compteur5 = $compteur5 + 1;
        }
        $compteur = $compteur + $compteur5;
    }
    $sql = mysqli_query($succes, $sql = "SELECT * FROM `earphones` WHERE `brand` LIKE '%$research%' OR `model` LIKE '%$research%' OR `capacity` LIKE '%$research%' OR `size` LIKE '%$research%'");
    if ($sql) {
        $row = mysqli_num_rows($sql);
        while ($row > $compteur6) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur + $compteur6] =  new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
            $compteur6 = $compteur6 + 1;
        }
        $compteur = $compteur + $compteur6;
    }
    $sql = mysqli_query($succes, $sql = "SELECT * FROM `laptops` WHERE `brand` LIKE '%$research%' OR `model` LIKE '%$research%' OR `capacity` LIKE '%$research%' OR `size` LIKE '%$research%'");
    if ($sql) {
        $row = mysqli_num_rows($sql);
        while ($row > $compteur7) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur + $compteur7] =  new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
            $compteur7 = $compteur7 + 1;
        }
        $compteur = $compteur + $compteur7;
    }
    $sql = mysqli_query($succes, $sql = "SELECT * FROM `tablets` WHERE `brand` LIKE '%$research%' OR `model` LIKE '%$research%' OR `capacity` LIKE '%$research%' OR `size` LIKE '%$research%'");
    if ($sql) {
        $row = mysqli_num_rows($sql);
        while ($row > $compteur8) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur + $compteur8] =  new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
            $compteur8 = $compteur8 + 1;
        }
        $compteur = $compteur + $compteur8;
    }
    $sql = mysqli_query($succes, $sql = "SELECT * FROM `bestoffers` WHERE `brand` LIKE '%$research%' OR `model` LIKE '%$research%' OR `capacity` LIKE '%$research%' OR `size` LIKE '%$research%'");
    if ($sql) {
        $row = mysqli_num_rows($sql);
        while ($row > $compteur9) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur + $compteur9] =  new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
            $compteur9 = $compteur9 + 1;
        }
        $compteur = $compteur + $compteur9;
    }
    $sql = mysqli_query($succes, $sql = "SELECT * FROM `flashsales` WHERE `brand` LIKE '%$research%' OR `model` LIKE '%$research%' OR `capacity` LIKE '%$research%' OR `size` LIKE '%$research%'");
    if ($sql) {
        $row = mysqli_num_rows($sql);
        while ($row > $compteur10) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur + $compteur10] =  new flash($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"], $result["discount"], $result["endingTime"]);
            $compteur10 = $compteur10 + 1;
        }
        $compteur = $compteur + $compteur10;
    }
    $sql = mysqli_query($succes, $sql = "SELECT * FROM `auctions` WHERE `brand` LIKE '%$research%' OR `model` LIKE '%$research%' OR `capacity` LIKE '%$research%' OR `size` LIKE '%$research%'");
    if ($sql) {
        $row = mysqli_num_rows($sql);
        while ($row > $compteur11) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur + $compteur11] =  new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
            $compteur11 = $compteur11 + 1;
        }
        $compteur = $compteur + $compteur11;
    }
}
// Close statement
if (!empty($creations)) {
    shuffle($creations);
}
mysqli_close($succes);
?>
<html>

<head>
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
    <style>
        <?php include "../assets/mainPage.css" ?>
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
    <section style="min-height:300px">
        <br><br><br>
        <?php if ($compteur == 0) { ?>
            <h1>Sorry, no result found for '<?php echo $research ?>'.
                <a href="productsChoice.php">View our items.</a>
            </h1>
        <?php } else { ?>
            <div class="showObjects">
                <?php
                for ($i = 0; $i < $compteur; $i++) {
                    if ($creations[$i]->getProductCategory() == "flashsales") { ?>
                        <div class="object">
                            <h1 class="textDiscount">Flash sale !</h1>
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
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="object">
                            <?php if ($creations[$i]->getProductCategory() == "auctions") { ?>
                                <img class="iconpng" src="../images/Auction-label.png" alt="">
                            <?php } else if ($creations[$i]->getProductCategory() == "bestoffers") { ?>
                                <img style="transform:translateX(140%)" class="iconpng" src="https://images-eu.ssl-images-amazon.com/images/I/511dTxcqHIL.png" alt="">
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
                                </tbody>
                            </table>
                        </div>
            <?php }
                }
            }
            ?>
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
<script>
    <?php include "../javascript/navApp.js" ?>
</script>
<script>
    <?php include "../javascript/mainPage.js" ?>
</script>

</html>