<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('ANGEBOTE_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Angebote', '#')));
	

	$angebote = $c_angebot->get_all();

	

?> 
	
	<div class="row mb-4"> 
		<div class="col-md-12">
            <?php 
				$c_button->button_angebot_anlegen();
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php $c_form->freitext_suche_filter('search-input-angebot', $c_angebot->get_status()); ?>
		</div>
	</div>
	
	<?php if($angebote != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header(
								$c_table_helper->get_card_title_mit_verfuegbarkeit(
									'Angebote',
									'angebot'
								)
							); ?>
					<div class="card-body">
						<?php include 'includes/table/table-angebote.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php 
	$c_form->modal_angebot_anlegen();
	$c_html->get_footer(); 
?>