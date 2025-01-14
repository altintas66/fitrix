<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('ARTIKEL_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Artikel', '#')));
	

	$artikel = $c_artikel->get_all();

	
	
?>
	
	<div class="row mb-4"> 
		<div class="col-md-12">
            <?php 
				$c_button->button_artikel_anlegen();
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php $c_form->freitext_suche_filter('search-input-artikel', $c_artikel->get_status()); ?>
		</div>
	</div>

	<?php if($artikel != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php 
						$c_html->card_header(
							$c_table_helper->get_card_title_mit_verfuegbarkeit(
								'Artikel',
								'artikel'
							)  
						);?>
					<div class="card-body">
						<?php include 'includes/table/table-artikel.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php $c_html->get_footer(); ?>