<?php
// Start the session
session_start();

// check session to see if they logged in:
if(isset($_SESSION['isLoggedIn'])) {

    //do nothing, the user logged in.

} else {

  header('Location: index.php?error=isBlocked');  //if the isLoggedIn is not set, it means that they are trying to acces content without loggin in. We thus redirect them back to
                                                  //the login page with isBlock set to true, where he is prompted to log in
}

?>


<!DOCTYPE html>
<html>

	<title>Quote of the day</title>
  <link href="https://fonts.googleapis.com/css?family=K2D" rel="stylesheet" type="text/css"> <!--importing the K2D font from Google Font API-->
  <link rel="stylesheet" type="text/css" href="7-styles.css">

<body>

<nav>
    <ul>
    <li><a href="index.php">Log in</a></li>
    <li><a href="3-protected-page.php">Get Quote</a></li>
    <li><a href="4-add-user.php">Register</a></li>
    <li><a href="6-logout.php">Log Out</a></li>
  </ul>
</nav>


  <main>

<?php 

//*********************************Connecting to DB**************************************

		$server = "blonze2d5mrbmcgf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com"; 
		$serverUser = "iykvnj95l595htba";
		$serverPass = "q14jj0odjyr8if3f";
		$dbName = "qszbwoudqs1jwfu5";


		$connection = new mysqli($server, $serverUser, $serverPass, $dbName);

		if ($connection->connect_error) {
			die ("Connection failed" . $connection->connect_error);
		};
//***************************************************************************************

//we define the search bar for the user so that it can be used anytime we want to generate it in the page
$searchElement = <<<SEARCHELEMENT

  	<form action="3.2-search-quote.php" method="POST">
  		<input type="text" placeholder="Search quote hint here..." name="searchElement">
  		<button type="submit" class="mySubmit">Search</button>
  	</form>	

SEARCHELEMENT;

		// If the user has searched for an element inside the qotes DB then we need to either return the results or signal that no results were generated

		if (isset($_GET["foundQuote"]) && $_GET["foundQuote"] == "true") {

			echo "<p>We found these:</p>";

			foreach($_SESSION['quotes_searched'] as $quoteSearched) {

				echo "<p class='centered'> $quoteSearched </p><br>";

			};

			echo $searchElement;

		} elseif (isset($_GET["foundQuote"]) && $_GET["foundQuote"] == "false") {

			echo "<p>Unfortunately we did not find any quotes based on your search :( Maybe you can contribute with one :)</p>";
			echo $searchElement;

		} else { // if the user has not searched for anything, we present him with a random quote from our existing DB

		$sqlQueryDetails = "SELECT * FROM quotes"; //selecting everything from quotes db
		$sqlQueryResult = $connection->query($sqlQueryDetails);

		$quotes = array (); //we define an empty array which we will fill with all quotes recovered from the db

		while ($aQuote = $sqlQueryResult->fetch_assoc()) {

			array_push($quotes, $aQuote['quote']); //going through the db we fill out the array of quotes

		};

		$displayQuote = $quotes[array_rand($quotes)]; //we chose a quote to display as random from our quotes array
		echo "<h2>The quote of the day is: </h2>";
		echo "<p class='centered'> $displayQuote </p>";
		echo $searchElement;

		$connection->close();

		};


    // Generating a form where the user can contribute with a quote to the existing DB

    if (isset($_GET['userQuoteAdded'])) {

    	echo "<p>Your quote was added to the database!</p>";

    } else {

$addForm = <<<ADDFORM

  	<form action="3.1-add-quote.php" method="POST" id="addQuote">
  		<textarea type="text" placeholder='Contribute with a quote here. Should look like: "Quote" -- Author' form="addQuote" class="addQuote" name="newQuote"></textarea>
  		<br>
  		<button type="submit" class="mySubmit">Add quote</button>
  	</form>	

ADDFORM;

	echo $addForm;

  	};

?>
  	
  </main>


	</body>
</html>