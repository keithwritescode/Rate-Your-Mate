<?php
// Echo any submission
echo $_POST['message'] . '<br />';
// error_reporting(-1);
include ("includes/login.php");
include ("includes/loginMenu.php");

$_SESSION['roster'] = array(
    array("screenname" => "kmreynolds1", "name" => "Kris Reynolds", "id" => 1),
    array("screenname" => "bpbielicki", "name" => "Ben Bielicki", "id" => 2),
    array("screenname" => "mdecota", "name" => "Michael Decota", "id" => 3),
    array("screenname" => "jdennett", "name" => "Jason Dennett", "id" => 4),
    array("screenname" => "tferm", "name" => "Tyler Ferm", "id" => 5),
    array("screenname" => "khallock", "name" => "Keith Hallock", "id" => 6),
    array("screenname" => "rameden", "name" => "Ryley Ameden", "id" => 7),
    array("screenname" => "cbecker", "name" => "Chris Becker", "id" => 8),
    array("screenname" => "jcormier", "name" => "Joe Cormier", "id" => 9),
    array("screenname" => "cstoner", "name" => "Cara Stoner", "id" => 10)
)
 
?>



