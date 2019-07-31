<?php
// pulls all the code from header.php which has the menu items/logo and php code to show username and account type
include 'header.php';
require('conn.php');?>
<div class="searchTracks">
  <h1>Delete Artist</h1>
  <form class="searchTracksForm" method="post">
    <strong>Artist Name: <input type="text" name="txtArtistName" placeholder="Artist Name" required="required" />
    </strong>
    <button type="submit" name= "btnDeleteArtist" class="btnSearchTracks">Delete!</button>
    <?php
    	if(isset($_POST['btnDeleteArtist'])){
    	  $conn = Connect();
    	  $ArtistName = $_POST['txtArtistName'];
    	  $deleteArtistSQL = "DELETE FROM `shutunes_db`.`tblArtists` WHERE artistName = '$ArtistName'";
    	  $deleteTracksResults = mysqli_query($conn, $deleteArtistSQL) or die(mysqli_error($conn));
    	  echo "<br>" . "Artist Deleted from database";
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

</div>
