<?php 
	echo $ddd;
	include dirname(__FILE__) .'/config/config.php';

	require_once dirname(__FILE__) .'/config/db.php';
	require_once dirname(__FILE__) .'/config/version.php';

	session_start();
	ob_start();
	
    require_once dirname(__FILE__) .'/controllers/init_controllers.php';
  


	if(
		(substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "login.php") &&
		(substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "passwort-vergessen.php") &&
        (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "angebot-vorschau.php") &&
		(substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "cronjob-abonnements.php") &&
		(substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "error.php")
	) {
		$c_login->session_check();
	} 