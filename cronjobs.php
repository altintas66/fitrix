<?php
	include 'init.php';

	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Cronjobs', '#')));
	

	$cronjobs = $c_cronjob->get_all();
	
?>
	
	<div class="row mb-20">
		<div class="col-md-12">
			<div class="button-row">
				<?php 
					$c_button->cronjob_abo_rechnungen_erstellen();
				?>
			</div>
		</div>
	</div>


	
	<?php if($cronjobs != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Cronjobs ('.$c_helper->get_size_of_array($cronjobs).')'); ?>
					<div class="card-body">
						<?php include 'includes/table/table-cronjobs.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php $c_html->get_footer(); ?>