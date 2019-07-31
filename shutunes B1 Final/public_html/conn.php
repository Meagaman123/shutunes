<?php


function Connect()
{
 $dbhost = "10.169.0.164";
 $dbuser = "shutunes_admin";
 $dbpass = "DabOnHaterz12";
 $dbname = "shutunes_db";

 // Create connection
 $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($conn->connect_error);

 return $conn;
}

?>
