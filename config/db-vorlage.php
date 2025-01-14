<?php	
	//Datenbank Einstellungen (bitte nicht in GIT versionieren)
	global $db_con;
	$db_con = array(
		'host'     => 'HOST',
		'user'     => 'DB_USER',
		'passwort' => 'DB_PASSWORD',
		'database' => 'DATABASE_NAME'
	);
	
	global $link;
	$link = mysqli_connect($db_con['host'], $db_con['user'], $db_con['passwort']);
	mysqli_query($link, "SET NAMES 'utf8'");
	if(!$link) die('Failed to connect to server: ' . mysqli_error());
	$db = mysqli_select_db($link, $db_con['database']);
	if(!$db) die("Unable to select database");