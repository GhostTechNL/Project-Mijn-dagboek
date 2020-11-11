<?php 

require __DIR__ . '/../src/database.php';
//G
$poststory = $_POST['story'];
$diaryid = $_POST['diarydata'];
//return a to the diary page if input is empty
if (!empty($poststory)) {
	if (!empty($diaryid)) {
		session_start();
		//puts the diary id into a array because the query function only accept arrays
		$insertpost = array(':story' => $poststory, ':storydate' => date("Y/m/d"));
		//Insert data into the tabel
		database::query("INSERT INTO `posts`(`post`, `datum`) VALUES (:story,:storydate)", $insertpost);
		//Get the last inserted id
		$lastinserted = database::getInsertedId();

		$postToDiary = array(':diaryid' => $diaryid, ':postid' => $lastinserted);
		//insert data into the tabel
		database::query("INSERT INTO `dagboeken_posts`(`id_dagboek`, `id_post`) VALUES (:diaryid,:postid)", $postToDiary);
		header("location: ../dagboek.php?diary=".$diaryid);
		exit();
	}
}
header("location: ../dagboek.php");

?>