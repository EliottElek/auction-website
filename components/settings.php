<?php
require_once "config.php";
require "user.php";
require "objects.php";
session_start();
$message = "";
$message2 = "";
ini_set("SMTP", "smtp.gmail.com");
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
//if user decides to become a buyer
if (isset($_POST["becomeBuyer"]) && $_POST["becomeBuyer"] && !empty($_POST["terms"])) {
    $_SESSION["user"]->setBuyer(true);
    $idSession = $_SESSION["user"]->getId();
    //we change his status in databse
    $sql = "UPDATE `users` SET `isbuyer`= 1 WHERE `id` LIKE '$idSession'";
    $sql2 = "INSERT INTO `sellerprofiles`(`id`, `sellerID`, `backgroundindex`) VALUES (NULL,$idSession,2)";
    if ($link->query($sql) === TRUE&&$link->query($sql2) === TRUE) {
        echo "status modified successfully";

        header("refresh: 0");
    } else {
        echo "Error changing password: " . $link->error;
    }
}
///Change password script
if (isset($_POST["changePass"]) && $_POST["changePass"]) {
    $param_email = $_SESSION["email"];
    $sql = "SELECT password FROM users WHERE email = ?";
    $oldpass = $_POST["oldpass"];
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $hashed_password = "";
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            mysqli_stmt_store_result($stmt);

            // Check if username exists, if yes then verify password
            if (mysqli_stmt_num_rows($stmt) == 1) {
                echo "Account found.";
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($oldpass, $hashed_password)) {
                        $idSession = $_SESSION["user"]->getId();
                        $newpass = password_hash($_POST["newpass"], PASSWORD_DEFAULT);
                        $sql = "UPDATE `users` SET `password`='$newpass' WHERE `id` LIKE '$idSession'";
                        if ($link->query($sql) === TRUE) {
                            echo "Password modified successfully";

                            header("refresh: 0");
                        } else {
                            echo "Error changing password: " . $link->error;
                        }
                    } else {
                        $message2 = "password did not match";
                    }
                }
            }
        }
    }
}
///Change infos script
if (isset($_POST["changeInfos"]) && $_POST["changeInfos"]) {
    $param_email = $_SESSION["email"];
    $sql = "SELECT * FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            mysqli_stmt_store_result($stmt);

            // Check if username exists, if yes then verify password
            if (mysqli_stmt_num_rows($stmt) == 1) {
                $idSession = $_SESSION["user"]->getId();
                $isbuyer = $_SESSION["user"]->isBuyer();
                $firstname = $_POST["firstname"];
                $lastname = $_POST["lastname"];
                $email = $_POST["email"];
                $sql = "UPDATE `users` SET `firstname`= '$firstname',`lastname`='$lastname',`email`='$email' WHERE `id` LIKE '$idSession'";
                $_SESSION["user"] = new user($idSession, $firstname, $lastname, $email, $isbuyer);
                if ($link->query($sql) === TRUE) {
                    echo "infos modified successfully";
                    header("MyProfile.php");
                } else {
                    echo "Error changing infos: " . $link->error;
                }
            }
        }
    }
}
?>
<html>

