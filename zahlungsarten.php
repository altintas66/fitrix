<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Zahlungsarten', '#')));
	

	$zahlungsarten = $c_zahlungsart->get_all();
	

?>
	
	<div class="row mb-4"> 
		<div class="col-md-12">
            <?php 
				$c_button->button_zahlungsart_anlegen();
			?>
		</div>
	</div>


	<?php if($zahlungsarten != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Zahlungsarten ('.$c_helper->get_size_of_array($zahlungsarten).')'); ?>
					<div class="card-body">
						<?php include 'includes/table/table-zahlungsarten.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php $c_html->get_footer(); ?>