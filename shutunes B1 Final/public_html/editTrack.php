<?php
// pulls all the code from header.php which has the menu items/logo and php code to show username and account type
include 'header.php'; ?>
<div class="searchTracks">
  <h1>Search For a Track To Edit</h1>
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
  $trackSearchSQL = "SELECT * FROM `tblTracks` WHERE trackName LIKE '%$trackNameSearch%'";
  $result = mysqli_query($conn, $trackSearchSQL) or die(mysqli_error($conn));
  $trackSearchCount = $result->num_rows;
  if ($trackSearchCount >= 1){
    while ($trackRows = $result->fetch_assoc()) {
        $trackID[] = $trackRows["trackID"];
        $trackName[] = $trackRows["trackName"];
        $trackDuration[] = $trackRows["trackDuration"];
      }
        echo count($trackName). " ". "Track(s) Found! " . "<br>";
      }
  }
?>
<div class="foundTracks">
  <?php
  if(!empty($trackName)){
       for($i = 0;$i < count($trackName); $i++ ){
        echo "<strong> Track ID: </strong>" . $trackID[$i] . "<strong> Track Name: </strong>" .$trackName[$i];
        echo "<br>";
}

}
else{
  echo "I'm sorry, no tracks match the searched name.";
}
  ?>
</div>

<form class="addTrackToPlaylist" method="post">
  <input type="text" name="newTrackName" placeholder="New Track Name" required="required">
  <input type="number" name="trackIDToChange" placeholder="Track ID to Edit" required="required">
<input type="submit" name="changeTrackName" value="Change">
<?php
//whatever tracks are selected are stored under selected tracks variable via POST
if(isset($_POST['changeTrackName'])){
      $newTrackName = $_POST['newTrackName'];
      $trackIDToChange = $_POST['trackIDToChange'];
      $conn = Connect();
      $editTrackSQL = "UPDATE `shutunes_db`.`tblTracks` SET `trackName` = '$newTrackName' WHERE `tblTracks`.`trackID` = '$trackIDToChange'";
      $InsertTracksResult = mysqli_query($conn, $editTrackSQL) or die(mysqli_error($conn));
      echo "<br>" . "Track Has Been Edited";
      $conn->close();
}
  else{
    echo "<br>" ."<br>" . "Please enter an existing track name.";
  };
?>
</form>
<div class="existingAlbumsAddNewTrack">
  <h3>Existing Tracks</h3>
  <?php
  $conn = Connect();
  $trackSQL = "SELECT * FROM `tblTracks`";
  $trackResults = mysqli_query($conn, $trackSQL) or die(mysqli_error($conn));
  $trackResultsCount = $trackResults->num_rows;
  if ($trackResultsCount >= 1){
    while ($trackRows = $trackResults->fetch_assoc()){
        $trackID[] = $trackRows["trackID"];
        $trackName[] = $trackRows["trackName"];
        $trackDuration[] = $trackRows["trackDuration"];
        $albumID[] = $trackRows["albumID"];
      }
      echo "<table style='width:35%'>";
      echo "<tr>";
      echo "<th>" . "Track ID: " . "</th>";
      echo "<th>" . "Track Name: " . "</th>";
      echo "<th>" . "Track Duration: " . "</th>";
      echo "<th>" . "Album ID: " . "</th>";
      echo "</tr>";
  for($i = 0;$i < count($trackName); $i++ ){
    echo "<tr>";
    echo "<td>" . $trackID[$i] . "</td>";
    echo "<td>" . $trackName[$i]. "</td>";
    echo "<td>" . $trackDuration[$i]. "</td>";
    echo "<td>" . $albumID[$i]. "</td>";
    echo "</tr>";
  }
  echo "</table>";
}
   ?>
</div>
