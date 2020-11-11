<?php
require __DIR__ . '/../src/autoload.php';

$user = new user();

$firstname = $_POST['firstname'];
$insertion = $_POST['insertion'];
$lastname = $_POST['Lastname'];
$email = $_POST['email'];

//return a error if the input is empty
if (!empty($firstname) && !empty($lastname) && !empty($email)) {
	session_start();
	//update the user information
	if (preg_match("/^([a-zA-Z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $email)) {
		//Email is valid
		//Change the user information
		$user->updateUserInfo($_SESSION['id'], $firstname, $insertion, $lastname, $email);
	    header("location: ../dagboek.php");
	    //return to diary page
	}else{
		//Email is invalid
		$_SESSION['ERROR'] = "De ingevoerde Email is geen Email adres";
		header("location: ../dagboek.php");
		//return to diary page
	}
} else {
	//input is empty
	$_SESSION['ERROR'] = "Invoervelden zijn leeg";
	header("location: ../dagboek.php");
	 //return to diary page
}
?>