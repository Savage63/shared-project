<?php
//Initialize the session
session_start();
 
//Removes all session variables
$_SESSION = array();
 
//End the session.
session_destroy();
 
//Sends you back to login page
header("location: login.php");
exit;
?>