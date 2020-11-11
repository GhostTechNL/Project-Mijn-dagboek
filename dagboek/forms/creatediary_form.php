<?php 

require __DIR__ . '/../src/database.php';

$diaryname = $_POST['diaryName'];
//
if (!empty($diaryname)) {
	//puts the diary id into a array because the query function only accept arrays
	$insertdiary = array(':naam' => $diaryname);
	//Insert data into the tabel
	database::query("INSERT INTO `dagboeken`(`naam`) VALUES (:naam)", $insertdiary);
	//Get the user id
	$lastinserted = database::getInsertedId();
	session_start();
	//Get the userid from the session
    $userid = $_SESSION['id'];

    $usertodiary = array(':userid' => $userid, ':diaryid' => $lastinserted);
    //Insert data into the tabel
	database::query("INSERT INTO `gebruikers_dagboeken`(`id_gebruiker`, `id_dagboek`) VALUES (:userid,:diaryid)", $usertodiary);
}
//return to the diary page
header("location: ../dagboek.php");

?>
