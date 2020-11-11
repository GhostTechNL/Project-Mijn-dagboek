<?php
require __DIR__ . '/../src/autoload.php';

$database = new database();
/**
 * 
 */
class user extends database
{
//=========================== User ===========================
	public $userError;
	//Get the User information
	public function getUserInfo($user)
	{
		$result = database::select("SELECT `voornaam`, `tussenvoegsels`, `achternaam`, `email` 
									FROM `gebruikers` 
									WHERE `id_gebruiker` = :value LIMIT 1"
									,$user);
		$data = $result->fetch(PDO::FETCH_ASSOC);
		if ($data == true) {
			return $data;
		}else{
			return false;
		}
	}
	//Checks if the user account exist if true return valid. Using Email to find the account.
	public function AccountExists($email)
	{
		$result = database::select("SELECT `id_gebruiker`FROM `gebruikers` WHERE `email` = :value LIMIT 1", $email);
		$data = $result->fetch(PDO::FETCH_ASSOC);
		if ($data == true) {
			return true;
		}else{
			return false;
		}
	}
	//Get the access to the user account if true
	public function login($email, $password)
	{
		$result = database::select("SELECT `id_gebruiker`, `wachtwoord` FROM `gebruikers` WHERE `email` = :value LIMIT 1", $email);
		$data = $result->fetch(PDO::FETCH_ASSOC);
		//check if the email exists in the database
		if ($data == true) {
			//check if the password is the same as the input password
			$passwordcheck = password_verify($password, $data['wachtwoord']);
			if ($passwordcheck == true) {
				session_start();
				$_SESSION['id'] = $data['id_gebruiker'];

				unset($_SESSION['ERROR_LOGIN']);
				header("location: ../dagboek.php");	
			}else{
				//Password invalid
				session_start();
				$_SESSION['ERROR_LOGIN'] = "Wachtwoord is onjuist";
				header("location: ../index.php");
			}
		}else{
			//No account has been founded
			session_start();
			$_SESSION['ERROR_LOGIN'] = "Geen account bestaat met deze E-mail";
			header("location: ../index.php");
		}
	}
	//Sign Up a new user
	public function registration($firstname, $insertion = "", $lastname, $email, $password)
	{
		$data = database::select("SELECT `email` FROM `gebruikers` WHERE `email` = :value", $email);
		$checkdata = $data->fetch(PDO::FETCH_ASSOC);
		//check if the E-mail is already used
		if ($checkdata == false) {
			//Hash the password
			$hashpassword = password_hash($password, PASSWORD_DEFAULT);
			//Give the data a keyname for 
			$array = array(':voornaam' => $firstname,':tussenvoegsels' => $insertion, ':achternaam' => $lastname, ':email' => $email, ":wachtwoord" => $hashpassword);
			//Insert the data into the database
			database::query("INSERT INTO `gebruikers`(`voornaam`,`tussenvoegsels`, `achternaam`, `email`, `wachtwoord`) VALUES (:voornaam, :tussenvoegsels, :achternaam, :email, :wachtwoord)", $array);
			//Get the last Inserted Id
			session_start();
			$_SESSION['id'] = database::getInsertedId();
			//Account has been created
			header("location: ../dagboek.php");
		} else {
			//This E-mailadress is already used
			session_start();
			$_SESSION['ERROR_SIGNUP'] = "Dit E-mailadres is al geregistreer op dit account";
			header("location: ../index.php");
		}
	}
	//Destroy the user information.
	public function signOut()
	{
		session_start();
		$_SESSION = array();
		session_destroy();
		header("location: ../index.php");
	}
	//Check if the password is the same as in the database.
	public function passwordCheck($userid, $password)
	{
		$result = database::select("SELECT `wachtwoord` FROM `gebruikers` WHERE id_gebruiker = :value", $userid);
		$data = $result->fetch(PDO::FETCH_ASSOC);
		//hash the password
		$passwordcheck = password_verify($password, $data['wachtwoord']);
		if ($passwordcheck == true) {
			return true;
		}else{
			return false;
		}
	}
	//change user password
	public function changePassword($userid ,$oldpassword, $newpassword)
	{
		//check if the user exists and get the information
		$result = database::select("SELECT `wachtwoord` FROM `gebruikers` WHERE id_gebruiker = :value", $userid);
		$password = $result->fetch(PDO::FETCH_ASSOC);

		$passwordcheck = password_verify($oldpassword, $password['wachtwoord']);
		if ($passwordcheck == true) {
			session_start();
			//New password hash
			$newpasswordhash = password_hash($newpassword, PASSWORD_DEFAULT);
			//put the new information into a array
			$newdata = array(':newpassword' => $newpasswordhash, 'userid' => $userid);
			//send nuts to database
			database::query("UPDATE `gebruikers` SET `wachtwoord`= :newpassword WHERE `id_gebruiker` = :userid", $newdata);
			//unset the userid safety reasons
			unset($_SESSION['id']);
			//unset everything and destroy the current session
			session_destroy();
			//Go to the home page
			header("location: ../index.php");
		}else{
			//password invalid
			session_start();
			$_SESSION['PASSWORD_ERROR'] = "Het oude wachtwoord komt niet overeen";
			header("location: ../dagboek.php");
		}
	}
	//Update user information
	public function updateUserInfo($userid, $firstname, $insertion = "", $lastname, $email)
	{
		//put the data into a array
		$data = array(':voornaam' => $firstname, ':tussenvoegsel' => $insertion, ':achternaam' => $lastname, ':email' => $email, ':userid' => $userid);
		//Update the information
		database::query("UPDATE `gebruikers` SET 
			            `voornaam`= :voornaam,
			            `tussenvoegsels`= :tussenvoegsel,
			            `achternaam`= :achternaam,
			            `email`= :email
			            WHERE `id_gebruiker` = :userid",$data);
	}
	//Delete the user and diary & posts that are linked to the user.
	public function deleteUser($userid)
	{
		$user = array(':userid' => $userid);
		//Get every post that is linked with the user
		$resultPosts = database::select("SELECT posts.id_post FROM posts
								LEFT JOIN dagboeken_posts AS D2P ON posts.id_post = D2P.id_post
								LEFT JOIN gebruikers_dagboeken AS G2D ON D2P.id_dagboek = G2D.id_dagboek
								WHERE G2D.id_gebruiker = :userid",$user);
		$fetchpost = $resultPosts->fetchAll(PDO::FETCH_ASSOC);
		//Delete every post what is linked with the user
		foreach ($fetchpost as $key => $data) {
			$postid = array(':postid' => $data['id_post']);
			database::query("DELETE FROM posts WHERE id_post = :postid", $postid);
			
		}
		//Get the diary id and delete the diary that are attached to user
		$resultDiary = database::select("SELECT id_dagboek FROM `gebruikers_dagboeken` WHERE id_gebruiker = :userid",
										$user);
		$fetchDiary = $resultDiary->fetchAll(PDO::FETCH_ASSOC);
		//Delete every diary and link
		foreach ($fetchDiary as $key => $data) {
			$diary_id = array(':diaryid' => $data['id_dagboek']);

		    database::query("DELETE FROM dagboeken_posts WHERE id_dagboek = :diaryid", $diary_id);

		    database::query("DELETE FROM `dagboeken` WHERE id_dagboek = :diaryid",$diary_id);
		}
		//Delete all diary user links
		database::query("DELETE FROM `gebruikers_dagboeken` WHERE id_gebruiker = :userid",$user);
		//The last step is deleting the user account
		database::query("DELETE FROM `gebruikers` WHERE id_gebruiker = :userid",$user);
	}
}

?>