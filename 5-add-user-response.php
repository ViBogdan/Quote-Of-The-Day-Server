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

//we can also use:
//$connection = mysqli_connect($server, $serverUser, $serverPass, $dbName);


//checking for server connection error
if ($connection->connect_error) {
	die ("Connection failed" . $connection->connect_error);
};


//******************************************************************************************************


//getting new user details
$newUserName = mysqli_real_escape_string($connection, $_POST["newUserName"]);
$newPass = mysqli_real_escape_string($connection, $_POST["newPassword"]);
$newRePass = mysqli_real_escape_string($connection, $_POST["newRePassword"]);


//selecting all users from existing user DB
$sqlQueryDetails = "SELECT * FROM members";
$sqlQueryResult = $connection->query($sqlQueryDetails);

//we can also use:
//$sqlQueryResult = mysqli_query($connection, $sqlQueryDetails);

$checkRepeatUser = 0;

//checking if the user name is already in the DB - verrifcation key
while ($aUser = $sqlQueryResult->fetch_assoc()) {

	if($aUser["user"] == $newUserName) {
		$checkRepeatUser++;
	}; 
};


//check if the user is already in the DB using above key; if not check if pass is equal to repear pass before adding new user; we also check for field not to be empty
if ($checkRepeatUser == 0) {
	if (!empty($newUserName)) {

		if(!empty($newPass) && $newPass == $newRePass) {

			$hashedUserPass = password_hash($newPass, PASSWORD_DEFAULT); //we hash the password before inserting it into the database
			$sqlQueryDetails = "INSERT INTO members (user, password) VALUES ('$newUserName', '$hashedUserPass')";
			$connection->query($sqlQueryDetails);
		
			$_SESSION['isLoggedIn'] = true;
			header('Location: 3-protected-page.php');

		} else {

			header('Location: 4-add-user.php?error=repeatPass&userName='.$newUserName); //if the repeat password is wrong we still want to keep the user name inserted in the field
		};	

	} else {

		header('Location: 4-add-user.php?error=noUserName');

	};

} else {

	header('Location: 4-add-user.php?error=repeatUser');

};


$connection->close(); //we don't need to connect to the server anymore	
	

?>

