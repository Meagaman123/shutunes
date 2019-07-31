<?php
// pulls all the code from header.php which has the menu items/logo and php code to show username and account type
include 'header.php';
require('conn.php');?>
<div class="searchTracks">
  <h1>Add New track</h1>
  <form class="searchTracksForm" method="post">
    <strong>Name: <input type="text" name="txtNewTrackName" placeholder="New Track Name" required="required" />
    Duration: <input type="text" name="txtNewTrackDuration" placeholder="New Track Duration" required="required" />
    Album ID: <input type="text" name="txtAlbumID" placeholder="Album ID of New Track" required="required" />
  </strong>
    <button type="submit" name= "btnAddNewTrack" class="btnSearchTracks">Go!</button>
    <?php
    if(isset($_POST['btnAddNewTrack'])){
      $conn = Connect();
      $newTrackName = $_POST['txtNewTrackName'];
      $newTrackDuration = $_POST['txtNewTrackDuration'];
      $newTrackSelectedAlbum = $_POST['txtAlbumID'];
      $addNewTrackSQL = "INSERT INTO `shutunes_db`.`tblTracks` (`trackID`, `trackName`, `trackDuration`, `albumID`) VALUES (NULL, '$newTrackName', '$newTrackDuration', '$newTrackSelectedAlbum')";
      $addNewTracksResults = mysqli_query($conn, $addNewTrackSQL) or die(mysqli_error($conn));
      echo "New Track Added To Database";
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
