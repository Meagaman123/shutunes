<?php
session_start();
//checks to see if there os a username stored in the session autoglobal
if((!isset($_SESSION['username']))){
  // Redirects the user to the index php file
   header("Location:index.php");
} ?>
<html>
<head>
  <link rel="stylesheet" href="style.css">
    <title> Welcome </title>
</head>


</html>
<?php
// Echoes the logged in usernae and also the account type, pulling information from both accType and username session variables
echo "Username: " . "<strong>" . $_SESSION['username'] . "</strong>" . " (Type: " . $_SESSION['accType'] . ") ";
echo "</div>" . "<br>";

$username = $_SESSION['username'];
//uses a GET statement to log out user. Clears the session variable, displays a javascript alert and changes the web page
if(isset($_GET['lo'])){
  echo '<script language="javascript">';
  echo 'alert("You have been logged out successfully.")';
  echo '</script>';
  echo "<script>window.location = 'index.php';</script>";
  session_destroy();
}
// Code to check admin level permissions via a GET statement
if(isset($_GET['am'])){
  if($_SESSION['accType'] == "admin"){
    // Redirects to the admin page
    echo "<script language='javascript'>window.location = 'admin.php';</script>";
    echo "<script>window.location = 'admin.php';</script>";
  }
  else{
    echo '<script language="javascript">';
    echo 'alert("ERROR! Please Log In Using an Admin Account.")';
    echo '</script>';
    echo "<script language='javascript'>window.location = 'artists.php';</script>";
    echo "<script>window.location = 'artists.php';</script>";
  }
}
// echoes the SHU logo
echo '<div class="logo"><img src="img/SHULogo.jpg"></div><br>';
 ?>
<html>
  <body>
    <body class="news">
  <header>
    <div class="nav" style="font-weight:bold;">
      <ul>
        <li class="artists"><a href="http://shutunes.co.uk/artists.php">Artists</a></li>
        <li class="tracks"><a href="http://shutunes.co.uk/tracks.php">Tracks</a></li>
        <li class="playlists"><a href="http://shutunes.co.uk/playlists.php">Playlists</a></li>
        <li class="tickets"><a href="http://shutunes.co.uk/tickets.php">Tickets</a></li>
        <li id="adminMenu" class="adminMenu"><a href="http://shutunes.co.uk/artists.php?am=">Admin</a></li>
        <li class="logOut" ><a href="http://shutunes.co.uk/home.php?lo=">Log Out</a></li>
      </ul>
    </div>
  </header>
