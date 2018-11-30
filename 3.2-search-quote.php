<?php

session_start();

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

    //Finding a match using SQL query directly on the DB:
  
    $searchedField = $_POST['searchElement'];
    $sqlQueryDetails = "SELECT * FROM quotes WHERE quote LIKE '%$searchedField%'";
    $sqlQueryResult = $connection->query($sqlQueryDetails);

    $_SESSION['quotes_searched'] = array();

    if ($sqlQueryResult->num_rows > 0) {
  
      while ($aQuote = $sqlQueryResult->fetch_assoc()) {

         array_push($_SESSION['quotes_searched'], $aQuote['quote']);

      };

      header("Location: 3-protected-page.php?foundQuote=true");

    } else {

      header("Location: 3-protected-page.php?foundQuote=false");

    };


    //Finding a match using REGEX on all retrieved queries from the DB:

/*		$sqlQueryDetails = "SELECT * FROM quotes";
		$sqlQueryResult = $connection->query($sqlQueryDetails);

		$_SESSION['quotes_searched'] = array();
    $found = 0;

    $search = strtolower($_POST['searchElement']);
    $searched = "/"."$search"."/";

		while ($aQuote = $sqlQueryResult->fetch_assoc()) {

        $quote = strtolower($aQuote['quote']);

        if(preg_match($searched, $quote)) {

          array_push($_SESSION['quotes_searched'], $aQuote['quote']);
          $found++;

        };
    }; 

    if ($found > 1) {

      header("Location: 3-protected-page.php?foundQuote=true");

    } else {

      header("Location: 3-protected-page.php?foundQuote=false");

    };*/

?>