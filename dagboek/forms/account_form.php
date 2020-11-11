<?php
if (isset($_POST['save'])) {
	//If user pressed the save button go to the update account form
	require 'updateaccount_form.php';
} elseif (isset($_POST['deleteaccount'])) {
	//If user pressed the delete account button go to delete account form
	require 'deleteaccount_form.php';
}else{
	//if none of these are pressed go to the diary page
	header("location: ../dagboek.php");
}
?>