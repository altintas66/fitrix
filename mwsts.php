<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('MwST', '#')));
	

	$mwsts = $c_mwst->get_all();
	

?>
	
	<div class="row mb-4"> 
		<div class="col-md-12">
            <?php 
				$c_button->button_mwst_anlegen();
			?>
		</div>
	</div>

	
	
	<?php if($mwsts != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Mehrwertsteuersätze ('.$c_helper->get_size_of_array($mwsts).')'); ?>
					<div class="card-body">
						<?php include 'includes/table/table-mwsts.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php $c_html->get_footer(); ?>