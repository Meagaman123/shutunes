<?php
//redirect user if session autoglobal not set
session_start();
if(!isset($_SESSION['username'])){
   header("Location:index.php");
} ?>
<html>
<head>
  <link rel="stylesheet" href="style.css">
    <title> Welcome </title>
</head>


</html>
<?php
//uses a GET statement to log out user. Clears the session variable, displays a javascript alert and changes the web  page
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
    echo "<script language='javascript'>window.location = 'admin.php';</script>";
    echo "<script>window.location = 'admin.php';</script>";
  }
  else{
    echo '<script language="javascript">';
    echo 'alert("ERROR! Please Log In Using an Admin Account.")';
    echo '</script>';
  }
}
// Code to welcome user and show time
echo '<div class="logo"><img src="SHULogo.jpg"></div><br>';
echo "<div class='dateAndUser'";
$currentTime = date("D M d, Y G:i a");
echo "<br>";
echo $currentTime . "<br>";
$time = date("H");
    $timezone = date("e");
    if ($time < "12") {
        $greeting = "Good Morning";
    } else
    if ($time >= "12" && $time < "17") {
        $greeting = "Good Afternoon";
    } else
    if ($time >= "17" && $time < "25") {
        $greeting = "Good Evening";
    }
    echo $greeting; echo "<br>" . "Username: " . "<strong>" . $_SESSION['username'] . "</strong>" . " (Type: " . $_SESSION['accType'] . ")";
    echo "</div>";

    // Code to hide/show Admin menu if a admin user is logged in
      if($_SESSION['accType'] == "admin"){
        echo "<style id='adminMenu' class='adminMenu'>display:block;</style>";
      }
 ?>
<html>
  <body>
    <body class="news">
  <header>
    <div class="nav" style="font-weight:bold;">
      <ul>
        <li class="home"><a href="http://shutunes.co.uk/home.php">Home</a></li>
        <li class="artists"><a href="http://shutunes.co.uk/artists.php">Artists</a></li>
        <li class="tracks"><a href="http://shutunes.co.uk/tracks.php">Tracks</a></li>
        <li class="playlists"><a href="http://shutunes.co.uk/playlists.php">Playlists</a></li>
        <li class="tickets"><a href="http://shutunes.co.uk/tickets.php">Tickets</a></li>
        <li id="adminMenu" class="adminMenu"><a href="http://shutunes.co.uk/home.php?am=">Admin</a></li>
        <li class="logOut" ><a href="http://shutunes.co.uk/home.php?lo=">Log Out</a></li>
      </ul>
    </div>
  </header>
</body>
<body>
</html>
