<?php
session_start();
 ?>
<html >
<head>
  <title>SHU Tunes Sign Up</title>
</head>

<body>
  <div class="login">
	<h1>Sign Up</h1>
    <form method="post">
        <input type="text" name="firstname" placeholder="First Name" required="required" /><br>
        <input type="text" name="lastname" placeholder="Last Name" required="required" /><br>
        <input type="text" name="email" placeholder="Email Address" required="required" /><br>
        <input type="text" name="username" placeholder="Username" required="required" /><br>
        <input type="password" name="password" placeholder="Password" required="required" /><br>
        <button type="submit" name= "btnSubmit" class="btn btn-primary btn-block btn-large">Submit</button>
    </form>
</div>
</body>
</html>

<?php
 require('conn.php');
  //Check if submit button pressed
  if(isset($_POST["btnSubmit"])){
  $conn = Connect();
  $email =  $_POST["email"];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];

  if(isset($_POST["btnSubmit"]))
  {
    $query = "SELECT * FROM `tblUsers` WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $query);
    if($result->num_rows != 1){
      $query = "INSERT INTO `tblUsers` (`userID`, `username`, `password`, `email`, `accountType`, `firstName`, `lastName`) VALUES (NULL, '$username', '$password', '$email', NULL, '$firstname', '$lastname')";
      $result = mysqli_query($conn, $query);
      echo '<script language="javascript">';
      //Redirect user to login page
      echo "window.location = 'http://shutunes.co.uk/index.php';";
      //JS alert to show the account was successfully created
      echo 'alert("SUCCESS! Account created, please log in.")';
      echo '</script>';
    }
    else
    {
      echo '<script language="javascript">';
      //JS Alert to show there was an error with a field
      echo 'alert("There was an error with one or more of your entered fields.")';
      echo '</script>';
    }
  }
}
?>
