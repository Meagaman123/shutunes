<?php
// pulls all the code from header.php which has the menu items/logo and php code to show username and account type
include 'header.php';
require('conn.php');?>
<div class="searchTracks">
  <h1>Add New Album</h1>
  <form class="searchTracksForm" method="post">
    <strong>
    Album Name: <input type="text" name="txtNewAlbumName" placeholder="New Album Name" required="required" />
    Date Released: <input type="date" name="txtNewAlbumReleaseDate" placeholder="New Album Release Date" required="required" />
    Artist ID: <input type="text" name="txtNewAlbumArtistID" placeholder="Artist ID" required="required" />
    Album Art: <input type="file" name="imgAlbumArt"/>
  </strong>
    <button type="submit" name= "btnAddNewTrack" class="btnSearchTracks">Add New Album</button>
    <?php
    if(isset($_POST['btnAddNewAlbum'])){
      // https://stackoverflow.com/questions/31761407/php-form-file-upload-to-mysql-and-to-server used this stack overflow article to get ideas on how to upload a BLOB image.
      if($_FILES["imgAlbumArt"]["error"]>0)
      {
          echo "FILE ERROR";
          die();
      }
      $filename = "img/".$_FILES["imgAlbumArt"]["name"];
      // move file to a folder
      if (!move_uploaded_file($_FILES["imgAlbumArt"]["tmp_name"], $filename)) { // change target path
          echo "Sorry, there was an error uploading your file.";
          die();
      }
      $conn = Connect();
      $newAlbumName = $_POST['txtNewAlbumName'];
      $newAlbumReleaseDate = $_POST['txtNewAlbumReleaseDate'];
      $newAlbumArtistID = $_POST['txtNewAlbumArtistID'];
      $addNewAlbumSQL = "INSERT INTO `shutunes_db`.`tblAlbums` (`albumID`, `albumName`, `dateReleased`, `albumArt` , `artistID`) VALUES (NULL, '$newAlbumName', '$newAlbumReleaseDate', '$filename', '$newAlbumArtistID')";
      $addNewAlbumResults = mysqli_query($conn, $addNewAlbumSQL) or die(mysqli_error($conn));
      echo "New Album Added To Database";
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
