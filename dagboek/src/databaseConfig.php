<?php
//=========================================
//Database settings
$db_server = "localhost";
$db_username = "root";
$db_password = "";
$db_database = "diary";
//Create a connection with the database.
database::connectToDatabase($db_server, $db_username, $db_password, $db_database);