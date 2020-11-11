<?php
require __DIR__ . '/../src/autoload.php';

$user = new user();

$email = $_POST['email'];
$password = $_POST['password'];

//return a error if input is empty
if (!empty($email)) {
	if (!empty($password)) {
		//Check if the input Email adres a valid Email adres is.
		if (preg_match("/^([a-zA-Z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $email)) {
			if (preg_match("/^[a-zA-Z0-9!@#$%]*$/", $password)) {
				//Login the user if the data valid
				$user->login($email,$password);
				//if data is true go the diary page
			}else{
				//Password contains illegal charaters
				session_start();
				$_SESSION['ERROR_LOGIN'] = "Wachtwoord bevat illegalen karakters";
				header("location: ../index.php");	
				//return to home/inlog page
			}
		}else{
			//Email is invalid
			session_start();
			$_SESSION['ERROR_LOGIN'] = "De ingevoerde Email is geen Email adress";
			header("location: ../index.php");
			//return to home page
		}
	} else {
		//Password input is empty
		session_start();
		$_SESSION['ERROR_LOGIN'] = "Wachtwoord veld is leeg";
		header("location: ../index.php");
		//return to home/inlog page
	}
} else {
	//Email input is empty
	session_start();
	$_SESSION['ERROR_LOGIN'] = "E-mail velt is leeg";
	header("location: ../index.php");
	//return to home/inlog page
}



