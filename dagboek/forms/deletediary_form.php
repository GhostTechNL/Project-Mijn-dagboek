<?php

require __DIR__ . '/../src/database.php';

$diaryId = $_POST['diary'];

//safety reasons
if (!empty($diaryId)) {
	session_start();
	//puts the data in a array because select only accept arrays when is more then 1
	$diary = array(':userid' => $_SESSION['id'], ':diaryid' => $diaryId);

	$datacheck = database::select("
				SELECT Diary.naam FROM dagboeken AS Diary
				LEFT JOIN gebruikers_dagboeken AS G2D ON Diary.id_dagboek = G2D.id_dagboek
				LEFT JOIN dagboeken_posts AS D2P ON Diary.id_dagboek = D2P.id_dagboek
				WHERE G2D.id_gebruiker = :userid AND Diary.id_dagboek = :diaryid",$diary);
	$fetchdatacheck = $datacheck->fetch(PDO::FETCH_ASSOC);
	//check if the diary exists
	if ($fetchdatacheck) {
		//Get all the post id that are linked with diary
		$posts = database::select("SELECT posts.id_post FROM posts
								LEFT JOIN dagboeken_posts AS D2P ON posts.id_post = D2P.id_post
								LEFT JOIN gebruikers_dagboeken AS G2D ON D2P.id_dagboek = G2D.id_dagboek
								WHERE G2D.id_gebruiker = :userid AND D2P.id_dagboek = :diaryid",$diary);
		$fetchpost = $posts->fetchAll(PDO::FETCH_ASSOC);
		//Delete every post that is linked with diary
		foreach ($fetchpost as $key => $data) {
			$postid = array(':postid' => $data['id_post']);
			database::query("DELETE FROM posts WHERE id_post = :postid", $postid);
			
		}
		//put the diary id into a array because the query function only accept arrays
	    $diary_id = array(':diaryid' => $diaryId);
	    //Delete the link id between diary and diary_posts
		database::query("DELETE FROM dagboeken_posts WHERE id_dagboek = :diaryid", $diary_id);
		//Delete the link id between user and the diary
		database::query("DELETE FROM `gebruikers_dagboeken` WHERE id_dagboek = :diaryid",$diary_id);
		//Delete the diary
		database::query("DELETE FROM `dagboeken` WHERE id_dagboek = :diaryid",$diary_id);
	}
}
//return to the diary page
header("location: ../dagboek.php");
?>