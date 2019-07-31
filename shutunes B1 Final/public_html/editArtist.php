<?php
// pulls all the code from header.php which has the menu items/logo and php code to show username and account type
include 'header.php'; ?>
<div class="searchTracks">
  <h1>Search For an Artist To Edit</h1>
  <form class="searchArtists" method="post">
    <input type="text" name="txtArtistSearch" placeholder="Type Artist Here..." required="required" />
    <button type="submit" name= "btnSearchArtist" class="btnSearchArtist">Go!</button>
  </form>
  <?php
  require('conn.php');
  // Searching For Artist in tblArtists
  if(isset($_POST["btnSearchArtist"])){
  $conn = Connect();
  $artistNameSearch = $_POST['txtArtistSearch'];
  $artistSearchSQL = "SELECT * FROM `tblArtists` WHERE 'artistName' LIKE '%$artistNameSearch%'";
  $artistResult = mysqli_query($conn, $artistSearchSQL) or die(mysqli_error($conn));
  $artistSearchCount = $artistResult->num_rows;
  if ($artistSearchCount >= 1){
    while ($artistRows = $artistResult->fetch_assoc()) {
        $artistID[] = $artistRows["artistID"];
        $artistName[] = $artistRows["artistName"];
      }
        echo count($artistName). " ". "artist(s) Found! " . "<br>";
      }
  }
?>
<div class="foundTracks">
  <?php
  if(!empty($artistName)){
       for($i = 0;$i < count($artistName); $i++ ){
        echo "<strong> artist ID: </strong>" . $artistID[$i] . "<strong> artist Name: </strong>" .$artistName[$i];
        echo "<br>";
}

}
else{
  echo "I'm sorry, no artists match your search.";
}
  ?>
</div>

<form class="addTrackToPlaylist" method="post">
  <input type="text" name="newArtistName" placeholder="New Artist Name" required="required">
  <input type="number" name="artistIDToChange" placeholder="Artist ID to Edit" required="required">
<input type="submit" name="changeArtistName" value="Change">
<?php
//whatever artists are selected are stored under selected artists variable via POST
if(isset($_POST['changeArtistName'])){
      $newArtistName = $_POST['newArtistName'];
      $artistIDToChange = $_POST['artistIDToChange'];
      $conn = Connect();
      $editArtistSQL = "UPDATE `tblArtists` SET `artistName` = '$newArtistName' WHERE `artistName` = '$artistIDToChange'";
      $editArtistResult = mysqli_query($conn, $editArtistSQL) or die(mysqli_error($conn));
      echo "<br>" . "Artist Has Been Edited";
      $conn->close();
}
  else{
    echo "<br>" ."<br>" . "Please enter a valid Artist";
  };
?>
</form>
  <div class="existingAlbumsAddNewTrack">
    <h3>Existing Artists</h3>
    <?php
    // All artists are pulled from the database and stored inside a table so the admin knows who to edit.
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
