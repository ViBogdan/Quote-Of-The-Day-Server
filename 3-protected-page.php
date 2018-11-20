<?php
// Start the session
session_start();

// this could have code put into an include so you can password protect any page you want to. 

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

    <h2>The quote of the day is: </h2>

    <?php 

//*********************************Connecting to DB**************************************
    	//$server = "db4free.net"; 
		//$serverUser = "vibogdan";
		//$serverPass = "Formula.1";
		//$dbName = "quoteoftheday";

		$server = "blonze2d5mrbmcgf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com"; 
		$serverUser = "iykvnj95l595htba";
		$serverPass = "q14jj0odjyr8if3f";
		$dbName = "qszbwoudqs1jwfu5";


		$connection = new mysqli($server, $serverUser, $serverPass, $dbName);

		if ($connection->connect_error) {
			die ("Connection failed" . $connection->connect_error);
		};
//***************************************************************************************

		$sqlQueryDetails = "SELECT * FROM quotes"; //selecting everything from quotes db
		$sqlQueryResult = $connection->query($sqlQueryDetails);

		$quotes = array (); //we define an empty array which we will fill with all quotes recovered from the db

		while ($aQuote = $sqlQueryResult->fetch_assoc()) {

			array_push($quotes, $aQuote['quote']); //going through the db we fill out the array of quotes

		};

		$displayQuote = $quotes[array_rand($quotes)]; //we chose a quote to display as random from our quotes array
		echo "<p class='centered'> $displayQuote </p>"

    ?>

  </main>

  	<p>Contribute with a quote:</p>
  	<form action="3.1-add-quote.php" method="POST">
  		<input type="text" placeholder="Contribute with a quote here...">
  		<button type="submit" class="mySubmit">Add quote</button>

	</body>
</html>