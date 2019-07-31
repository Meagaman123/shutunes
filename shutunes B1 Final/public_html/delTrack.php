<?php
// pulls all the code from header.php which has the menu items/logo and php code to show username and account type
include 'header.php';
require('conn.php');?>
<div class="searchTracks">
  <h1>Delete Track</h1>
  <form class="searchTracksForm" method="post">
    <strong>Name: <input type="text" name="txtTrackName" placeholder="Track Name" required="required" />
    Album ID: <input type="text" name="txtAlbumID" placeholder="Album ID of Track" required="required" />
    </strong>
    <button type="submit" name= "btnDeleteTrack" class="btnSearchTracks">Delete!</button>
    <?php
    	if(isset($_POST['btnDeleteTrack'])){
    	  $conn = Connect();
    	  $TrackName = $_POST['txtTrackName'];
    	  $TrackSelectedAlbum = $_POST['txtAlbumID'];
    	  $deleteTrackSQL = "DELETE FROM `shutunes_db`.`tblTracks` WHERE trackName = '$TrackName' AND albumID = '$TrackSelectedAlbum'";
    	  $deleteTracksResults = mysqli_query($conn, $deleteTrackSQL) or die(mysqli_error($conn));
    	  echo "Track Deleted from database";
    	}
    ?>
  </form>
<div class="existingAlbumsAddNewTrack">
  <?php
  $conn = Connect();
  $albumSQL = "SELECT * FROM `tblAlbums`";
  $albumResults = mysqli_query($conn, $albumSQL) or die(mysqli_error($conn));
  $albumResultsCount = $albumResults->num_rows;
  if ($albumResultsCount >= 1){
    while ($albumRows = $albumResults->fetch_assoc()){
        $albumID[] = $albumRows["albumID"];
        $albumName[] = $albumRows["albumName"];
        $dateReleased[] = $albumRows["dateReleased"];
        $artistID[] = $albumRows["artistID"];
        $albumArt[] = $albumRows["albumArt"];
      }
      echo "<table style='width:35%'>";
      echo "<tr>";
      echo "<th>" . "Album ID: " . "</th>";
      echo "<th>" . "Album Name: " . "</th>";
      echo "<th>" . "Date Released: " . "</th>";
      echo "<th>" . "Artist ID: " . "</th>";
      echo "</tr>";
  for($i = 0;$i < count($albumName); $i++ ){
    echo "<tr>";
    echo "<td>" . $albumID[$i] . "</td>";
    echo "<td>" . $albumName[$i]. "</td>";
    echo "<td>" . $dateReleased[$i]. "</td>";
    echo "<td>" . $artistID[$i]. "</td>";
    echo "</tr>";
  }
  echo "</table>";
}
   ?>
</div>
