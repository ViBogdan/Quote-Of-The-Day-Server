<?php
// Start the session
session_start();

?>


<!DOCTYPE html>
<html>
	<head>
	   	<title>Quote of the day</title>
      <link href="https://fonts.googleapis.com/css?family=K2D" rel="stylesheet" type="text/css"> <!--importing the K2D font from Google Font API-->
      <link rel="stylesheet" type="text/css" href="7-styles.css">
  </head>

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

if(isset($_SESSION['isLoggedIn'])) {

  //The user is already logged in, cannot add another user

  echo "<p>You already have an account!</p>";

} else {

//we first check for errors to be displayed on top of the page

if(isset($_GET["error"])) {

	switch($_GET["error"]) {

		case "noUserName":
  			echo "<h2 class='warning'>You did not specify a user name!</h2>"; 
  			break;

		case "repeatPass":
			echo "<h2 class='warning'>Your repeat password is not the same as the password!</h2>"; 
  			break;

  		case "repeatUser":
  			echo "<h2 class='warning'>This user name is already taken! Please select another one!</h2>"; 
  			break;
	
	};
};

// If no users logged in yet, add new user form for subscription posibility

if (isset($_GET['userName'])) {
	$newUserForm = <<<NEWUSERFORM

	  <h2>Please choose a user name and password:</h2>

	  <form method='post' action='5-add-user-response.php'>
	  <link rel="stylesheet" type="text/css" href="7-styles.css">

	      <label class='myLabel'>User Name</label><br> <input type='text' name='newUserName' id='newusername' placeholder='User Name' value='{$_GET["userName"]}'> <br>
	      <label class='myLabel'>Password</label><br> <input type='password' name='newPassword' id='newpassword' placeholder='Password'> <br>
	      <label class='myLabel'>Repeat Password</label><br> <input type='password' name='newRePassword' placeholder='Repeat your Password'> <br>
	      <input type='submit' class='mySubmit'>

	  </form>

NEWUSERFORM;

} else {

	$newUserForm = <<<NEWUSERFORM

	  <h2>Please choose a user name and password:</h2>

	  <form method='post' action='5-add-user-response.php'>
	  <link rel="stylesheet" type="text/css" href="7-styles.css">

	      <label class='myLabel'>User Name</label><br> <input type='text' name='newUserName' id='newusername' placeholder='User Name'> <br>
	      <label class='myLabel'>Password</label><br> <input type='password' name='newPassword' id='newpassword' placeholder='Password'> <br>
	      <label class='myLabel'>Repeat Password</label><br> <input type='password' name='newRePassword' placeholder='Repeat your Password'> <br>
	      <input type='submit' class='mySubmit'>

	  </form>

NEWUSERFORM;

	};


	echo $newUserForm;
	echo "<script>  document.querySelector('#newusername').focus();  </script>";

	//at the end we check once more for errors so that we can focus on the filed neccesarry
	if(isset($_GET["error"])) {

		switch($_GET["error"]) {

			case "noUserName":
	  			echo "<script> document.getElementById('newusername').focus() </script>";
	  			break;

			case "repeatPass":
	  			echo "<script> document.getElementById('newpassword').focus() </script>";
	  			break;

	  		case "repeatUser":
	  			echo "<script> document.getElementById('newusername').focus() </script>";
	  			break;
		
		};
	};

};

?>

</main>

	</body>
</html>