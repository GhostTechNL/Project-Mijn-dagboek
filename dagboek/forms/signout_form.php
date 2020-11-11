<?php
require __DIR__ . '/../src/autoload.php';

$user = new user();

$user->signOut();
//return to the home/index page when the user sign out
?>