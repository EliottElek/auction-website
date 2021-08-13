<?php
require_once "config.php";
require "user.php";
require "objects.php";
require "adress.php";
require "flash.php";
require "auction.php";
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
//we load all adresses linked to the user 
$sql = mysqli_query($succes, $sql = "SELECT * FROM `adress` WHERE `userID` like " . $_SESSION['user']->getId());
$row = mysqli_num_rows($sql);
$compteur = 0;
while ($row > $compteur) {
    $result = mysqli_fetch_assoc($sql);
    $adresses[$compteur] = new adress($result["country"], $result["city"], $result["postal"], $result["adress"]);
    $compteur = $compteur + 1;
}
// Close statement
$adress_err = $country_err = $city_err = $postal_err = "";
$adress = $country = $city = $postal = "";
mysqli_close($succes);
//check for adress
if (isset($_POST['addAdressSubmit']) && $_POST['addAdressSubmit']) {
    if (empty(trim($_POST["adress"]))) {
        $adress_err = "Please enter an adress.";
    } else {
        $adress = trim($_POST["adress"]);
    }
    //check for country
    if (empty(trim($_POST["country"]))) {
        $country_err = "Please enter a country.";
    } else {
        $country = trim($_POST["country"]);
    }
    //check for city
    if (empty(trim($_POST["city"]))) {
        $city_err = "Please enter a city.";
    } else {
        $city = trim($_POST["city"]);
    }
    //check for postal
    if (empty(trim($_POST["postal"]))) {
        $postal_err = "Please enter a postal.";
    } else {
        $postal = trim($_POST["postal"]);
    }
    if (empty($adress_err) && empty($postal_err) && empty($country_err) && empty($city_err)) {
        $sql = "INSERT INTO `adress`(`id`, `userID`, `country`, `city`, `postal`, `adress`) VALUES (NULL,?,?,?,?,?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
          $id = $_SESSION["user"]->getId();
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "issss", $id, $country, $city, $postal, $adress);
            session_start();
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: myAdresses.php");
            } else {
                echo "Something went wrong.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
if (isset($_POST['deleteMain']) && $compteur > 0) {
    if ($compteur == 1) {
        $sql = "DELETE FROM `adress` WHERE `userID` like " . $_SESSION["user"]->getId() . " && `adress` like '" . $adresses[0]->getAdress() . "'";
    } else if ($compteur == 2) {
        $sql = "DELETE FROM `adress` WHERE `userID` like " . $_SESSION["user"]->getId() . " && `adress` like '" . $adresses[0 ]->getAdress() . "'";
    }
    if (mysqli_query($link, $sql)) {
        echo "main adress successfully deleted.";
        header("Refresh:0");
    } else {
        echo "error during deleting adress.";
    }
} else if (isset($_POST['deleteSecond']) && $compteur > 0) {
    if ($compteur == 1) {
        $sql = "DELETE FROM `adress` WHERE `userID` like " . $_SESSION["user"]->getId() . " && `adress` like '" . $adresses[0]->getAdress() . "'";
    } else if ($compteur == 2) {
        $sql = "DELETE FROM `adress` WHERE `userID` like " . $_SESSION["user"]->getId() . " && `adress` like '" . $adresses[1]->getAdress() . "'";
    }
    if (mysqli_query($link, $sql)) {
        echo "main adress successfully deleted.";
        header("Refresh:0");
    } else {
        echo "error during deleting adress.";
    }
}
mysqli_close($link);

?>
<html>

<head>
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
    <style>
       <?php include "../assets/myProfile.css" ?><?php include "../assets/myAdresses.css" ?> <?php include "../assets/mainPage.css" ?>
    </style>
    <title>Yourmarket</title>
</head>

<body>
    <section>
    <div class="infos" style="display:none; transform:translateY(900%)">
    <input type="text" id="status" value='<?php echo $_SESSION["user"]->isBuyer() ?>'>
    <input type="text" id="indexofcolor" value='<?php echo $indexOfColor ?>'>
  </div>
        <h3 id="welcome">Modify your adresses and your delivery preferences.</h3><br>
        <div class="showOptions">
            <?php if ($compteur == 0) { ?>
                <h3>You did not register any adress yet.</h3>
                <div class="addAdress" id="addAdress1">
                    <img src="../images/add.png" alt="">
                    <img src="../images/house.png" alt="">
                    <h2>Add main delivery adress</h2>
                </div>
                <div class="addForm" id="form1">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <h3>Main delivery adress</h3>
                        <label for="adress">Your adress</label>
                        <input type="text" placeholder="ex : 23 Avenue Clapin" name="adress">
                        <span style="color:red" ; class="help-block"><?php echo $adress_err; ?></span>
                        <label for="postal">Postal :</label>
                        <input type="text" placeholder="ex: 75008" name="postal">
                        <span style="color:red" ; class="help-block"><?php echo $postal_err; ?></span>
                        <label for="city">City :</label>
                        <input type="text" placeholder="ex: Paris" name="city">
                        <span style="color:red" ; class="help-block"><?php echo $city_err; ?></span>
                        <label for="country">Country :</label>
                        <input type="text" placeholder="ex: France" name="country">
                        <span style="color:red" ; class="help-block"><?php echo $country_err; ?></span>
                        <input type="submit" class="btn-primary" name="addAdressSubmit" id="add" value="add new adress">
                        <button onclick="cancelAdding()">cancel</button>
                    </form>
                </div>
                <div class="addAdress" id="addAdress2">
                    <img src="../images/add.png" alt="">
                    <img src="../images/house.png" alt="">
                    <h2>Add a secondary adress</h2>
                </div>
                <div class="addForm" id="form2">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <h3>Secondary delivery adress</h3>
                        <label for="adress">Your adress</label>
                        <input type="text" placeholder="ex : 23 Avenue Clapin" name="adress">
                        <span style="color:red" ; class="help-block"><?php echo $adress_err; ?></span>
                        <label for="postal">Postal :</label>
                        <input type="text" placeholder="ex: 75008" name="postal">
                        <span style="color:red" ; class="help-block"><?php echo $postal_err; ?></span>
                        <label for="city">City :</label>
                        <input type="text" placeholder="ex: Paris" name="city">
                        <span style="color:red" ; class="help-block"><?php echo $city_err; ?></span>
                        <label for="country">Country :</label>
                        <input type="text" placeholder="ex: France" name="country">
                        <span style="color:red" ; class="help-block"><?php echo $country_err; ?></span>
                        <input type="submit" class="btn-primary" name="addAdressSubmit" id="add" value="add new adress">
                        <button onclick="cancelAdding()">cancel</button>
                    </form>
                </div>
            <?php } else if ($compteur == 1) { ?>
                <div class="Adress">
                    <h3>main delivery adress :</h3>
                    <p>adress : <?php echo $adresses[0]->getAdress() ?></p>
                    <p>postal :<?php echo $adresses[0]->getPostal() ?></p>
                    <p> city :<?php echo $adresses[0]->getCity() ?></p>
                    <p>country :<?php echo $adresses[0]->getCountry() ?></p>
                    <button class="deleteMainAdress" id="delete1">delete</button>
                </div>
                <div class="addAdress" id="addAdress1-2">
                    <img src="../images/add.png" alt="">
                    <img src="../images/house.png" alt="">
                    <h2>Add a secondary adress</h2>
                </div>
                <div class="addForm" id="form1-2">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <h3>New delivery adress</h3>
                        <label for="adress">Your adress</label>
                        <input type="text" placeholder="ex : 23 Avenue Clapin" name="adress">
                        <span style="color:red" ; class="help-block"><?php echo $adress_err; ?></span>
                        <label for="postal">Postal :</label>
                        <input type="text" placeholder="ex: 75008" name="postal">
                        <span style="color:red" ; class="help-block"><?php echo $postal_err; ?></span>
                        <label for="city">City :</label>
                        <input type="text" placeholder="ex: Paris" name="city">
                        <span style="color:red" ; class="help-block"><?php echo $city_err; ?></span>
                        <label for="country">Country :</label>
                        <input type="text" placeholder="ex: France" name="country">
                        <span style="color:red" ; class="help-block"><?php echo $country_err; ?></span>
                        <input type="submit" class="btn-primary" name="addAdressSubmit" id="add" value="add new adress">
                        <button onclick="cancelAdding()">cancel</button>
                    </form>
                </div>
            <?php } else if ($compteur == 2) { ?>
                <div class="Adress">
                    <h3>main delivery adress :</h3>
                    <p>adress : <?php echo $adresses[0]->getAdress() ?></p>
                    <p>postal :<?php echo $adresses[0]->getPostal() ?></p>
                    <p> city :<?php echo $adresses[0]->getCity() ?></p>
                    <p>country :<?php echo $adresses[0]->getCountry() ?></p>
                    <button class="deleteMainAdress" id="delete21">delete</button>
                </div>
                <div class="Adress">
                    <h3>second delivery adress :</h3>
                    <p>adress : <?php echo $adresses[1]->getAdress() ?></p>
                    <p>postal :<?php echo $adresses[1]->getPostal() ?></p>
                    <p> city :<?php echo $adresses[1]->getCity() ?></p>
                    <p>country :<?php echo $adresses[1]->getCountry() ?></p>
                    <button class="deleteSecAdress" id="delete22">delete</button>
                </div>
            <?php } ?>
        </div>
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <form action="" method="post">
                    <p>Are you sure you want to delete your main adress ?</p>
                    <input type="submit" onclick = "delayReload()" class="btn-primary" name="deleteMain" id="add" value="Yes, I want to">
                </form>
            </div>
        </div>
        <div id="myModalSec" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <form action="" method="post">
                    <p>Are you sure you want to delete your secondary adress ?</p>
                    <input type="submit" class="btn-primary" name="deleteSecond" id="add" value="Yes, I want to">
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
          <li id="welcome"><span style="margin:0px;color: rgb(238, 207, 34);"><?php echo "welcome  " . $_SESSION["user"]->getFirstname() ?></span></li>
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
  <footer style = "transform:translateY(80%)">
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
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
    <?php include "../javascript/navApp.js" ?>
    <?php include "../javascript/myAdresses.js" ?>
</script>
<script>
<?php include "../javascript/mainPage.js" ?>
</script>
<script>
  <?php include "../javascript/myProfile.js" ?>
</script>
</html>