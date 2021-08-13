<?php
// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: mainPage.php");
    exit;
}
$_SESSION["loggedin-as-admin"] = false;
$_SESSION["loggedin"] = false;
$_SESSION["firstname"] = '';
$_SESSION["lastname"] = '';
$_SESSION["message"] = '';
// will later be the item selected 
$_SESSION["object"] = null;
$_SESSION["objectID"] = 0;
$_SESSION["objectCATEG"] = "";
$_SESSION["cart"] = array();
$_SESSION["cart2"] = array();
$_SESSION["cartObjects"] = array();
$_SESSION["cartObjectBuffer"] = array();
$_SESSION["cartObjectBuyNow"] = array();
$_SESSION["BuyNowObject"] = false;
$_SESSION["nbObjects"] = 0;
$_SESSION["totalPrice"] = 0;
$_SESSION["priceToAdd"] = 0;
$_SESSION["nbObjectsBuffer"] = 0;
$_SESSION["totalPriceBuffer"] = 0;
$_SESSION["id"] = 0;
$_SESSION["user"] = null;
$_SESSION["deliveryAdress"] = null;
$_SESSION["selectedCard"] = null;
$isbuyer = false;
$id = 0;
// Include config file
require_once "config.php";
require "user.php";
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if (isset($_POST["login"]) && $_POST["login"]) {

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, firstname, lastname, email, password, isbuyer  FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    echo "Account found.";
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $firstname, $lastname, $email, $hashed_password, $isbuyer);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["firstname"] = $firstname;
                            $_SESSION["lastname"] = $lastname;
                            $_SESSION["email"] = $email;
                            if ($email == "eliott.morcillo@gmail.com" or $email == "apolline.cherrey@gmail.com") {
                                //if admin
                                $_SESSION["loggedin-as-admin"] = true;
                            }
                            // actual user is session user
                            $actual_user = new user($id, $firstname, $lastname, $email, $isbuyer);

                            $_SESSION["user"] = $actual_user;
                            // Redirect user to welcome page
                            header("location: mainPage.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
if (isset($_POST["newPass"]) && $_POST["newPass"]) {
    $emailPass = $_POST["emailPass"];
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, firstname, lastname, email, password, isbuyer  FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $emailPass);
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    echo "An email has been sent to $emailPass with a new password.";
                    $passUnHashed = rand(10000, 99999);
                    $newpass = password_hash($passUnHashed, PASSWORD_DEFAULT);
                    $object = "Password modified";
                    $content = "Your password has been modified. Here is the new one : $passUnHashed.
            This email is automatic. Please do no answer.";
                    mail($emailPass, $object, $content, $header);
                    $sql = "UPDATE `users` SET `password`='$newpass' WHERE `email` LIKE '$emailPass'";
                    if ($link->query($sql) === TRUE) {
                        header("refresh: 0");
                    }
                }
            }
        }
    }
    header("refresh: 0");
    mysqli_close($link);
}
?>

<html>

<head>
    <style>
        <?php include "myAdresses.css" ?><?php include "../assets/formStyle.css" ?>
    </style>
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
    <link rel="icon" href="../images/icon.png">
    <title>Log In</title>
</head>

<body>
    <div id="barba-wrapper">
        <div class="barba-container">
            <div class="sign-up-form">
                <h1>Log In</h1>
                <form action="" method="post">
                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <input type="email" name="email" class="input-box" placeholder="Your Email" value="<?php echo $email; ?>">
                        <span style="color:red" ; class="help-block"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="password" class="input-box" placeholder="Your Password" value="<?php echo $password; ?>">
                        <span style="color:red" class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input name="login" type="submit" class="btn-primary" value="Log In">
                    </div>
                    <p>Don't have an account ?<a href="CreateAccount.php">Create one.</a></p>
                    <p>Forgot your password ?<a href="" onclick="openModalPassword();return false;">Click here.</a></p>
            </div>
            </form>
        </div>
    </div>
    </div>
    <div id="myModalPassword" class="modal">
        <!-- Modal content -->
        <div class="modal-content" id="modalcontentPassword">
            <span id="spanID" class="close">&times;</span>
            <form action="" method="post">
                <h2>Forgot pasword</h2>
                <label for="emailPass">Enter your email adress :</label>
                <input required type="email" name="emailPass" id="emailPass">
                <p>If your account is recognized, we'll send you a new password via your email adress. If your emmail doesn't match with any of our accounts, you'll never know.</p>
                <input type="submit" class="btn-primary" name="newPass" id="newPass" value="Send new password">
            </form>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js" integrity="sha512-8Wy4KH0O+AuzjMm1w5QfZ5j5/y8Q/kcUktK9mPUVaUoBvh3QPUZB822W/vy7ULqri3yR8daH3F58+Y8Z08qzeg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TimelineMax.min.js" integrity="sha512-lJDBw/vKlGO8aIZB8/6CY4lV+EMAL3qzViHid6wXjH/uDrqUl+uvfCROHXAEL0T/bgdAQHSuE68vRlcFHUdrUw==" crossorigin="anonymous"></script>
<script src="../javascript/form.js"></script>
<script>
    function openModalPassword() {
        document.getElementById("myModalPassword").style.display = "block";
        return false;
    }
    var span = document.getElementById("spanID");
    if (span != null) {
        span.onclick = function() {
            document.getElementById("myModalPassword").style.display = "none";
        };
        window.onclick = function(event) {
            if (event.target == modal) {
                alert("window")
                document.getElementById("myModalPassword").style.display = "none";
            }
        };
    }
</script>

</html>