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
?>
<html>

<head>
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
    <style>
        <?php include "../assets/contactUs.css" ?><?php include "../assets/mainPage.css" ?>
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
<section id = "sectionTerm">
       <h1>Our terms and conditions</h1>
       <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tincidunt augue a tortor fermentum fringilla. Suspendisse lobortis nisl sit amet ligula scelerisque elementum. Maecenas ultrices turpis eu ante molestie, in ultrices leo fringilla. Sed at risus nec nisi euismod tempor. Morbi volutpat tempor lectus eu dignissim. Quisque eget lectus ut felis varius tempor. Morbi egestas ultricies nisl nec dapibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam sit amet ultrices est. Sed egestas nulla sem, a consectetur tortor convallis et.

Vestibulum egestas rhoncus turpis quis fermentum. Praesent eu ipsum luctus, bibendum lorem ac, elementum neque. Donec ultricies lorem sed orci porttitor, quis congue enim vehicula. Aliquam commodo sapien nec consequat lacinia. Phasellus at mi vitae augue volutpat rutrum. Nulla at faucibus lacus. Nam blandit convallis orci quis dictum.

Morbi hendrerit ultricies vulputate. Sed ultrices dolor at ipsum malesuada feugiat. Morbi cursus lorem ac blandit ultrices. Mauris eget mauris lacus. Pellentesque pharetra augue feugiat, condimentum enim eget, vestibulum velit. Morbi efficitur lacus eu magna tempus gravida. Quisque dignissim lacus eu hendrerit tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod dui malesuada facilisis condimentum. Duis eros purus, tincidunt suscipit urna sit amet, molestie varius turpis.

Aliquam tempor molestie posuere. Quisque cursus tellus sem, in volutpat metus iaculis eu. Sed blandit bibendum neque. Fusce scelerisque malesuada odio vel fermentum. Pellentesque eget sem auctor, volutpat quam nec, sagittis libero. Vivamus eget accumsan erat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus porta elit sed placerat tempus.

Pellentesque sed varius diam. Ut non tristique augue, a fermentum leo. Fusce vitae ligula est. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean at efficitur ex. Nunc finibus aliquet augue, eget fermentum erat sagittis a. Praesent viverra mi at imperdiet ultrices. Donec varius sit amet lectus sed fringilla. Quisque at maximus magna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In iaculis tempus erat, ac tincidunt mi euismod fringilla. Quisque congue nulla quis urna posuere, eget convallis ante cursus. Mauris quis nisl vitae mauris vestibulum accumsan ac in nisl. Integer gravida dolor nisl, eu aliquet magna facilisis quis. Quisque at facilisis nulla.

Quisque ex est, posuere sollicitudin lacus quis, dapibus tempus nisi. Morbi porttitor nunc rhoncus mi porta vulputate. Duis vitae massa nec ligula vulputate viverra. Aliquam non ipsum iaculis, consectetur tortor et, rhoncus lectus. Nullam fermentum nunc id tellus posuere, in congue nisi feugiat. Praesent eget fringilla sapien, sed malesuada elit. Nam eu metus eget eros scelerisque varius quis eget lorem. Donec lacinia nec ex id fringilla. Nam hendrerit massa sed purus hendrerit, vel tempus ipsum vehicula.

Aliquam lobortis eget ligula malesuada aliquet. Nunc nec porttitor erat. Curabitur imperdiet nisi vitae commodo viverra. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque facilisis dapibus fringilla. Sed sem metus, tempus quis mauris et, finibus egestas metus. Proin et neque sem. Donec non ante pulvinar, facilisis justo eget, consectetur velit. Etiam lorem justo, maximus a aliquet a, porttitor eget libero. Vivamus diam nibh, ullamcorper a nibh eget, consectetur tempus ligula. Curabitur aliquam tincidunt mauris sed vestibulum. Ut convallis varius sem a pellentesque. Mauris molestie consequat ligula, et placerat urna suscipit sed. Suspendisse sit amet faucibus sapien. Proin id rutrum diam.

Etiam et massa eu leo convallis posuere in in mi. Donec tristique congue metus, vitae sagittis libero sodales sit amet. Pellentesque ex ex, iaculis at venenatis nec, porttitor sit amet sem. Mauris ac bibendum urna, eu scelerisque lectus. Integer gravida est at varius mollis. Nullam id tortor ut ipsum consectetur mattis. Ut luctus nisi nibh, non sodales nunc ultrices a. Curabitur ut quam mi. Sed et pharetra augue, vitae porttitor arcu. Proin cursus nisl mauris, quis venenatis nunc bibendum et. Nunc sagittis risus ac arcu aliquet, at elementum dui laoreet. Integer porttitor varius tortor, nec bibendum risus cursus nec. Vestibulum elementum dolor elit, vel vehicula magna eleifend a. Mauris accumsan tortor vel magna ultrices, et vestibulum elit tincidunt. Aliquam non turpis non dolor egestas feugiat. Mauris quis scelerisque nisi, eu tempus augue.

