<?php
// pulls all the code from header.php which has the menu items/logo and php code to show username and account type
include 'header.php';?>

  <div class="searchTracks">
    <h1>Search For a Track</h1>
    <form class="searchTracksForm" method="post">
      <input type="text" id="txtTracksSearch" name="txtTrackSearch" placeholder="Type Track Here..." required="required" />
      <button type="submit" name= "btnSearchTracks" class="btnSearchTracks">Go!</button>
    </form>
    <?php
    require('conn.php');
    // Searching For Artist in tblArtists
    if(isset($_POST["btnSearchTracks"])){
    $conn = Connect();
    $trackNameSearch = $_POST['txtTrackSearch'];
    $trackSearchSQL = "SELECT * FROM `tblTracks` WHERE trackName='$trackNameSearch'";
    $result = mysqli_query($conn, $trackSearchSQL) or die(mysqli_error($conn));
    $trackSearchCount = $result->num_rows;
    $trackID = [];
    $trackName = [];
    $trackDuration = [];   
    if ($trackSearchCount > 0){
      while ($trackRows = $result->fetch_assoc()) {
          $trackID = $trackRows["trackID"];
          $trackName = $trackRows["trackName"];
          $trackDuration = $trackRows["trackDuration"];
        }
        echo "Track Found! " . $trackID . "<br>";
        echo $trackName . " " . $trackDuration;
      }else{
        echo "I'm sorry, no tracks match the searched name.";
      }
    }
?>
<form class="addTrackToPlaylist" method="post">
  <br><input type="submit" name="AddToPlaylist" value="Add Song To Current Playlist">
  <?php
  if(isset($_POST['AddToPlaylist'])){
    if(!empty($trackID)){
      $selectedPlaylist = $_SESSION['currentPlaylist'];
      $conn = Connect();
      $InsertTracksSQL = "INSERT INTO tblPlaylistEntry VALUES (NULL, $trackID, $selectedPlaylist)";
      $InsertTracksResult = mysqli_query($conn, $InsertTracksSQL) or die(mysqli_error($conn));
      echo "<br>" . "Track Added To Your Playlist";
    }else{
      echo "<br>" . "Cannot Add Track To Playlist As No Tracks Have Been Either Searched or Found.";
    }
  }
  ?>
</form>
