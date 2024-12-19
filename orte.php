<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Orte', '#')));
	
	$orte = $c_ort->get_all();

?>
	
	<div class="row mb-4"> 
		<div class="col-md-12">
            <?php 
				$c_button->button_ort_anlegen();
			?>
		</div>
	</div>

	<?php if($orte != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Orte ('.$c_helper->get_size_of_array($orte).')'); ?>
					<div class="card-body">
						<?php include 'includes/table/table-orte.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php $c_html->get_footer(); ?>