<?php
	global $config, $version, $c_user, $user;
	$user = $c_user->get($_SESSION['id']);
?>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title><?php echo $config['site_title']; ?> - Admin Panel</title> 
	<link rel="icon" type="image/png" href="<?php echo $config['httpsurl']; ?>/assets/img/favicon/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="<?php echo $config['httpsurl']; ?>/assets/img/favicon/favicon.svg" />
	<link rel="shortcut icon" href="<?php echo $config['httpsurl']; ?>/assets/img/favicon/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $config['httpsurl']; ?>/assets/img/favicon/apple-touch-icon.png" />
	<link rel="manifest" href="<?php echo $config['httpsurl']; ?>/assets/img/favicon/site.webmanifest" />
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128&family=Roboto&display=swap" rel="stylesheet">

	<?php $this->get_css(); ?>
	<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->

	

</head>