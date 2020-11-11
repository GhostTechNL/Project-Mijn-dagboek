<?php
require __DIR__ . '/../src/autoload.php';

$user = new user();

$firstname = $_POST['firstname'];
$insertion = $_POST['insertion'];
$lastname = $_POST['Lastname'];

$email = $_POST['email'];
$password = $_POST['password'];
$passwordrepeat = $_POST['passwordrepeat'];

//if the required are empty return a error
if (empty($firstname) && empty($lastname) && empty($email) && empty($password) && empty($passwordrepeat)) {
	//input are empty
	session_start();
	$_SESSION['ERROR_SIGNUP'] = "Invoervelden zijn leeg";
	header("location: ../index.php");
	exit();
	//return to home/inlog page
} elseif (!preg_match("/^([a-zA-Z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $email)) {
	//Input email is invalid
	session_start();
	$_SESSION['ERROR_SIGNUP'] = "De ingevoerde Email is geen Email adres";
	header("location: ../index.php");
	exit();
	//return to home/inlog page
} elseif (!preg_match("/^[a-zA-Z0-9!@#$%]*$/",$password)) {
	//password contains illegal characters
	session_start();
	$_SESSION['ERROR_SIGNUP'] = "Wachtwoord bevat illegalen karakters";
	header("location: ../index.php");
	//return to home/inlog page
} elseif (!preg_match("/^[a-zA-Z0-9!@#$%]{8,}$/",$password)) {
	//password must >= 8 
	session_start();
	$_SESSION['ERROR_SIGNUP'] = "Wachtwoord moet minimaal uit 8 karakters bestaan";
	header("location: ../index.php");
	exit();
	//return to home/inlog page
}else{
	if ($password !== $passwordrepeat) {
		//Password aren't the same
		$_SESSION['ERROR_SIGNUP'] = "Herhaal wachtwoord komt niet overeen met wachtwoord";
		header("location: ../index.php");	
		echo "Error: iets bij 5de if";
		exit();
		//return to home/inlog page
	} else {
		//create a account if email isn't used already
		$user->registration($firstname, $insertion, $lastname, $email, $password);
		exit();
		//if registration is successful proceed to diary page
	}
}

	


