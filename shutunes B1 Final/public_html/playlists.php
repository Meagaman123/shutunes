<?php
// pulls all the code from header.php which has the menu items/logo and php code to show username and account type
include 'header.php'; ?>
  <div class="existingPlaylists">
        <h1>YOUR PLAYLISTS</h1>
        <form class="newPlaylist" method="post">
          <input type="text" id="newPlaylistName" name="newPlaylistName" placeholder="Playlist Name..." required="required" />
          <button type="submit" name= "btnCreatePlaylist" class="btnCreatePlaylist">Create Playlist</button>
        </form>

    <?php
    $userID = $_SESSION['userID'];
    require('conn.php');
    $conn = Connect();
    $playlistID = array();
    $playlistName = array();
    // Check for already existing playlists
    $existingPlaylistSQL = "SELECT * FROM `tblPlaylistInfo` WHERE userID='$userID'";
    $existingPlaylistResult = mysqli_query($conn, $existingPlaylistSQL) or die(mysqli_error($conn));
    $existingPlaylistCount = $existingPlaylistResult->num_rows;
    if ($existingPlaylistCount >= 1){
      while ($row = $existingPlaylistResult->fetch_assoc()) {
          $playlistID[] = $row["playlistID"];
          $playlistName[] = $row["playListName"];
        }
        echo "The Following Playlists have been found!" . "<br>";
   }
 ?>
 <form method='post' class="viewPlaylist">
 <?php
   $checkedPlaylist = [];
 if(!empty($playlistName)){
    for($i = 0;$i < count($playlistName); $i++ ){
     $checkedPlaylist[] = "<input type='radio' value='$playlistID[$i]' name='checkedPlaylist[]'>";
     echo "<strong>" . $playlistName[$i] . "</strong>";
     echo $checkedPlaylist[$i];
     echo "<br>";
   }
}

     ?>
  <br>
  <input class="btnViewPlaylist" type='submit' value="View/Select Playlist">
 </form>
</div>
</body>
</html>
<?php
// Stores the POST result of playlist form. We need to convert this as it will be stored as an array
  $selectedPlaylist = $_POST["checkedPlaylist"];

// Checks to see if the variable is an array, if it is an array, the code runs.
  if(is_array($selectedPlaylist)){
    // we use implode to combine arrays to a single variable. There can only be one radio button selected so therefore only 1 item in the array
    $selectedPlaylist = implode($selectedPlaylist);
    $_SESSION['currentPlaylist'] = $selectedPlaylist;
?>
<div class="playlistTracks">
  <?php
  // Code to pull the track information from the playlists when they are selected
  $playlistTracksSQL = "SELECT * FROM tblPlaylistEntry INNER JOIN tblTracks ON tblPlaylistEntry.trackID = tblTracks.trackID WHERE `playlistID` = '$selectedPlaylist'";
  $playlistTracksResult = mysqli_query($conn, $playlistTracksSQL) or die(mysqli_error($conn));
  $playlistTracksCount = $playlistTracksResult->num_rows;
  if ($playlistTracksCount >= 1){
    while ($tracksRow = $playlistTracksResult->fetch_assoc()) {
      $playlistEntryID[] = $tracksRow["playlistEntryID"];
      $trackNames[] = $tracksRow["trackName"];
      $trackDuration[] = $tracksRow["trackDuration"];
      }
    echo "<h1>Track ID | Tracks | " . "Duration </h1>";
      for($i = 0;$i < count($trackNames); $i++ ){
        echo $playlistEntryID[$i];
        echo " <strong> | </strong>";
        echo $trackNames[$i];
        echo " <strong> | </strong>";
        echo $trackDuration[$i];
        echo "<br>";
      }
}
else{
  echo "There are no tracks within your selected playlist.";
}
}
   ?>
   <form method='post' class="delFromPlaylist">
   <input type="text" name="playlistEntryIDToDel" placeholder="ID of Track To Delete" required="required">
   <input type="submit" name="btnDelTrack" value="Delete">
</div>
<?php
if($_POST['btnDelTrack']){
  $playlistEntryID = $_POST['playlistEntryIDToDel'];
  $removeTrackSQL = "DELETE FROM `shutunes_db`.`tblPlaylistEntry` WHERE `tblPlaylistEntry`.`playlistEntryID` = '$playlistEntryID'";
  $playlistDeleteResult = mysqli_query($conn, $removeTrackSQL) or die(mysqli_error($conn));
  if($removeTrackSQL){
    echo "Track has been deleted.";
  }
  else{
    echo "Unable to delete track.";
  }
}

?>
</form>
<?php
// Add new playlist to database
if(isset($_POST["btnCreatePlaylist"])){
  $newPlaylistName = $_POST["newPlaylistName"];
  if(in_array($newPlaylistName,$playlistName)){
    echo '<script language="javascript">'; echo 'alert("ERROR! You Already Have a Playlist With That Name.")';echo '</script>';
  }
  else{
    $newPlaylistSQL = "INSERT INTO tblPlaylistInfo VALUES (NULL,'$newPlaylistName','$userID')";
    $newPlaylistResult = mysqli_query($conn, $newPlaylistSQL) or die(mysqli_error($conn));
    echo '<script language="javascript">'; echo 'alert("New Playlist Added!")';echo '</script>';
  }
} ?>
