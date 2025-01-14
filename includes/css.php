<?php 
	global $config, $version, $c_user;
	$color_css = 'color_light.css';
	$user = $c_user->get($_SESSION['id']);
?>	


	<link rel="stylesheet" href="<?php echo $config['httpsurl']; ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $config['httpsurl']; ?>assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo $config['httpsurl']; ?>assets/css/feathericon.min.css">
	<link rel="stylesheet" href="<?php echo $config['httpsurl']; ?>assets/plugins/html5imageupload/demo.html5imageupload.css">
	<link rel="stylesheet" href="<?php echo $config['httpsurl']; ?>assets/plugins/datetimepicker/jquery.datetimepicker.min.css">
	<link rel="stylesheet" href="<?php echo $config['httpsurl']; ?>assets/plugins/summernote/summernote.css">
	<link rel="stylesheet" href="<?php echo $config['httpsurl']; ?>assets/plugins/select2/select2.min.css">
	<link rel="stylesheet" href="<?php echo $config['httpsurl']; ?>assets/plugins/toastr/toastr.min.css">
	<link rel="stylesheet" href="<?php echo $config['httpsurl']; ?>assets/plugins/datatables/datatables.min.css">
	<link rel="stylesheet" href="<?php echo $config['httpsurl']; ?>assets/plugins/apexcharts/apexcharts.css">
	
	
	<link rel="stylesheet" href="<?php echo $config['httpsurl']; ?>assets/css/jquery-ui.css">
	
	<link rel="stylesheet" href="assets/css/style.css?=<?php echo $version['nummer']; ?>">
	<link rel="stylesheet" href="assets/css/color.php?vers=<?php echo $version['nummer']; ?>&mode=<?php echo $user['theme_mode']; ?>">
	