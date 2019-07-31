<?php
// pulls all the code from header.php which has the menu items/logo and php code to show username and account type
//initial creation of the artist and the how we will search for the artists tour.
include 'header.php';?>
<div class="searchArtist">
  <h1>Book Tickets</h1>
  <form class="searchArtistForm" method="post">
    <input type="text" id="txtArtistSearch" name="txtArtistSearch" placeholder="Type Artist Here..." required="required" />
    <button type="submit" name= "btnSearchArtist" class="btnSearchArtist">Go!</button>
  </form>

  <?php
    //checks we have a connection to the table.
    require('conn.php');
    // Searching For Artist in tblArtists
    if(isset($_POST["btnSearchArtist"])){
      //creates a way to connect to the database through out the rest of the php file.
      $conn = Connect();
      //creating the sql to search for the arists tours.
      $artistNameSearch = $_POST['txtArtistSearch'];
      $artistSearchSQL = "SELECT * FROM `tblArtists` WHERE artistName='$artistNameSearch'";
      $result = mysqli_query($conn, $artistSearchSQL) or die(mysqli_error($conn));
      $artistSearchCount = $result->num_rows;
      //this is fetching the results from the search and storing it.
      if ($artistSearchCount == 1){
        while ($artistRows = $result->fetch_assoc()) {
          $artistID = $artistRows["artistID"];
          $artistName = $artistRows["artistName"];
          $artistGenre = $artistRows["artistGenre"];
        }
        echo "Artist Found! ";
        // Searching For Artists Tours/tournames in tblTour
        $artistTourSQL = "SELECT * FROM `tblTours` WHERE artistID='$artistID'";
        $TourSearchResult = mysqli_query($conn, $artistTourSQL) or die(mysqli_error($conn));
        $TourSearchCount = $TourSearchResult->num_rows;
        //storing the results from the search.
        if ($TourSearchCount == 1){
          while ($TourRows = $TourSearchResult->fetch_assoc()) {
              $tourID = $TourRows["tourID"];
              $tourName = $TourRows["tourName"];
          }
        }
      }
      //Searching For the venues using tbl gigs and tour id.
      //this is a multitable search looking for the venue name and the venue age limit and the gig id for each from the tables tblGigs and tblVenues
      $albumTourSQL = "select tblVenues.venueName, tblVenues.venueAgeLimit, tblGigs.gigID from tblGigs join tblVenues on tblGigs.venueID=tblVenues.venueID where tblGigs.tourID='$tourID'";
      $TourResult = mysqli_query($conn, $albumTourSQL) or die(mysqli_error($conn));
      $TourCount = $TourResult->num_rows;
      $VenueName[] = array();
      $venueAgeLimit[] = array();
      $gigID[] = array();
      //stores the results of the search into the arrays.
      if ($TourCount > 0){
        while ($TourRows = $TourResult->fetch_assoc()) {
          $venueName[] = $TourRows["venueName"];
          $venueAgeLimit[] = $TourRows["venueAgeLimit"];
          $gigID[] = $TourRows["gigID"];
        }
      }
    }
  ?>
</div>

<div id="artistInfoCSS" class="artistInfoCSS">
  <?php
    // Display Artist Info
    if($artistName != NULL){
      echo $artistName;
    }
  ?>
</div>

<div class="albumNameCSS">
  <?php
    //this displays the tourname
    echo $tourName;
  ?>
</div>

<div class="trackInfo">
  <form>
  <?php
  if(isset($_POST["btnSearchArtist"])){
    //this will convert the gig id so we can select the tickets.
    //creating the array to store the result
    $checkedTours = [];
    $submitTours = [];

    if(!empty($venueName)){
      //this is making the checkboxes with the correct gigID attached to them and storing them in the array.
      for($i = 1;$i < count($venueName)+1; $i++ ){
        echo "<strong>" . "Venue: " . $venueName[$i-1] . "</strong>" . " | age limit:  " . $venueAgeLimit[$i] . "<br>";
        $checkedTours[] = "<input type='radio' value='$gigID[$i]' name='checkedTours'>";
      }
      $submitTours[] = "<input type='submit' name='btntickets'>";
    }
  }
  ?>
  </form>
</div>

