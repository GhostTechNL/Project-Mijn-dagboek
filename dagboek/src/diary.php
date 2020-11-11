<?php 
require __DIR__ . '/autoload.php';

$database = new database();
/**
 * 
 */
class diary extends database
{
//=========================== Diary ===========================
	//Get every diary that is linked with the user
	public function getDiary($user)
	{
		$result = database::select("SELECT COUNT(D2P.id_dagboek) AS postCountResult, Diary.naam, Diary.id_dagboek 
									FROM dagboeken AS Diary
									LEFT JOIN gebruikers_dagboeken AS G2D ON Diary.id_dagboek = G2D.id_dagboek
									LEFT JOIN dagboeken_posts AS D2P ON Diary.id_dagboek = D2P.id_dagboek
									WHERE G2D.id_gebruiker = :value GROUP BY Diary.id_dagboek",
									$user);
		$data = $result->fetchAll(PDO::FETCH_ASSOC);
		if ($data) {
			return $data;
		}else{
			return false;
		}
	}
	//Get a specific diary
	public function getOneDiary($user, $diary)
	{
		$diaryArray = array(':userid' => $user, ':diaryid' => $diary);
		$result = database::select("SELECT COUNT(D2P.id_dagboek) AS postCountResult, Diary.naam
									FROM dagboeken AS Diary
									LEFT JOIN gebruikers_dagboeken AS G2D ON Diary.id_dagboek = G2D.id_dagboek
									LEFT JOIN dagboeken_posts AS D2P ON Diary.id_dagboek = D2P.id_dagboek
									WHERE G2D.id_gebruiker = :userid AND Diary.id_dagboek = :diaryid 
									GROUP BY Diary.id_dagboek LIMIT 1",
									$diaryArray);
		$data = $result->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return $data;
		}else{
			return false;
		}
	}
	//Check if the diary exists
	public function diaryExists($user, $diary)
	{
		$diaryArray = array(':userid' => $user, ':diaryid' => $diary);
		$result = database::select("SELECT DB.naam FROM dagboeken AS DB
                                    LEFT JOIN gebruikers_dagboeken AS G2D ON DB.id_dagboek = G2D.id_dagboek
                                    WHERE G2D.id_gebruiker = :userid AND DB.id_dagboek = :diaryid",
                                    $diaryArray);
		$data = $result->fetchAll(PDO::FETCH_ASSOC);
		if ($data) {
			return true;
		}else{
			return false;
		}
	}
//=========================== Post ===========================
	//Get every post that is linked with the diary
	public function getDiaryPost($user, $diary)
	{	
		$postArray = array(':userid' => $user, ':diaryid' => $diary);
		$result = database::select("SELECT posts.post, posts.datum, posts.id_post
	    							FROM posts
									LEFT JOIN dagboeken_posts AS D2P ON posts.id_post = D2P.id_post
									LEFT JOIN gebruikers_dagboeken AS G2D ON D2P.id_dagboek = G2D.id_dagboek
									WHERE G2D.id_gebruiker = :userid AND D2P.id_dagboek = :diaryid ORDER BY posts.datum DESC
									",
									$postArray);
		$data = $result->fetchAll(PDO::FETCH_ASSOC);
		if ($data) {
			return $data;
		}else{
			return false;
		}
	}
	//Check if the post exists
	public function postExists($user, $diary, $post)
	{
		$postArray = array(':userid' => $user, ':diaryid' => $diary, ':postid' => $post);
		$result = database::select("SELECT posts.datum FROM posts
									 LEFT JOIN dagboeken_posts AS D2P ON posts.id_post = D2P.id_post
									 LEFT JOIN gebruikers_dagboeken AS G2D ON D2P.id_dagboek = G2D.id_dagboek
									 WHERE G2D.id_gebruiker = :userid AND D2P.id_dagboek = :diaryid AND posts.id_post = :postid",
									 $postArray);
		$data = $result->fetchAll(PDO::FETCH_ASSOC);
		if ($data) {
			return true;
		}else{
			return false;
		}
	}
	//Get the information to read the post
	public function getViewPost($user, $diary, $post)
	{
		$postArray = array(':userid' => $user, ':diaryid' => $diary, ':postid' => $post);
		$result = database::select("SELECT posts.post, posts.datum, Diary.naam FROM posts
									 LEFT JOIN dagboeken_posts AS D2P ON posts.id_post = D2P.id_post
									 LEFT JOIN dagboeken AS Diary ON D2P.id_dagboek = Diary.id_dagboek
									 LEFT JOIN gebruikers_dagboeken AS G2D ON D2P.id_dagboek = G2D.id_dagboek
									 WHERE G2D.id_gebruiker = :userid AND D2P.id_dagboek = :diaryid AND posts.id_post = :postid LIMIT 1",
									 $postArray);
		$data = $result->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return $data;
		}else{
			return false;
		}
	}
}


?>