<?php
require __DIR__ . '/../src/autoload.php';

$user = new user();

session_start();
//check if the id exists
if (isset($_SESSION['id'])) {
	//Delete the user
	$user->deleteUser($_SESSION['id']);	
}
//Sign out code
unset($_SESSION['id']);

session_destroy();
//return to the home/signIn/signUp page
header("location: ../index.php");
?>