Duis a nunc tincidunt, placerat ipsum congue, venenatis tortor. Praesent a eleifend purus, non scelerisque est. Aliquam in ipsum eu nisl scelerisque fringilla. Quisque gravida porta enim sit amet finibus. Fusce quis nunc nisl. Suspendisse eu feugiat magna. Aliquam hendrerit tincidunt felis, eget facilisis sem porttitor ac. Vivamus viverra, nibh a aliquet scelerisque, justo metus placerat est, at vestibulum lacus nisi a nisl. Quisque quam tellus, pharetra sed odio sit amet, varius auctor leo. Aenean porta cursus libero, id porta dolor suscipit sit amet. Vivamus ut nulla tristique mauris eleifend elementum. Nullam magna nisi, consectetur elementum lacus in, lacinia viverra massa. Etiam consequat tristique metus non ultricies. Nullam rhoncus, leo vel tincidunt iaculis, leo ante venenatis mi, ac dapibus lacus quam eu libero. Duis ultrices ornare libero ac fringilla. Vestibulum metus felis, luctus at sapien tempor, tincidunt laoreet tortor.

Nunc sit amet mauris ac felis cursus semper. Donec est nisl, tristique eu felis egestas, volutpat dapibus dolor. Sed tempor augue tellus, nec fermentum urna ultrices et. Suspendisse semper orci vitae neque molestie, in finibus risus blandit. Sed vel porta massa. Phasellus id hendrerit mi, sed congue leo. Donec rutrum enim tellus, at dignissim magna fringilla at.

Nullam nec pharetra diam. Cras tristique nisl ligula. Donec mollis enim vitae leo porta, in tristique eros porttitor. Proin fermentum, nulla ac tempor condimentum, quam mauris congue purus, vitae viverra est eros at sem. Nullam lacus orci, ultricies nec tincidunt at, pharetra sit amet purus. Duis gravida nisl nec diam consectetur, at vehicula sem cursus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus eu rhoncus mauris. Cras sit amet velit sapien. Aliquam venenatis, ex eu maximus ultrices, ante libero egestas nisi, et condimentum magna ligula at tellus. Sed pulvinar, nisl vitae lacinia commodo, erat turpis ultricies dolor, in pharetra lectus nibh ut erat. Aliquam magna nisi, tincidunt sed rhoncus non, convallis ac dui. Fusce id ultrices elit, sed hendrerit elit. Sed ut enim placerat, tincidunt quam ultrices, congue purus.

Proin id sem tristique, ullamcorper elit sed, volutpat leo. Proin congue sapien id lorem vestibulum, non egestas est ornare. Curabitur aliquam sem nec nibh vestibulum consectetur. Cras et semper mi. In ut turpis magna. Morbi condimentum odio a ornare eleifend. Morbi quis faucibus libero, viverra ultricies felis. Pellentesque pellentesque dui a purus gravida, laoreet congue ex facilisis.

Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed eu mi ut lectus bibendum dictum. Ut lacus tortor, euismod ac fringilla pellentesque, laoreet eu odio. Praesent mollis, urna non aliquam auctor, est libero pharetra erat, vitae accumsan odio dui id enim. Nulla convallis tortor in fringilla scelerisque. Fusce a ligula a ante sagittis commodo ut convallis metus. Nullam facilisis consequat quam vitae euismod. Fusce blandit augue justo, nec feugiat dolor sodales ut. Nunc tincidunt consectetur cursus. Quisque volutpat elit non tincidunt consequat.

Mauris tempor eu libero ac tempor. Nam ac pretium nisl. Nam mattis id sem a feugiat. Morbi quam odio, ultricies vel dolor in, imperdiet bibendum erat. Nulla facilisi. Sed magna odio, vestibulum sit amet ipsum quis, consectetur gravida odio. Ut luctus tellus id nisi aliquam ultrices. Vestibulum at iaculis nulla. Cras ullamcorper eros nec mi sodales sollicitudin. Vestibulum vitae nunc quis eros tincidunt commodo. Sed pulvinar finibus nunc porttitor posuere. Mauris aliquam massa erat, eu pharetra nisi rhoncus nec. In ornare turpis et est semper faucibus. Aliquam erat volutpat.

