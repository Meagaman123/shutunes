<?php
// pulls all the code from header.php which has the menu items/logo and php code to show username and account type
include 'header.php';
require('conn.php');?>
<div class="searchTracks">
  <h1>Delete Album</h1>
  <form class="searchTracksForm" method="post">
    <strong>
        Artist ID: <input type="text" name="txtArtistID" placeholder="Artist ID" required="required" />
        Album Name: <input type="text" name="txtAlbumName" placeholder="Album Name" required="required" />
    </strong>
    <button type="submit" name= "btnDeleteAlbum" class="btnSearchTracks">Delete!</button>
    <?php
    	if(isset($_POST['btnDeleteAlbum'])){
    	  $conn = Connect();
    	  $AlbumName = $_POST['txtAlbumName'];
    	  $ArtistID = $_POST['txtArtistID'];
    	  $deleteAlbumSQL = "DELETE FROM `shutunes_db`.`tblAlbums` WHERE albumName = '$AlbumName' AND artistID = '$ArtistID'";
    	  $deleteTracksResults = mysqli_query($conn, $deleteAlbumSQL) or die(mysqli_error($conn));
    	  echo "Album Deleted from database";
    	}
    ?>
  </form>
  <div class="existingAlbumsAddNewTrack">
      <h3>Existing Artists</h3>
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
  <br>
  <div class="existingAlbumsAddNewTrack">
    <h3>Existing Albums</h3>
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
</div>
