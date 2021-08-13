<?php
// Initialize the session
require_once "config.php";
require "user.php";
require "objects.php";
require "auction.php";
require "flash.php";
require "bestoffer.php";
session_start();
$phones = array();
$obj = null;
$_SESSION["objectID"] = $_GET['Id'];
$_SESSION["objectCATEG"] = $_GET['category'];
if (isset($_POST["submitresearch"]) && $_POST["submitresearch"]) {
    $search = $_POST['researchInput'];
    header("location: results.php?research=$search");
}
$id = 0;
//we load the object; depending on if its a best offer, buy now, etc object, we are creating a different object
if (isset($_GET['Id']) and !empty($_GET['Id']) and isset($_GET['category']) and $_GET['category'] != "auctions" and $_GET['category'] != "flashsales" and $_GET['category'] != "bestoffers") {
    $id = $_GET['Id'];
    $sql = mysqli_query($succes, $sql = "SELECT * FROM " . $_GET['category'] . " WHERE Id =" . $_GET['Id'] . "");
    $result = mysqli_fetch_assoc($sql);
    $_SESSION["object"] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
} else if (isset($_GET['Id']) and !empty($_GET['Id']) and isset($_GET['category']) and $_GET['category'] == "auctions") {
    $id = $_GET['Id'];
    $sql = mysqli_query($succes, $sql = "SELECT * FROM " . $_GET['category'] . " WHERE Id =" . $_GET['Id'] . "");
    $result = mysqli_fetch_assoc($sql);
    $_SESSION["object"] = new auction($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"], $result["currentBid"], $result["endingTime"], $result["bestBidder"]);
} else if (isset($_GET['Id']) and !empty($_GET['Id']) and isset($_GET['category']) and $_GET['category'] == "flashsales") {
    $id = $_GET['Id'];
    $sql = mysqli_query($succes, $sql = "SELECT * FROM " . $_GET['category'] . " WHERE Id =" . $_GET['Id'] . "");
    $result = mysqli_fetch_assoc($sql);
    $_SESSION["object"] = new flash($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"], $result["discount"], $result["endingTime"]);
} else if (isset($_GET['Id']) and !empty($_GET['Id']) and isset($_GET['category']) and $_GET['category'] == "bestoffers") {
    $id = $_GET['Id'];
    $sql = mysqli_query($succes, $sql = "SELECT * FROM " . $_GET['category'] . " WHERE Id =" . $_GET['Id'] . " AND `status` != 'complete'");
    $result = mysqli_fetch_assoc($sql);
    $_SESSION["object"] = new bestoffer($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"], $result["sellerID"]);
    $idSeller = $result["sellerID"];
    $sql2 = mysqli_query($succes, $sql2 = "SELECT `firstname`, `lastname` FROM `users` WHERE `id` like '$idSeller'");
    $result2 = mysqli_fetch_assoc($sql2);
    $sellerUser = $result2["firstname"] . " " . $result2["lastname"];
}
if (isset($_GET['Id']) and !empty($_GET['Id'])) {
    $sql = mysqli_query($succes, $sql = "SELECT * FROM `images` WHERE `objectID` like " . $_GET['Id'] . " && category like '" . $_GET['category'] . "'");
    $row = mysqli_num_rows($sql);
    $compteur = 0;
    $images = array("", "", "");
    while ($row > $compteur) {
        $result = mysqli_fetch_assoc($sql);
        $images[$compteur] = $result["pictureLink"];
        $compteur = $compteur + 1;
    }
}
if (isset($_GET['Id']) and !empty($_GET['Id']) and isset($_GET['category'])) {
    $compteur2 = 0;
    $compteur3 = 0;
    $compteur4 = 0;
    $compteur5 = 0;
    $categ = $_GET['category'];
    if ($categ == "phones" or $categ == "earphones" or $categ == "tablets" or $categ == "laptops") {
        $sql = mysqli_query($succes, $sql = "SELECT * FROM `auctions` WHERE `secCategory` LIKE '$categ'");
        $row = mysqli_num_rows($sql);
        while ($row > $compteur2) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur2] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
            $compteur2 = $compteur2 + 1;
        }

        $sql = mysqli_query($succes, $sql = "SELECT * FROM `bestoffers` WHERE `secCategory` LIKE '$categ' AND `status` != 'complete'");
        $row = mysqli_num_rows($sql);
        while ($row > $compteur3) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur2 + $compteur3] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
            $compteur3 = $compteur3 + 1;
        }
        $compteur2 = $compteur2 + $compteur3;
        $sql = mysqli_query($succes, $sql = "SELECT * FROM `flashsales` WHERE `secCategory` LIKE '$categ'");
        $row = mysqli_num_rows($sql);
        while ($row > $compteur4) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur2 + $compteur4] =  new flash($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"], $result["discount"], $result["endingTime"]);
            $compteur4 = $compteur4 + 1;
        }
        $compteur2 = $compteur2 + $compteur4;
        $sql = mysqli_query($succes, $sql = "SELECT * FROM `$categ` WHERE 1");
        $row = mysqli_num_rows($sql);
        while ($row > $compteur5) {
            $result = mysqli_fetch_assoc($sql);
            $creations[$compteur2 + $compteur5] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
            $compteur5 = $compteur5 + 1;
        }
        $compteur2 = $compteur2 + $compteur5;
    } else {
        if ($categ == "auctions") {
            $sql = mysqli_query($succes, $sql = "SELECT * FROM `auctions` WHERE 1");
            $row = mysqli_num_rows($sql);
            while ($row > $compteur2) {
                $result = mysqli_fetch_assoc($sql);
                $creations[$compteur2] = new objectToSale($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"]);
                $compteur2 = $compteur2 + 1;
            }
        } else if ($categ == "flashsales") {
            $sql = mysqli_query($succes, $sql = "SELECT * FROM `flashsales` WHERE 1");
            $row = mysqli_num_rows($sql);
            while ($row > $compteur3) {
                $result = mysqli_fetch_assoc($sql);
                $creations[$compteur2+$compteur3] = new flash($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"], $result["discount"], $result["endingTime"]);
                $compteur3 = $compteur3 + 1;
            }
            $compteur2 = $compteur2 + $compteur3;
        }
        else if ($categ == "bestoffers") {
            $sql = mysqli_query($succes, $sql = "SELECT * FROM `bestoffers` WHERE `status` != 'complete'");
            $row = mysqli_num_rows($sql);
            while ($row > $compteur4) {
                $result = mysqli_fetch_assoc($sql);
                $creations[$compteur2+$compteur4] = new bestoffer($result["category"], $result["brand"], $result["model"], $result["capacity"], $result["size"], $result["price"], $result["picture"], $result["description"], $result["id"], $result["sellerID"]);
                $compteur4 = $compteur4 + 1;
            }
            $compteur2 = $compteur2 + $compteur4;
        }
    }
}
mysqli_close($succes);
if (isset($_POST["bidMore"]) && $_POST["bidMore"]) {
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }
    $id = $_GET['Id'];
    $newbid = $_POST["bid"];
    $bestbidder = $_SESSION["user"]->getFirstname() . " " . $_SESSION["user"]->getLastname();
    $sql = "UPDATE `auctions` SET `currentBid`= $newbid,`bestBidder`= '$bestbidder'  WHERE `id` LIKE $id";
    if ($link->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $link->error;
    }
    $link->close();
    header("Refresh:0");
}
if (isset($_POST["negotiate"]) && $_POST["negotiate"]) {
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }
    $id = $_GET['Id'];
    $negPrice = $_POST["negotiateInput"];
    $negotiatorId = $_SESSION["user"]->getId();
    $sellerId = $_SESSION["object"]->getSellerId();
    $startingPrice = $_SESSION["object"]->getPrice();
    $sql = "INSERT INTO `offersonbestoffers`(`id`, `sellerID`, `buyerID`, `offerID`, `startingprice`, `sellernego`, `buyernego`, `attemptsleft`) VALUES (NULL,$sellerId,$negotiatorId,$id, $startingPrice,0,$negPrice,5)";
    if ($link->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $link->error;
    }
    $link->close();
    header("Refresh:0");
}
if (isset($_POST["buyNow"]) && $_POST["buyNow"]) {
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }
    $_SESSION["BuyNowObject"] = true;
    $_SESSION["cartObjectBuffer"] = $_SESSION["cartObjects"];
    $_SESSION["nbObjectsBuffer"] = $_SESSION["nbObjects"];
    $_SESSION["nbObjects"] = 1;
    $_SESSION["totalPriceBuffer"] = $_SESSION["totalPrice"];
    $_SESSION["totalPrice"] = $_SESSION["object"]->getPrice();
    $_SESSION["cartObjectBuyNow"][0] = $_SESSION["object"];
    $_SESSION["cartObjects"] = $_SESSION["cartObjectBuyNow"];
    header("location: recapAdress.php");
    exit;
}
?>
<html>

