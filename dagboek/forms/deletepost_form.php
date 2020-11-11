<?php 
require __DIR__ . '/../src/database.php';

$storyid = $_POST['story'];
$diaryid = $_POST['diary'];
//safety reasons
if (!empty($storyid)) {
	session_start();
	//puts the data in a array because select only accept arrays when is more then 1
	$datarray = array(':userid' => $_SESSION['id'],":diaryid" => $diaryid,':postid' => $storyid);

	$datacheck = database::select("SELECT story.datum FROM posts AS story
								LEFT JOIN dagboeken_posts AS D2P ON story.id_post = D2P.id_post
								LEFT JOIN gebruikers_dagboeken AS G2D ON D2P.id_dagboek = G2D.id_dagboek
								WHERE G2D.id_gebruiker = :userid AND D2P.id_dagboek = :diaryid AND story.id_post = :postid",
								$datarray);
	$datacheck = $datacheck->fetch(PDO::FETCH_ASSOC);
	//check if the diary exists
	if ($datacheck) {
		//puts the diary id into a array because the query function only accept arrays
		$postid = array(':postid' => $storyid);
		//Delete post
		database::query("DELETE FROM posts WHERE id_post = :postid", $postid);
		//Delete the link id between diary and diary_posts
		database::query("DELETE FROM dagboeken_posts WHERE id_post = :postid", $postid);
		//return to the diary where the user was
		header("location ../dagboek.php?diary=".$diaryid);
	}
}
//return to the diary page when story id & diary id input is empty
header("location: ../dagboek.php");
?>