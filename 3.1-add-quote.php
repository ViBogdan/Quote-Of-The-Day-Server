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

$newQuote = mysqli_real_escape_string($connection, $_POST['newQuote']);

$queryDetails = "INSERT INTO quotes (quote) VALUES ('$newQuote')";
$connection->query($queryDetails);

$connection->close();

header('Location: 3-protected-page.php?userQuoteAdded=true');

?>