<head>
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
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
    <style>
        <?php include "../assets/selectedObject.css" ?><?php include "../assets/zoom.css"; ?><?php include "../assets/mainPage.css" ?>
    </style>
    <title>Yourmarket</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script>
        function logOut() {
            $.post("logOut.php", function() {});
            window.location.reload();
        }

        function viewProfile() {
            window.location.replace("myProfile.php");
        }

        function addToCart() {
            $.post("addToCart.php", function(data) {
                const tl = new TimelineMax();
                form = document.querySelector("#my_basket_popup");

                setTimeout(function() {
                    form.style.display = "flex";
                    tl.fromTo(form, 1, {
                        opacity: "0",
                        y: "-30"
                    }, {
                        opacity: "1",
                        y: "10"
                    }, "0")
                }, 500);
                setTimeout(function() {
                    tl.fromTo(form, 1, {
                        opacity: "1",
                        y: "10"
                    }, {
                        opacity: "0",
                        y: "-30"
                    }, "1");
                }, 3500);
                setTimeout(function() {
                    window.location.reload();
                }, 4500);
            });
            if (document.getElementById("quantity") != null) {
                for (let i = 0; i < document.getElementById("quantity").value - 1; i++)
                    $.post("addToCart.php", function(data) {});
            }
        }

        function addQuantity() {
            if (isNaN(document.getElementById("quantity").value)) {
                document.getElementById("quantity").value = 1;
            } else
                document.getElementById("quantity").value++;
        }

        function removeQuantity() {
            if (isNaN(document.getElementById("quantity").value)) {
                document.getElementById("quantity").value = 1;
            } else
            if (document.getElementById("quantity").value > 1)
                document.getElementById("quantity").value--;
        }
    </script>
