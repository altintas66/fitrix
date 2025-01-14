<?php 
	global $config;

	

	
	$config['firmenname']             = 'INOYA Altintas & Sahin GbR';
	$config['login_bg']               = $config['httpsurl'].'upload/inoya-duesseldorf-internetagentur-2560x1337.png';
	$config['login_logo']             = $config['httpsurl'].'upload/inoya-logo.png';

   
	$config['site_path']              = 'fitrix.inoya.cloud';	
    $config['siteurl']                = '//'.$config['site_path'].'/';	
	$config['httpsurl']               = 'https:'.$config['siteurl'];
	$config['zammad_auth_thoken']     = '4RvaF7p2LBUBE3w-arKZOEDmv8LsdLlyJQhGFHXlid_NZjxoXkjqtRlvKSxwRv8R';
	$config['zammad_url']             = 'https://zammad.inoya.cloud/';


	//45yAz6uL_P4gsQ1RZQ5r-u66nkLDGymg6ES-4mF1ghl54pQbqt5pZ4NwsxN6fpYl
	$config['debug']                  = false;
	
    if($config['debug'] == true) {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	} else {
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
		error_reporting(E_ERROR | E_PARSE);
	}




