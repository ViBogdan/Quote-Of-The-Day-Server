<?php
// Start the session
session_start();

?>

<!DOCTYPE html>
<html>
	
	<title>Quote of the day</title>
  <link href="https://fonts.googleapis.com/css?family=K2D" rel="stylesheet" type="text/css"> <!--importing the K2D font from Google Font API-->
  <link rel="stylesheet" type="text/css" href="7-styles.css">

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

      if (isset($_SESSION["isLoggedIn"])) {

        // remove all session variables, including isLoggedIn which permits access
        session_unset(); 

        // destroy the session 
        session_destroy(); 

        echo "<p> You have now been logged out! Have a great day! </p>";

      } else {

        echo "<p> You are not logged in yet! </p>";
  
      };

?>

  </main>

	</body>
</html>