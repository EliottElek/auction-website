<?php
//config file; allows to connect to database
define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'elektra1');
define('DB_DATABASE', 'e-sales');
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$succes = mysqli_connect('127.0.0.1:3306', DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$_SESSION["succes"] = $succes;
$header = "MIME-Version: 1.0\r\n";
$header .= 'From:"Yourmarket.com"<support@yourmarket.com>' . "\n";
$header .= 'Content-Type:text/html; charset="utf-8"' . "\n";
$header .= 'Content-Transfer-Encoding: 8bit';

//function tgat returns a countdown from a date
function getDiffDates(string $date)
{
    date_default_timezone_set('Europe/London');

    $dateTime = strtotime($date);
    $timeLeft = $dateTime - time(); // == <seconds between the two times>
    $i_restantes = $timeLeft / 60;
    $H_restantes = $i_restantes / 60;
    $d_restants = $H_restantes / 24;
    
    
    $s_restantes = floor($timeLeft % 60); // seconds left
    $i_restantes = floor($i_restantes % 60); // minutes left
    $H_restantes = floor($H_restantes % 24); // hours left
    $d_restants = floor($d_restants); // Jours restants
    //==================
        $finalString = $d_restants . " days, " . $H_restantes . " hours, " . $i_restantes . "mins, ".$s_restantes." seconds left";
        //we return the string
    return $finalString;
}
