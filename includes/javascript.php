<?php 
	global $config, $version, $einstellungen;


?>

	<script src="//jquery-ui.googlecode.com/svn/tags/latest/ui/minified/i18n/jquery-ui-i18n.min.js"></script>
	

	
	<script src="<?php echo $config['httpsurl']; ?>assets/js/jquery-3.2.1.min.js"></script>

	<script src="<?php echo $config['httpsurl']; ?>assets/js/jquery-ui.min.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/js/jquery.ui.widget.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/js/moment.min.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/js/popper.min.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/plugins/summernote/summernote.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/plugins/select2/select2.min.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/plugins/select2/de.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/plugins/toastr/toastr.min.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/plugins/html5imageupload/html5imageupload.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/plugins/autoNumeric/autoNumeric-1.8.3.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/plugins/datatables/datatables.min.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/plugins/datatables/datetime-moment.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/plugins/apexcharts/apexcharts.js"></script>
	

	<script src="<?php echo $config['httpsurl']; ?>assets/js/theme.js"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/js/form.js?vers=<?php echo $version['nummer']; ?>"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/js/suche.js?vers=<?php echo $version['nummer']; ?>"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/js/javascript.js?vers=<?php echo $version['nummer']; ?>"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/js/rechnung.js?vers=<?php echo $version['nummer']; ?>"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/js/angebot.js?vers=<?php echo $version['nummer']; ?>"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/js/abonnement.js?vers=<?php echo $version['nummer']; ?>"></script>
	<script src="<?php echo $config['httpsurl']; ?>assets/js/mahnung.js?vers=<?php echo $version['nummer']; ?>"></script>
	<script src="<?php echo $config['httpsurl']; ?>config/custom.js?vers=<?php echo $version['nummer']; ?>"></script>
	
	<?php 
		
		if($_SERVER['REQUEST_URI'] == '/') { 
			include 'dashboard-javascript.php';
		}
	?>


	