</head>

<body>
    <section>
        <div class="showObject">
            <div class="objectToShow">
                <div class="imagePart">
                    <img class="detailedImage" id="mainImg" src='<?php echo $_SESSION["object"]->getPicture() ?>' alt="">
                    <div id="myModal" class="modal" style="     display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 99; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: -50;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */">
                        <img class="modal-content" id="img01">
                    </div>
                    <div class="otherImages">
                        <img id="img1" src='<?php echo $images[0] ?>' alt="no more image">
                        <img id="img2" src='<?php echo $images[1] ?>' alt="no more image">
                        <img id="img3" src='<?php echo $images[2] ?>' alt="no more image">
                    </div>
                </div>
                <?php if ($_GET['category'] == "auctions") { ?>
                    <div class="descriptionPart">
                        <h1><?php echo $_SESSION["object"]->getModel();
                            $_SESSION["priceToAdd"] = $_SESSION["object"]->getPrice()  ?></h1>
                        <h3>brand : <?php echo $_SESSION["object"]->getBrand() ?></h3>
                        <h2>Current bid : <span style="color:red"><?php echo $_SESSION["object"]->getCurrentBid() ?>£</span></h2>
                        <h3>Best bidder : <?php echo $_SESSION["object"]->getBestBidder() ?></h3>
                        <h3 style="color:red">Finishes on : <?php echo $_SESSION["object"]->getEndingTime() ?> at 23:59 (UK time)</h3>
                        <?php if (getDiffDates($_SESSION["object"]->getEndingTime()) >= 0) { ?>
                            <h3><?php echo getDiffDates($_SESSION["object"]->getEndingTime()) ?></h3>
                            <div class="bid" method="post">
                                <label for="bid">Bid now !</label>
                                <form action="" method="post">
                                    <input type="number" name="bid" id="bidIn" placeholder="example : <?php echo $_SESSION["object"]->getCurrentBid() + 1 ?> £ " min='<?php echo $_SESSION["object"]->getCurrentBid() + 1 ?>'>
                                    <input disabled type="submit" name="bidMore" value="bid now" id="bid">
                                </form>
                            </div>
                        <?php } else { ?>
                            <h3>This auction is finished.</h3>
                        <?php } ?>
                    </div>
                <?php } else if ($_GET['category'] == "flashsales") { ?>
                    <div class="descriptionPart">
                        <h1 style="color:red">Flash sale !</h1>
                        <div style="display:flex; flex-direction:comumn; align-items:center; justify-content:center; background-color:red;color:white; border-radius:50%; width:120px; height:120px;">
                            <h1>-<?php echo $_SESSION["object"]->getDiscount() ?>%</h1>
                        </div>
                        <h1><?php echo $_SESSION["object"]->getModel();
                            $_SESSION["priceToAdd"] = $_SESSION["object"]->getPrice()  ?></h1>
                        <h3>brand : <?php echo $_SESSION["object"]->getBrand() ?></h3>
                        <h3>old price : <strike><?php echo $_SESSION["object"]->getPrice() ?>£</strike> </h3>
                        <h2>new price : <span style="color:red; border: 2px solid red; padding:10px; border-radius:10px"><?php echo ($_SESSION["object"]->getPrice() - $_SESSION["object"]->getPrice() * ($_SESSION["object"]->getDiscount() / 100)) ?>£</span></h2>
                        <h3 style="color:red">Finishes on : <?php echo $_SESSION["object"]->getEndingTime() ?> at 23:59 (UK time)</h3>
                        <h3><?php echo getDiffDates($_SESSION["object"]->getEndingTime()) ?></h3>
                        <div class="bid" method="post">
                            <h3>Only 1 item left.</h3>
                            <form action="" method="post">
                                <button id="addCart" onclick="addToCart()">Add to cart</button>
                            </form>
                        </div>
                    </div>
                <?php } else if ($_GET['category'] == "bestoffers") { ?>
                    <div class="descriptionPart">
                        <h1><?php echo $_SESSION["object"]->getModel();
                            $_SESSION["priceToAdd"] = $_SESSION["object"]->getPrice()  ?></h1>
                        <img id="grade" src="../images/stars.png" alt="">
                        <h2>Starting price : <?php echo $_SESSION["object"]->getPrice() ?> £</h2>
                        <h3>brand : <?php echo $_SESSION["object"]->getBrand() ?></h3>
                        <h4>sold by : <span style="color:red"><?php echo $sellerUser ?></span></h4>
                        <div class="bid" method="post">
                            <label for="bid">Negotiate now !</label>
                            <form action="" method="post">
                                <?php if (isset($_SESSION["user"]) && $_SESSION["object"]->getSellerId() == $_SESSION["user"]->getId()) { ?>
                                    <h2>You are selling this item. <br> Cannot negotiate it.</h2>
                                <?php } else { ?>
                                    <input type="number" name="negotiateInput" id="bidIn" placeholder="example : <?php echo round($_SESSION["object"]->getPrice() - $_SESSION["object"]->getPrice() * 0.4) ?> £ " max='<?php echo $_SESSION["object"]->getPrice() - 1 ?>'>
                                    <input disabled type="submit" name="negotiate" value="NEGOTIATE" id="bid">
                                <?php } ?>
                            </form>
                        </div>
                        <br>
                    </div>
                <?php } else { ?>
                    <div class="descriptionPart">
                        <h1><?php echo $_SESSION["object"]->getModel();
                            $_SESSION["priceToAdd"] = $_SESSION["object"]->getPrice()  ?></h1>
                        <img id="grade" src="../images/stars.png" alt="">
                        <h3>brand : <?php echo $_SESSION["object"]->getBrand() ?></h3>
                        <h4>price (before tax): <span style="color:red"><?php echo $_SESSION["object"]->getPrice() ?>£</span></h4>
                        <h5>(shipping cost: <?php echo round(($_SESSION["object"]->getPrice() * 1.5 / 100), 2); ?> £) </h5>
                        <div class="quantity">
                            <h5>Availability : <span style="color:green">in stock</span></h5>
                            <p>Quantity : <button onclick='removeQuantity()' id='minus' style="width:30px;height:30px;">-</button><input id="quantity" name="quantity" style="width:30px;height:30px; text-align: center;" value="1"><button onclick='addQuantity()' id="plus" style="width:30px; height:30px;">+</button></p>
                        </div>
                        <button id="addCart" onclick="addToCart()">Add to cart</button>
                        <form action="" method="post">
                            <input type="submit" name="buyNow" id="buyNow" value="buy now !">
                        </form>
                        <br>
                        <span>or</span>
                        <div class="bid">
                            <label for="bid">Bid now !</label>
                            <input style="margin-top:15px" disabled type="text" name="bid" placeholder="Cannot bid on this item.">
                        </div>
                    </div>
                <?php } ?>
                <div class="guaratee">
                    <div class="title"><img src="../images/satisfaction.png" alt="">
                        <h1>Satisfied or Refunded !</h1><br>
                    </div>
                    <p>For any purchase made on Yourmarket, the “Satisfied or Refunded” guarantee is offered to you! <br><br>
                        <strong>We will refund you if your item arrives broken or does not meet your expectations:</strong> <br><br>
                    <ul>
                        <li>We cover the cost of returning your item to our services.</li>
                        <li> The item must be returned complete in its original packaging for new items.</li>
                        <li>On receipt, the item will be examined by our teams and it will be refunded to you by transfer to your bank account. </li>
                    </ul><br>
                    <p><strong>If your package is lost:</strong> <br></p><br>
                    <p>The package must be indicated as lost or damaged by the carrier.
                        We will then refund your purchase by transfer to your bank account.
                        The Yourmarket Satisfied or Refunded guarantee is valid for 30 days after your purchase and applies to all new or second-hand items paid for by credit card / Yourmarket on which this mention appears.</p>
                </div>
            </div>
            <br>
            <div class="spacer"></div>
            <div class="descriptionPart2">
                <h1>Description</h1>
                <?php echo $_SESSION["object"]->getDescription() ?>
            </div>
            <div class="spacer"></div>
            <div class="descriptionPart3">
                <h1>Caracteristics</h1>
                <p>Brand : <?php echo $_SESSION["object"]->getBrand() ?></p>
                <p>Model : <?php echo $_SESSION["object"]->getModel() ?></p>
                <p>Capacity : <?php echo $_SESSION["object"]->getCapacity() ?></p>
                <p>Size : <?php echo $_SESSION["object"]->getSize() ?></p>
            </div>
            <div class="spacer"></div>
            <div class="interestingProducts">
                <h1>These products may also interest you</h1>
                <div class="interestingObjects">
                    <?php for ($i = 0; $i < $compteur2; $i++) {
                        if ($creations[$i]->getProductCategory() == "flashsales") { ?>
                            <div class="InterestingObject">
                            <?php if ($_SESSION["object"]->getProductCategory()!="phones"){ ?>
                                <div class="iconDiscount" style="display:flex;flex-direction:columns;align-items:center;justify-content:center;position:relative;transform:translate(400%,120%);width:15px; height:30px;">
                                    <h3>-<?php echo $creations[$i]->getDiscount() ?>%</h3>
                                </div>
                                <?php } else { ?>
                                    <div class="iconDiscount" style="display:flex;flex-direction:columns;align-items:center;justify-content:center;position:relative;transform:translate(270%,90%);width:15px; height:30px;">
                                    <h3>-<?php echo $creations[$i]->getDiscount() ?>%</h3>
                                </div>
                                <?php } ?>
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
                                            <td style='color:red'><strong><?php echo getDiffDates($creations[$i]->getEndingTime()) ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="InterestingObject">
                                <?php if ($creations[$i]->getProductCategory() == "auctions") { ?>
                                    <img style="position:relative;transform:translate(450%,30%);width:40px; height:40px;" class="iconpng" src="../images/Auction-label.png" alt="">
                                <?php } else if ($creations[$i]->getProductCategory() == "bestoffers") { ?>
                                    <img style="position:relative;transform:translateX(300%); width:40px; height:40px" class="iconpng" src="https://images-eu.ssl-images-amazon.com/images/I/511dTxcqHIL.png" alt="">
                                <?php } else {  ?>
                                    <img style="position:relative;transform:translate(450%,30%);width:40px; height:40px;" class="iconpng" src="../images/buy_now.png" alt="">
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
                    ?>
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
    <a id="btnToTop" href="#top"><img src="https://icon-library.com/images/back-to-top-icon-png/back-to-top-icon-png-19.jpg" alt=""></a>
    <div id="my_basket_popup">
        <p> A new item has been added to your basket.</p>
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
            <strong style="color:white;margin-left:40px;">© YOURMARKET. ALL RIGHTS RESERVED Apolline Cherrey & Eliott Morcillo 2021.</strong>
        </div>
    </footer>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js" integrity="sha512-8Wy4KH0O+AuzjMm1w5QfZ5j5/y8Q/kcUktK9mPUVaUoBvh3QPUZB822W/vy7ULqri3yR8daH3F58+Y8Z08qzeg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TimelineMax.min.js" integrity="sha512-lJDBw/vKlGO8aIZB8/6CY4lV+EMAL3qzViHid6wXjH/uDrqUl+uvfCROHXAEL0T/bgdAQHSuE68vRlcFHUdrUw==" crossorigin="anonymous"></script>
<script src="../javascript/animeHeader.js"></script>
<script>
    <?php include "../javascript/navApp.js"; ?>
</script>
<script>
    <?php include "../javascript/selectedObject.js"; ?>
</script>
<script>
    <?php include "../javascript/zoom.js"; ?>
</script>
<script>
    <?php include "../javascript/mainPage.js" ?>
</script>

</html>