<?php
// pulls all the code from header.php which has the menu items/logo and php code to show username and account type
include 'header.php';?>

  <div class="searchArtist">
    <h1>Search For an Artist</h1>
    <form class="searchArtistForm" method="post">
      <input type="text" id="txtArtistSearch" name="txtArtistSearch" placeholder="Type Artist Here..." required="required" />
      <button type="submit" name= "btnSearchArtist" class="btnSearchArtist">Go!</button>
    </form>

    <?php
    require('conn.php');
    // Searching For Artist in tblArtists
    if(isset($_POST["btnSearchArtist"])){
      $conn = Connect();
      $artistNameSearch = $_POST['txtArtistSearch'];
      $artistSearchSQL = "SELECT * FROM `tblArtists` WHERE artistName='$artistNameSearch'";
      $result = mysqli_query($conn, $artistSearchSQL) or die(mysqli_error($conn));
      $artistSearchCount = $result->num_rows;
      if ($artistSearchCount == 1){
        while ($artistRows = $result->fetch_assoc()) {
          $artistID = $artistRows["artistID"];
          $artistName = $artistRows["artistName"];
          $artistGenre = $artistRows["artistGenre"];
          echo "<div id='artistInfoCSS' class='artistInfoCSS'>";
          echo $artistRows["artistName"] . " | ";
          echo $artistRows["artistGenre"] . "<br>";
          echo "</div>";
        }
      }

        // Searching For Artists Albums in tblAlbums
        $artistAlbumSQL = "SELECT * FROM `tblAlbums` WHERE artistID='$artistID'";
        $albumSearchResult = mysqli_query($conn, $artistAlbumSQL) or die(mysqli_error($conn));
        $albumSearchCount = $albumSearchResult->num_rows;
        $albumID[] = array();
        $albumName[] = array();
        $dateReleased[]  = array();
        $albumArt[] = array();
        if ($albumSearchCount > 0){
          for ($i=0; $i < $albumSearchCount; $i++) {
            while ($albumRows = $albumSearchResult->fetch_assoc()) {
              $albumID[$i] = $albumRows["albumID"];
              $albumName[$i] = $albumRows["albumName"];
              $dateReleased[$i]  = $albumRows["dateReleased"];
              $albumArt[$i] = $albumRows["albumArt"];
              echo "<div class='albumNameCSS'>";
              echo $albumRows["albumName"];
              echo "</div>";
              echo "<div class='albumReleaseDateCSS'>";
              echo "Released: " . $albumRows["dateReleased"];
              echo "<br>ID | Name | Length</div>";

              //Searching For Tracks In the albumID
              $albumTracksSQL = "SELECT * FROM `tblTracks` WHERE albumID='$albumID[$i]'";
              $albumTracksResult = mysqli_query($conn, $albumTracksSQL) or die(mysqli_error($conn));
              $albumTracksCount = $albumTracksResult->num_rows;
              if ($albumTracksCount > 0){
                for ($j = 0; $j < $albumTracksCount; $j++) {
                  while ($trackRows = $albumTracksResult->fetch_assoc()) {
                    echo "<div class='trackInfo'>". $trackRows["trackID"] . " ". "<strong>" . $trackRows["trackName"] . "</strong>" . " | " . $trackRows["trackDuration"] . "Mins" . "</div>" . "<br>";
                    $trackID[] = $trackRows["trackID"];
                  }
                }
              }
            }
          }
        }$conn->close();
    }
  ?>
  <form class="addToPlaylist" method="post">
    <input type="number" name="txtTrackIDToAdd" placeholder="Please enter an ID to add to playlist"required="required">
    <input type="submit" name="btnSubmitAddTrack" value="Add Track">
  </form>
<?php
if(isset($_POST['btnSubmitAddTrack'])){
  $conn = Connect();
  $selectedPlaylist =  $_SESSION['currentPlaylist'];
  $trackToAddID = $_POST['txtTrackIDToAdd'];
    if($selectedPlaylist != NULL){
      $insertTrackSQL = "INSERT INTO tblPlaylistEntry VALUES (NULL, '$trackToAddID', '$selectedPlaylist')";
      $insertTracksResult = mysqli_query($conn, $insertTrackSQL) or die(mysqli_error($conn));
      echo "Your track has been added to your selected playlist.";
    }else{
      echo "You need to select a playlist from the playlist page before the track can be added.";
    }
}


 ?>
  </div>
