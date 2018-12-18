<?php
// Start the session
session_start();


//****************************************Connecting to Database****************************************

$server = "blonze2d5mrbmcgf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com"; 
$serverUser = "iykvnj95l595htba";
$serverPass = "q14jj0odjyr8if3f";
$dbName = "qszbwoudqs1jwfu5";


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
$sqlResultNumRows = $sqlQueryResult->num_rows; //with this method you can find and store the number of results returned from the DB after the query

//procedural:
$userName = mysqli_real_escape_string($connection, $_POST["userName"]); //mysqli_real_escape_string($connection, ) around our superglobal varible will assure that what is written
$userPass = mysqli_real_escape_string($connection, $_POST["password"]);	//in the field is text and not code which could cause code injection in the DB
$noOfHits = 0;

//OOP:
// $userName = $connection->real_escape_string($_POST["userName"]);
// $userPass = $connection->real_escape_string($_POST["password"]);
// $noOfHits = 0;

while ($aUser = $sqlQueryResult->fetch_assoc()) { //to a chosen variable ($aUser in our case) we assign an associative array containing all details of a user

	if(trim($userName) == $aUser["user"]) {
		
		$passwordVerify = password_verify($userPass, $aUser["password"]); //we check the pass given by the user against the pass in the database (which is hashed, thus we use de-hash)
		
		if($passwordVerify == 1) { //our password_verify() function will return 1 if the 2 elements passed match and 0 if they don't
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

