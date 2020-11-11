<?php
require __DIR__ . '/../src/autoload.php';

$user = new user();

$oldpassword = $_POST['oldpassword'];
$newpassword = $_POST['newpassword'];
$repeatnewpassword = $_POST['repeatnewpassword'];

//Return a error if the input is empty
if (!empty($oldpassword) && !empty($newpassword) && !empty($repeatnewpassword)) {
	if ($newpassword !== $repeatnewpassword) {
		//password aren't the same
		session_start();
		$_SESSION['PASSWORD_ERROR'] = "Herhaal wachtwoord komt niet overeen met nieuw wachtwoord";
		header("location: ../dagboek.php");	
		//return to the diary page.
	} else {
		if (preg_match("/^[a-zA-Z0-9!@#$%]*$/",$newpassword)) {
			if(preg_match("/^[a-zA-Z0-9!@#$%]{8,}$/",$newpassword)){
				session_start();
				//change the password
				$user->changePassword($_SESSION['id'], $oldpassword, $newpassword);
			}else{
				//return a error if password is smaller then 8 
				session_start();
				$_SESSION['PASSWORD_ERROR'] = "Wachtwoord moet minimaal uit 8 karakters bestaan";
				header("location: ../dagboek.php");
				//return to the diary page.
			}
		}else{
			//password contains illegal characters
			session_start();
			$_SESSION['PASSWORD_ERROR'] = "Wachtwoord bevat illegalen karakters";
			header("location: ../dagboek.php");
			//return to the diary page.
		}
	}
} else {
	//empty input
	session_start();
	$_SESSION['PASSWORD_ERROR'] = "Invoervelden zijn leeg";
	header("location: ../dagboek.php");
	//return to the diary page.
}