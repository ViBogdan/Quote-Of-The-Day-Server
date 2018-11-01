<?php
// Start the session
session_start();


//****************************************Connecting to Database****************************************

//defining my server connection elements (we can name the variables whatevere we want)
$server = "db4free.net"; 
$serverUser = "vibogdan";
$serverPass = "Formula.1";
$dbName = "quoteoftheday";


//connecting to the server with the details define above
$connection = new mysqli($server, $serverUser, $serverPass, $dbName);


//checking for server connection error
if ($connection->connect_error) {
	die ("Connection failed" . $connection->connect_error);
};


//****************************************************************************************************


//selecting elements that I am interested in (in our case the entire DB with user names and their passwords)
$sqlQueryDetails = "SELECT * FROM members";
$sqlQueryResult = $connection->query($sqlQueryDetails);


$userName = mysqli_real_escape_string($connection, $_POST["userName"]); //mysqli_real_escape_string($connection, ) around our superglobal varible will assure that what is written
$userPass = mysqli_real_escape_string($connection, $_POST["password"]);	//in the field is text and not code whoch could cause code injection in the DB
$noOfHits = 0;

while ($aUser = $sqlQueryResult->fetch_assoc()) { //to a chosen variable ($aUser in our case) we assign an associative array containing all details of a user

	if(trim($userName) == $aUser["user"]) {
		
		if($userPass == $aUser["password"]) {
			$noOfHits++;
	    	$_SESSION['isLoggedIn'] = true;
	    	header('Location: 3-protected-page.php');  //header == redirect to page; if credentials are ok, we send the user to the protected content page, with isLoggedIn = true
	    
	    } else {
	    	header('Location: index.php?error=badPassword&userName='.$userName);
	    	$noOfHits++;
	    };											
	};	
};

	
if ($noOfHits == 0) { //if we haven't found any hits in the DB it means the crdentials are wrong
	header('Location: index.php?error=badUserCredentials');//if credentials are not ok, we send him back to the login page where he is prompted to log in due to badUserCredentials = true
};

$connection->close(); //we don't need to connect to the server anymore	

?>

