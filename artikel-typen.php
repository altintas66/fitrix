<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Artikel Typen', '#')));
	
	$artikel_typen = $c_artikel_typ->get_all();

?>
	
	<div class="row mb-4"> 
		<div class="col-md-12">
            <?php 
				$c_button->button_artikel_typ_anlegen();
			?>
		</div>
	</div>

	<?php if($artikel_typen != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Artikel Typen ('.$c_helper->get_size_of_array($artikel_typen).')'); ?>
					<div class="card-body">
						<?php include 'includes/table/table-artikel-typen.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php $c_html->get_footer(); ?>