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
    <li><a href="1-login.php">Log in</a></li>
    <li><a href="3-protected-page.php">Get Quote</a></li>
    <li><a href="4-add-user.php">Register</a></li>
    <li><a href="6-logout.php">Log Out</a></li>
  </ul>
</nav>



<main>


<?php

if(isset($_SESSION['isLoggedIn'])) {

  //The user is already logged in

  echo "<p>You are already logged in buddy!</p>";

} else {


    // using the querystring to send messages back to this login page:
  	// we recover from the login-response page the value of error. Depending on the value of the error we can return a messeage to the user
  	// we first check for errors so that we can see if we have anything to be displayed to the user 
    
  	if (isset($_GET['error'])) {

	  	switch ($_GET['error']) {

	  		case "badPassword":
	  		    echo "<h2 class='warning'>You user name is correct but you put in the wrong password</h2>";
	      		break;

	      	case "badUserCredentials":
	      		echo "<h2 class='warning'>User user name is wrong or the user is not yet registered!</h2>";
	      		break;

	      	case "isBlocked":
	      		echo "<h2 class='warning'>Wait! You'll first need to login or register buddy!</h2>";
	      		break;
    	
  		};

  	};

// After checking for errors and eventually displaying any error messages we generate the login form
// Using Heredoc, to generate HTML form, store it into a variable and echo out the form. You can give it any name not just "THEFORM"; do no leave any spaces after the name!!!

if (isset($_GET['userName'])) {

	$myForm = <<<MYFORM

	  <p>Welcome to quote of the day!</p>
	  <h2>Please enter your user name and password to log in:</h2>

	  <form method='post' action='2-login-response.php'>         <!-- we send the user to the login response page, where his credentials are checked -->
	  <link rel="stylesheet" type="text/css" href="7-styles.css">

	      <label class='myLabel'>User Name</label><br> <input type='text' name='userName' id='username' placeholder='User Name' value='{$_GET["userName"]}'> <br>
	      <label class='myLabel'>Password</label><br>  <input type='password' name='password' id='password' placeholder='Password'> <br>
	      <input type='submit' class='mySubmit'>

	  </form>

MYFORM;

} else {


	$myForm = <<<MYFORM

	  <p>Welcome to quote of the day!</p>
	  <h2>Please enter your user name and password to log in:</h2>

	  <form method='post' action='2-login-response.php'>         
	  <link rel="stylesheet" type="text/css" href="7-styles.css">

	      <label class='myLabel'>User Name</label><br> <input type='text' name='userName' id='username' placeholder='User Name'> <br>
	      <label class='myLabel'>Password</label><br>  <input type='password' name='password' placeholder='Password'> <br>
	      <input type='submit' class='mySubmit'>

	  </form>

MYFORM;

	};


echo $myForm;
echo "<script>  document.getElementById('username').focus();  </script>";

	//at the end we check once more for errors so that we can focus on the filed neccesarry
  	if (isset($_GET['error'])) {

	  	switch ($_GET['error']) {

	  		case "badPassword":
	  		    echo "<script>  document.getElementById('password').focus();  </script>";
	      		break;

	      	case "badUserCredentials":
	      		echo "<script>  document.getElementById('username').focus();  </script>";
	      		break;

	      	case "isBlocked":
	      		echo "<script>  document.getElementById('username').focus();  </script>";
	      		break;
    	
  		};

  	};

};

?>

</main>

	</body>
</html>