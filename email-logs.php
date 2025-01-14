<?php
	include 'init.php';

	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle E-Mail Logs', '#')));
	

	$email_logs = $c_email_log->get_all();
	
?>

	
	<?php if($email_logs != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('E-Mail Logs ('.$c_helper->get_size_of_array($email_logs).')'); ?>
					<div class="card-body">
						<?php include 'includes/table/table-alle-email-logs.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php $c_html->get_footer(); ?>