Fusce ultrices iaculis ipsum, sit amet sollicitudin felis vehicula sit amet. Pellentesque gravida sem vitae malesuada porta. Vivamus facilisis tempor justo ut pharetra. Curabitur nec sem at sem gravida mollis. Sed a hendrerit ex, eget suscipit elit. Proin in maximus mauris. Nulla nec facilisis nunc, et varius dolor. Nullam augue diam, pellentesque sit amet ex sed, congue egestas leo. Quisque in turpis sodales, rutrum est ac, fringilla orci. Morbi vehicula laoreet dapibus. Integer accumsan ligula eu ipsum molestie, non egestas eros vulputate. Vivamus quis nibh libero. Donec convallis risus at metus rhoncus ornare. Curabitur venenatis turpis sed urna congue egestas. Phasellus pretium enim lacinia tempus lacinia.

Maecenas at egestas nulla. Morbi velit lorem, auctor eu justo ut, volutpat pulvinar ligula. Vivamus placerat tincidunt massa quis dapibus. Etiam ultrices arcu non ante ultrices, eu bibendum lectus sagittis. In hac habitasse platea dictumst. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer sed leo interdum, euismod turpis at, scelerisque arcu. Donec ex metus, varius eget consequat vel, elementum quis urna. Aliquam erat volutpat.

Vestibulum maximus sed tellus vitae ornare. Integer porttitor libero eget lacus cursus sodales. Donec ut sem eu lacus rhoncus molestie ac et nibh. Fusce finibus hendrerit augue, finibus lacinia odio commodo quis. Mauris tincidunt ut lacus in interdum. Vestibulum lobortis lacus erat. Cras vehicula quam sit amet elit euismod, id laoreet nisi sodales. Vestibulum semper metus non laoreet blandit. Proin commodo libero nunc, ac interdum ante cursus non. Nulla mattis enim vel ligula pharetra, pharetra placerat mi laoreet. Integer felis eros, vestibulum ut enim quis, tempor auctor elit. Fusce blandit, eros quis tempus aliquet, nisi orci ullamcorper ante, at bibendum enim est ac odio. Mauris a metus a risus dictum efficitur vestibulum id mauris. Suspendisse lobortis orci at ante pulvinar tincidunt. Praesent id turpis vel leo placerat sagittis.

Nulla in mattis nunc. Nam vestibulum ac massa non pulvinar. In dignissim, metus in auctor tincidunt, nibh enim cursus lorem, in varius lectus purus id nulla. Maecenas rhoncus, nisl quis semper laoreet, lectus risus vulputate sem, sed lacinia purus purus at justo. Sed tincidunt eget sapien vulputate mollis. Aenean vehicula blandit luctus. Etiam fermentum tempor ligula tincidunt egestas. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque molestie ultricies turpis, at congue massa consequat id. Integer ultrices, diam ut gravida mattis, ex orci elementum metus, sit amet gravida nibh mauris non neque. Praesent sed blandit dui. Suspendisse in metus at dui sodales tincidunt. Morbi et molestie arcu, vel elementum sem. Aliquam hendrerit lorem sem, non porta ex auctor id. Integer porta urna ut gravida euismod.

Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed fermentum enim vel elit facilisis dictum. Pellentesque pharetra dolor eget diam sodales, nec feugiat nisi gravida. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Aliquam erat volutpat. Suspendisse dolor turpis, maximus eu felis id, interdum pretium nunc. Fusce vitae nisl metus. Cras id augue et quam sodales venenatis. Praesent vitae neque malesuada, suscipit dolor nec, malesuada nibh. Nam sit amet nibh porta, iaculis diam et, molestie diam. Donec augue sapien, ullamcorper id molestie ac, iaculis sit amet metus. Nulla suscipit, dolor vulputate iaculis aliquam, tellus purus scelerisque elit, eu hendrerit justo mauris sit amet elit.

Sed est tortor, ullamcorper non leo sit amet, aliquet dapibus neque. Donec venenatis justo dictum dui tristique varius. Ut sit amet gravida diam, id varius elit. Sed nec justo id est iaculis faucibus. Morbi pharetra ut leo non euismod. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis ultricies arcu vitae lacus lacinia faucibus. Cras quis dignissim lacus. Etiam eget arcu et odio tristique euismod sed ut nunc. Praesent vehicula, lacus eu maximus viverra, elit neque sollicitudin massa, in rutrum libero nisi ac magna. Integer ornare nibh lorem, sed lacinia ante tempus id. Nulla luctus mattis feugiat. Etiam elit lectus, fermentum quis nibh sed, mollis condimentum libero.

Generated 20 paragraphs, 1907 words, 12831 bytes of Lorem Ipsum</p>
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

</html>