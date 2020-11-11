<?php
require __DIR__ . '/databaseConfig.php';

//custom simple function get the data safe out and in the database
class database
{
	protected static $connection;
	public static $query_status = 0;

	//Create a connection to the database.
	public static function connectToDatabase($server, $username, $password, $database){

		try {
			$connection = new PDO("mysql:host=$server;dbname=$database", $username, $password);
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$connection = $connection;
		} catch (Exception $e) {
			//echo "Connection: failed <br>";
			//echo "Error: " . $e->getMessage();
		}
	}
	//use this function only when using select
	public static function select($query, $input = ""){
		$stmt = self::$connection->prepare($query);
		if (is_array($input)) {
			foreach ($input as $key => &$data) {
				$stmt->bindParam($key, $data);
			}
		}else{
			$stmt->bindParam(":value", $input);
		}
		$stmt->execute();
		return $stmt;
	}
	//use this function only when using insert, update, delete.
	public static function query($query, $array = array()){
		$stmt = self::$connection->prepare($query);
		foreach ($array as $key => &$data) {
			$stmt->bindParam($key, $data);
		}
		$stmt->execute();
	}
	//PDO::lastInsertId() does not always work
	public static function getInsertedId(){
		$insertId = self::$connection->lastInsertId();
		return $insertId;
	}
	//Close the connection
	public static function closeConnection(){
		self::$connection = null;
	}
}
/* =========================={ Example }==========================  */
//database::query("INSERT INTO `gebruikers`(`voornaam`,`tussenvoegsels`, `achternaam`, `email`, `wachtwoord`) VALUES (:voornaam, :tussenvoegsels, :achternaam, :email, :wachtwoord)", array(':voornaam' => "tester",':tussenvoegsels' => "testertest", ':achternaam' => "achtertest", ':email' => "Tester@gmail.com", ":wachtwoord" => "gaylord"));