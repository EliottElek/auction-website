<?php
// Initialize the session
require_once "config.php";
require "user.php";
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: mainPage.php");
    exit;
}
$_SESSION["id"] = 0;
$_SESSION["sellerornot"] = false;
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["choice"] == "buyonly") {
        $_SESSION["sellerornot"] = "0";
    } else {
        $_SESSION["sellerornot"] = true;
    }
    $email = $_SESSION["user"]->getEmail();
    $sql = mysqli_query($succes, $sql = "SELECT `id` FROM `users` WHERE `email` like '$email'");
    //we get the ID
    $row = mysqli_num_rows($sql);
    $compteur = 0;
    while ($row > $compteur) {
        $result = mysqli_fetch_assoc($sql);
        $id = $result["id"];
        $compteur = $compteur + 1;
    }
    $_SESSION["user"]->setBuyer($_SESSION["sellerornot"]);
    //we modify it in the database
    $sql = "UPDATE `users` SET `isbuyer`=" . $_SESSION["sellerornot"] . " WHERE `email` like '" . $_SESSION["user"]->getEmail() . "'";
    $sql2 = "INSERT INTO `sellerprofiles`(`id`, `sellerID`, `backgroundindex`) VALUES (NULL,$id,2)";
    if (mysqli_query($link, $sql) && mysqli_query($link, $sql2)) {
        $_SESSION["loggedin"] = true;
        //we create a new user
        $actual_user = new user($id, $_SESSION["user"]->getFirstname(),  $_SESSION["user"]->getLastname(),  $_SESSION["user"]->getEmail(),  $_SESSION["user"]->isBuyer());
        //and new user is the session user
        $_SESSION["user"] = $actual_user;
        header("location: mainPage.php");
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($link);
    }
    // Close connection
    mysqli_close($link);
}

?>

<html>
<style>
    <?php include "formStyle.css" ?>
</style>

<head>
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
    <link rel="icon" href="icon.png">
    <title>Type of account</title>
</head>

<body>
    <div id="barba-wrapper">
        <div class="barba-container">
            <div class="sign-up-form">
                <h1>Type of account (2/2)</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h3>What type of action do you want to perform on our website ?</h3>
                    <div class="actionchoice">
                        <div>
                            <input type="radio" id="buyonly" name="choice" value="buyonly">
                            <label for="coding">Buy only</label>
                        </div>
                        <div>
                            <input type="radio" id="buyandsell" name="choice" value="buyandsell">
                            <label for="music">Buy and sell</label>
                        </div>
                    </div>
                    <input type="checkbox" name="terms" id="terms">
                    <label for="terms">By creating an account, you agree to our <a href="termsAndConditions.php">terms and conditions</a>.</label>
                    <input disabled class="btn btn-primary" type="submit" id="sub" value="continue">
                </form>
            </div>
        </div>
    </div>
</body>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js" integrity="sha512-8Wy4KH0O+AuzjMm1w5QfZ5j5/y8Q/kcUktK9mPUVaUoBvh3QPUZB822W/vy7ULqri3yR8daH3F58+Y8Z08qzeg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TimelineMax.min.js" integrity="sha512-lJDBw/vKlGO8aIZB8/6CY4lV+EMAL3qzViHid6wXjH/uDrqUl+uvfCROHXAEL0T/bgdAQHSuE68vRlcFHUdrUw==" crossorigin="anonymous"></script>
<script src="../javascript/form.js"></script>
<script>
    $(function() {
        ischecked = false;
        $("#buyonly").click(function() {
            if ($(this).is(':checked')) {
                ischecked = true;
            }
        });
        $("#buyandsell").click(function() {
            if ($(this).is(':checked')) {
                ischecked = true;
            }
        });
        $("#terms").click(function() {
            if ($(this).is(':checked') && ischecked) {
                $("#sub").prop('disabled', false);
            }
        });
    });
</script>

</html>