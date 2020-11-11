<?php 
require __DIR__ . '/../src/database.php';
//G
$diaryid = $_POST['diary'];
$postid = $_POST['post'];
$poststory = $_POST['story'];

//return to diary page if input is empty
if (!empty($diaryid) && !empty($postid)) {
	if (!empty($poststory)) {
		session_start();

		$datarray = array(':userid' => $_SESSION['id'],":diaryid" => $diaryid,':postid' => $postid);

		$datacheck = database::select("SELECT story.datum FROM posts AS story
								LEFT JOIN dagboeken_posts AS D2P ON story.id_post = D2P.id_post
								LEFT JOIN gebruikers_dagboeken AS G2D ON D2P.id_dagboek = G2D.id_dagboek
								WHERE G2D.id_gebruiker = :userid AND D2P.id_dagboek = :diaryid AND story.id_post = :postid",
								$datarray);
		$datacheck = $datacheck->fetch(PDO::FETCH_ASSOC);
		//check if the diary and post exists
		if ($datacheck) {
			//put the data in a array
			$Update = array(':postid' => $postid, ':story' => $poststory);
			//Update the post
			database::query("UPDATE posts SET post = :story WHERE id_post = :postid",$Update);
			//return to back to diary page with data where the user was
			header("location: ../dagboek.php?diary=".$diaryid."&post=".$postid);
		}
	}else{
		//if the post input is empty return to the diary page
		header("location: ../dagboek.php");
	}
}else{
	//if the diary id and postid are empty return to diary page
	header("location: ../dagboek.php");
}



?>