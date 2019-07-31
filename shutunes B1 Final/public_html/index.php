<?php
session_start();
 ?>
<html >
<head>
  <meta charset="UTF-8">
  <title>SHU Tunes Login</title>
<link rel="stylesheet" href="style.css">

</style>
</head>

<body>
  <div class="login">
	<h1>SHU Tunes Login</h1>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required="required" />
        <input type="password" name="password" placeholder="Password" required="required" />
        <button type="submit" name= "btnSubmit" class="btnSubmit">Submit</button>
    </form>
</div>
<h2><a href="register.php" style="  position: absolute;
  top: 74%;
  left: 50%;
  margin: -150px 0 0 -150px;
  width:300px;
  color: white;
  font-size: 14px;">Not a Member? Sign Up For free!</a></h2>
</body>
</html>

<?php
 require('conn.php');
  //Check if submit button pressed
  if(isset($_POST["btnSubmit"])){
  $conn = Connect();
  $username = $_POST['username'];
  $password = $_POST['password'];
  $query = "SELECT * FROM `tblUsers` WHERE username='$username' and password='$password'";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  while ($row = $result->fetch_assoc()) {
      $accType = $row["accountType"];
      $userID = $row["userID"];
    }
  $count = $result->num_rows;
  if ($count == 1){
    $_SESSION['username'] = $username;
    $_SESSION['accType'] = $accType;
    $_SESSION['userID'] = $userID;
  }
  if(isset($_POST["btnSubmit"]))
  {
    if (isset($_SESSION['username'])){
      $username = $_SESSION['username'];
      echo '<script language="javascript">';
      echo "window.location = 'http://shutunes.co.uk/artists.php';";
      echo '</script>';
    }
    else{
      echo '<script language="javascript">';
      echo 'alert("Please Enter a Valid Username/Password Combination")';
      echo '</script>';
    }
  }
}
?>
