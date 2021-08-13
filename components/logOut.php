<?php
session_start();
//session user becomes null, we redirect to main page
$_SESSION["loggedin"] = false;
$_SESSION["user"] = null;
header("location: mainPage.php");
?>