<form method='post'>
  <?php
    if(isset($_POST["btnSearchArtist"])){
      //this is echoing radio's onto the page by imploding the array 1 by 1.
      echo implode("<br>", $checkedTours);
      echo implode("<br>", $submitTours);
    }
    //it then takes the result of what the user chose and takes that id and stores it in gigID we have to +1 as the ids start from 1 but the array starts at 0;
    if(isset($_POST["btntickets"])){
      $chosenGigID = $_POST["checkedTours"];
      //we are then going to select the type of ticket and the cost of the ticket using the gig id
      $conn = Connect();
      $gigSQL = "SELECT ticketID, TypeOfTicket, costOfTicket FROM `tblTickets` WHERE gigID = '$chosenGigID'";
      $gigResult = mysqli_query($conn, $gigSQL) or die(mysqli_error($conn));
      $gigCount = $gigResult->num_rows;
      //creating the arrays we need to store the results.
      $costOfTicket[] = array();
      $TypeOfTicket[] = array();
      $ticketID[] = array();
      //this is storing the result of the search in the arrays
      echo "<br>"."Number of gigs found: " . $gigCount;
      if ($gigCount >= 1){
        while ($TourRows = $gigResult->fetch_assoc()) {
          $costOfTicket[] = $TourRows["costOfTicket"];
          $TypeOfTicket[] = $TourRows["TypeOfTicket"];
          $ticketID[] = $TourRows["ticketID"];
        }
      }
    }
  ?>
</form>

<div class="trackInfo">
  <form method='post'>
    <?php
    if(isset($_POST["btntickets"])){
      //creating a way to store the results of what the user wants.
      $typeofTicket = [];
      $amountofticket = [];
      $submitticket= [];
      //this is displaying the ticket info for the user to chose.
      if(!empty($ticketID)){
        for($r = 1;$r < count($ticketID); $r++ ){
          echo "<strong>" . "type of ticket: " . "</strong>" . $TypeOfTicket[$r] . "<strong>". " | Cost of ticket:  " . "</strong>" . $costOfTicket[$r] . "<br>";
          $typeofTicket[] = "<input type='radio' value='$ticketID[$r]' name='typeofTicket[]'>";
        }
        $amountofticket[] = "<input type='number' min='0' name = 'amountofticket'>";
        $submitticket[] = "<input type='submit' name = 'btnBook' value='Book tickets' class = 'btnBook'>";
      }
      echo implode("<br>", $typeofTicket);
      echo implode("<br>", $amountofticket);
      echo implode("<br>", $submitticket);
      }
    ?>
  </form>
</div>


<?php
    if(isset($_POST["btnBook"])){
      //this stores the results of what the user chose in an array.
      $selectedTickets = $_POST["typeofTicket"];
      if(is_array($selectedTickets)){
        $Tickets = implode($selectedTickets);
      }
      //echo $Tickets;
    $selectedAmount = $_POST["amountofticket"];
    $userID = $_SESSION['userID'];
    $conn = Connect();
    //This is inserting into the table the ticket id and the amount of tickets and the userID
    $InsertTicketSQL = "INSERT INTO shutunes_db.tblBookings (bookingID, ticketQuantity, userID, ticketID) VALUES (NULL, '$selectedAmount', '$userID', '$Tickets')";
    $InsertTracksResult = mysqli_query($conn, $InsertTicketSQL) or die(mysqli_error($conn));
    //calculate total cost and the see if they quilify for a discount
    $TicketpriceSQL = "SELECT costOfTicket FROM `tblTickets` WHERE ticketID = '$Tickets'";
    $ticketpriceResult = mysqli_query($conn, $TicketpriceSQL) or die(mysqli_error($conn));
    $TourRows = $ticketpriceResult->fetch_assoc();
    $costOfTicket = $TourRows["costOfTicket"];
    $totalcost = ($costOfTicket * $selectedAmount);
    if ($selectedAmount >= 5){
      $finalcost = $totalcost * 0.9;
      echo "the price was: £" . $totalcost . "... with discount, the new price is: £" . number_format($finalcost,2);
      //echos to 2 decimal places
    }else{
      echo "Total cost: £" . number_format($totalcost,2);
    }
  }
?>
</body>
</html>
