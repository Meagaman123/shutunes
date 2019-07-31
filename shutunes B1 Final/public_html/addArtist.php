<?php
// pulls all the code from header.php which has the menu items/logo and php code to show username and account type
include 'header.php';
require('conn.php');?>
<div class="searchTracks">
  <h1>Add New Artist</h1>
  <form class="searchTracksForm" method="post">
    <strong>Name: <input type="text" name="txtNewArtist" placeholder="New Artist Name" required="required" />
    Genre: <input type="text" name="txtNewArtistGenre" placeholder="New Artist Genre" required="required" />
  </strong>
    <button type="submit" name= "btnAddNewArtist" class="btnSearchTracks">Add New Artist</button>
    <?php
    if(isset($_POST['btnAddNewArtist'])){
      $conn = Connect();
      $newArtistName = $_POST['txtNewArtist'];
      $newArtistGenre = $_POST['txtNewArtistGenre'];
      $addNewArtistSQL = "INSERT INTO `shutunes_db`.`tblArtists` (`artistID`, `artistName`, `artistGenre`) VALUES (NULL, '$newArtistName', '$newArtistGenre')";
      $addNewArtistResults = mysqli_query($conn, $addNewArtistSQL) or die(mysqli_error($conn));
      echo "<br>" . "<br>" . "New Artist Added To Database";
    }
    ?>
  </form>

<div class="existingAlbumsAddNewTrack">
  <?php
  $conn = Connect();
  $artistSQL = "SELECT * FROM `tblArtists`";
  $artistResults = mysqli_query($conn, $artistSQL) or die(mysqli_error($conn));
  $artistResultsCount = $artistResults->num_rows;
  if ($artistResultsCount >= 1){
    while ($artistRows = $artistResults->fetch_assoc()){
        $artistID[] = $artistRows["artistID"];
        $artistName[] = $artistRows["artistName"];
        $artistGenre[] = $artistRows["artistGenre"];
      }
      echo "<table style='width:35%'>";
      echo "<tr>";
      echo "<th>" . "Artist ID: " . "</th>";
      echo "<th>" . "Artist Name: " . "</th>";
      echo "<th>" . "Artist Genre: " . "</th>";
      echo "</tr>";
  for($i = 0;$i < count($artistName); $i++ ){
    echo "<tr>";
    echo "<td>" . $artistID[$i] . "</td>";
    echo "<td>" . $artistName[$i]. "</td>";
    echo "<td>" . $artistGenre[$i]. "</td>";
    echo "</tr>";
  }
  echo "</table>";
}
   ?>
</div>