<head>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
    <style>
        <?php include "../assets/myProfile.css" ?><?php include "../assets/settings.css" ?><?php include "../assets/mainPage.css" ?>
    </style>
    <title>Yourmarket</title>
    <script>
        <?php include "../javascript/sendEmail.js" ?>
    </script>
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
        <h3 id="welcome">Modify e-mail, password, phone number, and other infos.</h3>
        <div class="showOptionsSettings">
            <form action="" method="post">
                <div class="showPersonalInfos" style="margin-top:24px;">
                    <h1>My personal infos</h1>
                    <!-- <form action=""> -->
                    <label for="firstname">Firstname</label>
                    <input required disabled class="info" type="text" name="firstname" value=<?php echo $_SESSION["user"]->getFirstname() ?>>
                    <label for="lastname">Lastname</label>
                    <input required disabled class="info" type="text" name="lastname" value=<?php echo $_SESSION["user"]->getLastname() ?>>
                    <label for="email">Email</label>
                    <input required disabled class="info" type="email" name="email" value=<?php echo $_SESSION["user"]->getEmail() ?>>
                    <!-- <input type="submit" name = "modifyPers"> -->
                    <!-- </form> -->
                    <button id="modify" onclick="return false;">modify</button>
                    <input style="display:none" type="submit" name="changeInfos" value="saveInfos" id="saveInfos">
                </div>
            </form>
            <div class="showPersonalInfos">
                <h1>Modify password</h1>
                <button id="continue">Change my password</button>
            </div>
            <?php if (!$_SESSION["user"]->isBuyer()) { ?>
                <div class="showPersonalInfos">
                    <h1>Become a seller</h1>
                    <button id="buyerbtn">Become a seller now ! -></button>
                </div>
            <?php } ?>
        </div>
        <div id="myModalGetBuyer" class="modal">
            <!-- Modal content -->
            <div class="modal-content" id="getBuyerContent">
                <span class="close">&times;</span>
                <h1>Becoming a seller</h1>
                <div class="getBuyerContentInsideDiv">
                    <p>Duis neque purus, interdum nec dictum vel, suscipit a est. Nullam elementum risus augue. Ut ac malesuada quam, in vulputate eros. Duis imperdiet ultricies pulvinar. Etiam interdum laoreet tortor, at dapibus odio vehicula eu. Nulla sed posuere leo. Morbi turpis nisl, aliquam ut arcu ut, ultricies imperdiet ipsum. Donec placerat, arcu et lacinia fringilla, ligula ex bibendum metus, et sollicitudin elit eros id nisi.

                        Aliquam risus leo, pharetra ac luctus eget, volutpat ac sem. Nam accumsan cursus mi, in euismod libero feugiat tempus. Aliquam fermentum dui ut diam vulputate feugiat. Donec fermentum nec ante non eleifend. Fusce aliquam eu leo vitae consequat. Donec pretium justo quam, a consequat magna mattis ut. Quisque viverra viverra massa tempus luctus. In pulvinar, eros et elementum venenatis, risus dolor pretium libero, nec aliquet diam nunc sed urna. Integer vulputate nisl in ante tristique, nec efficitur libero tincidunt. Aenean eleifend hendrerit velit, non sagittis magna congue in. Donec a ligula efficitur, gravida lectus sed, lacinia dolor. Etiam interdum dolor id venenatis pulvinar. Sed id dictum neque.

                        Sed at turpis eu enim eleifend placerat. Curabitur facilisis sit amet quam eu sodales. Integer nec tincidunt mauris. Donec sollicitudin turpis tincidunt est fermentum, sed lacinia velit posuere. Sed metus lacus, dignissim scelerisque erat ut, mollis ultricies massa. Curabitur pulvinar blandit sagittis. In sed diam tempus, accumsan sem non, pharetra massa. Fusce a enim ligula. Donec dui tellus, convallis sit amet molestie a, commodo eget ipsum. Sed cursus nibh ac scelerisque fermentum. Sed auctor turpis odio, vitae volutpat felis ultrices sollicitudin. Vestibulum rhoncus fringilla dui nec ultricies. Maecenas eu ligula et arcu lacinia luctus in ac turpis. Donec ornare facilisis velit a euismod.</p>
                    <h1>Understanding what our policy is</h1>
                    <p>
                        Praesent varius tempor ex a convallis. Suspendisse pellentesque eget quam sagittis tristique. Aenean posuere pulvinar turpis at suscipit. Integer sit amet libero gravida sapien tempus viverra. Aenean hendrerit tincidunt euismod. Sed vel lacinia metus, volutpat luctus urna. Vivamus tristique nulla a urna facilisis, non porttitor justo mollis.

                        Mauris tristique diam eget interdum egestas. Nam placerat ullamcorper cursus. Suspendisse tristique massa tellus. Aliquam interdum tellus ac bibendum eleifend. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aliquam malesuada, ipsum vel bibendum feugiat, augue augue interdum leo, ut rutrum velit neque id elit. Aenean id maximus libero. Cras metus est, ornare et nisl vel, luctus ultricies lacus. Maecenas sed felis at orci finibus euismod.

                        Aenean mattis sem vitae imperdiet vehicula. Proin elementum tortor et lacinia maximus. Duis id massa vehicula, dictum nisl eu, rhoncus massa. Nulla aliquam maximus justo vitae venenatis. Pellentesque ornare est elit, at fringilla diam consequat nec. Nullam efficitur, leo eu lobortis aliquam, orci dolor vehicula velit, in eleifend ex nulla eu metus. Pellentesque justo purus, venenatis id tellus sed, elementum dignissim nisi. In hac habitasse platea dictumst. Maecenas placerat dui ac nunc elementum commodo. Aenean nibh nisi, feugiat ut varius in, suscipit nec ante. Suspendisse faucibus sem tellus, in aliquet arcu mollis et. Praesent a felis tincidunt, suscipit erat id, tristique nulla. Ut rhoncus feugiat ipsum, in consectetur massa porta sed. Cras sed venenatis nisl, non hendrerit nisl.

                        Cras in nulla vehicula, volutpat ex ut, congue felis. Nullam mollis ante urna, non laoreet nunc euismod finibus. Sed vitae est nibh. Donec quis rutrum diam. Duis congue sodales turpis sit amet fermentum. Mauris tristique est ut est tincidunt, nec facilisis urna auctor. Curabitur lobortis vel sem id porta. Sed consequat, nisi venenatis gravida finibus, neque magna euismod augue, a lobortis nunc urna pharetra nunc. Aliquam bibendum ornare metus sit amet facilisis. Etiam eu tortor lacus. Quisque in molestie quam.

                        Praesent magna tortor, feugiat eu sollicitudin sit amet, malesuada ac sem. Ut ut dapibus orci. Morbi ut quam mollis, mattis tellus efficitur, mollis risus. Sed mollis eros a mollis dapibus. Phasellus finibus orci eget velit sagittis aliquam. Donec molestie pharetra neque, eu tempor velit fermentum eu. Integer vitae dolor fringilla, mattis turpis ut, varius odio. Fusce placerat elit erat, eu semper justo tempor quis. Curabitur vel lobortis mauris. Ut sollicitudin eget tellus eget tempor. Nunc tempor, augue vitae tempus tristique, leo ante semper arcu, nec gravida ipsum justo eu diam. Sed laoreet fringilla lorem, ornare vulputate orci finibus non. Aenean in nunc consectetur, rhoncus leo ac, blandit ligula. Nullam vehicula sodales finibus. Fusce id magna metus. Ut venenatis arcu massa, sit amet sagittis mauris tempus ac.

                        Sed in erat pulvinar, tempus metus in, gravida enim. Suspendisse diam turpis, cursus quis justo quis, tincidunt auctor dui. Aenean elementum vitae diam id dignissim. In mollis venenatis est, quis tincidunt leo ullamcorper id. Integer et felis sed nunc tristique ullamcorper a sed sapien. Nunc libero nulla, sagittis vitae nisi quis, sagittis porttitor lorem. Maecenas suscipit libero risus, sit amet elementum nulla consectetur ut. Quisque in tellus feugiat, efficitur purus in, dictum risus. Praesent nec facilisis nisi. Mauris dolor purus, facilisis in nulla sed, ultricies luctus nisi.

                        Mauris egestas finibus tellus non tempus. Vestibulum mi tortor, semper sed sem eleifend, sollicitudin luctus est. Nulla consectetur urna quis aliquet iaculis. Suspendisse ullamcorper nulla vel risus efficitur, nec ultricies nisl sodales. Aenean viverra laoreet est et ultrices. Suspendisse ligula ipsum, ultricies at mauris ut, molestie cursus turpis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus lobortis magna eu orci tincidunt, eget rhoncus ligula vulputate. Phasellus consectetur ultrices ex ac fermentum. Duis at consequat magna. Morbi tellus velit, dapibus eu mollis vel, rhoncus nec mauris. Aliquam et elit at quam hendrerit accumsan in ut ex. Mauris porttitor quam ut arcu malesuada, a molestie risus porta.

                        Duis finibus nunc non pharetra sodales. Ut cursus in sem sed interdum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus turpis risus, laoreet sed facilisis ac, bibendum at tortor. Sed sollicitudin erat egestas magna tincidunt, in hendrerit elit eleifend. In nisl elit, fringilla quis iaculis a, mollis vitae ipsum. Nunc fermentum purus in semper pretium. Quisque ac justo non risus sollicitudin consectetur. Mauris eu ex risus. Curabitur tincidunt sagittis ultrices. Duis ultricies hendrerit lacus, ut vehicula lacus sodales in. Phasellus ac est vel ligula ultricies blandit non non odio. Suspendisse aliquet at lacus quis iaculis. Cras eleifend quam malesuada nibh vestibulum aliquet.

                        Praesent ullamcorper tristique justo, sit amet congue ante bibendum at. Nulla fermentum enim in est convallis tristique. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec interdum porta turpis, sit amet mollis massa tristique at. Vivamus vitae faucibus metus, a faucibus elit. Donec eget congue nisl. In eu magna vel lorem dictum placerat sit amet a tellus.

                        Nunc non tortor sed neque tincidunt hendrerit. Vestibulum ipsum ligula, blandit vitae dapibus nec, porttitor ac felis. Maecenas ac tortor elit. Curabitur in consectetur massa, mattis convallis purus. Nam vitae volutpat orci, quis efficitur arcu. Quisque porta arcu sit amet eros tempor facilisis. Etiam dolor quam, dapibus vitae scelerisque non, vehicula id lorem. Aenean lorem magna, dapibus a mauris ut, mollis feugiat urna. Duis eget magna venenatis, ullamcorper lorem eget, facilisis nisl.

                        Etiam nec purus nec erat maximus rhoncus tristique quis lorem. Vivamus sagittis ex eget diam ultricies, in efficitur metus auctor. Cras volutpat, odio non blandit blandit, mi erat consequat sem, quis ornare sapien mi hendrerit nisi. Pellentesque nec facilisis urna. Nunc maximus magna non ipsum luctus mattis. Vivamus eget justo vestibulum, dapibus nisi eget, ullamcorper felis. Aliquam erat volutpat. In porttitor congue rhoncus. Cras eget cursus velit. Vivamus fringilla augue ut convallis porta. Suspendisse non nulla aliquam, elementum arcu sed, fermentum dui. Ut et diam maximus, eleifend tellus scelerisque, luctus nisi. Praesent eu felis nisl. Nunc dictum tortor sit amet sapien maximus, eget ultrices nisi sagittis.

                        Suspendisse lorem odio, tincidunt in fermentum a, consectetur in nibh. Proin sit amet neque elementum, commodo nisi non, ultrices odio. Etiam condimentum pellentesque euismod. Morbi massa erat, vehicula egestas luctus non, laoreet eu nunc. Aliquam tincidunt tellus eget ipsum eleifend, ac ultrices ante dictum. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce non imperdiet augue. Praesent sit amet libero mauris.</p>
                    <form action="" method="post">
                        <input type="checkbox" name="terms" id="terms">
                        <label for="terms">By becoming a seller, you agree to our <a href="termsAndConditions.php">terms and conditions</a>.</label><br><br><br>
                        <span id="span" style="color:red"></span><br>
                        <input onclick="if (checkedIfAgreed()){return true;} else return false;" type="submit" class="btn-primary" name="becomeBuyer" id="becomeBuyer" value="Become a seller">
                    </form>
                    <br><br>
                </div>
            </div>
        </div>
        <div id="myModalModifPassword" class="modal">
            <!-- Modal content -->
            <div class="modal-content" id="contentPassword">
                <span class="close">&times;</span>
                <h1>Modify my password</h1>
                <div class="modifpasswordform">
                    <form class="modifpasswordform" action="" method="post">
                        <label for="oldpass">old password :</label>
                        <span style="color:red"><?php echo $message2 ?></span>
                        <input required id="oldpass" type="password" name="oldpass">
                        <input class="box" type="checkbox" onclick="myFunction('oldpass')">show
                        <label for="newpass">new password :</label>
                        <input required type="password" name="newpass" id="newpass">
                        <input class="box" type="checkbox" onclick="myFunction('newpass')">show
                        <label for="newpassconf">confirm new password:</label>
                        <input required type="password" name="newpassconf" id="newpassconf">
                        <input class="box" type="checkbox" onclick="myFunction('newpassconf')">show
                        <span id="span2" style="color:red"></span><br>
                        <input onclick="if (checkMatchingPasswords()){return true;} else return false;" type="submit" value="Change password" name="changePass" id="changePass">
                    </form>
                    <br><br>
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
    <footer style = "transform:translateY(100%)">
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
    <?php include "../javascript/mainPage.js" ?>
</script>
<script>
  <?php include "../javascript/myProfile.js" ?>
</script>
<script>
    <?php include "../javascript/navApp.js";
    include "../javascript/settings.js" ?>
</script>
</html>