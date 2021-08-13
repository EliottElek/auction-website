<?php
// Include config file
require_once "config.php";
require "user.php";
// Define variables and initialize with empty values
$firstname = $lastname = $email = $password = $confirm_password = "";
$firstname_err = $lastname_err = $email_err = $password_err = $confirm_password_err = "";
$_SESSION["user"] = null;
$_SESSION["loggedin-as-admin"] = false; 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email,);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate firstname
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "Please enter a firstname.";
    } else {
        $firstname = trim($_POST["firstname"]);
    }
    // Validate lastname
    if (empty(trim($_POST["lastname"]))) {
        $lastname_err = "Please enter a lastname.";
    } else {
        $lastname = trim($_POST["lastname"]);
    }
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO `users`(`id`,`firstname`, `lastname`, `email`, `password`, `isbuyer`) VALUES (NULL,?,?,?,?,false)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_firstname, $param_lastname, $param_email, $param_password);
            session_start();
            // Store data in session variables
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $_SESSION["user"] = new user(0,$firstname, $lastname, $email, false);
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to createAccount2 page. On this page we will ask the user if he wants to be a buyer only or also a seller
                header("location: createAccount2.php");
            } else {
                echo "Something went wrong.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<html>

<head>
<style>
<?php include "../assets/formStyle.css"?>
</style>
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/glacial-indifference" type="text/css" />
    <title>Create Account</title>
</head>

<body>
    <div id="barba-wrapper">
        <div class="barba-container">
            <div id="createACC" class="sign-up-form">
                <h1>Create Account (1/2)</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                        <input type="firstname" name="firstname" class="input-box" placeholder="Your Firstname" value="<?php echo $firstname; ?>">
                        <span style="color:red" class="help-block"><?php echo $firstname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                        <input type="lastname" name="lastname" class="input-box" placeholder="Your Lastname" value="<?php echo $lastname; ?>">
                        <span style="color:red" class="help-block"><?php echo $lastname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <input type="email" name="email" class="input-box" placeholder="Your Email" value="<?php echo $email; ?>">
                        <span style="color:red" class="help-block"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="password" class="input-box" placeholder="Your Password" value="<?php echo $password; ?>">
                        <span style="color:red" class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="confirm_password" class="input-box" placeholder="Confirm Password" value="<?php echo $confirm_password; ?>">
                        <span style="color:red" class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Create Account">
                    </div>
                    <p>Already have an account ?<a href="login.php">Log In.</a></p>
                </form>
                <div class="social-icons">
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js" integrity="sha512-8Wy4KH0O+AuzjMm1w5QfZ5j5/y8Q/kcUktK9mPUVaUoBvh3QPUZB822W/vy7ULqri3yR8daH3F58+Y8Z08qzeg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TimelineMax.min.js" integrity="sha512-lJDBw/vKlGO8aIZB8/6CY4lV+EMAL3qzViHid6wXjH/uDrqUl+uvfCROHXAEL0T/bgdAQHSuE68vRlcFHUdrUw==" crossorigin="anonymous"></script>
<script src="../javascript/form.js"></script>

</html>

</html>