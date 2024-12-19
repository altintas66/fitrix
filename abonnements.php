<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('ABONNEMENT_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Abonnements', '#')));
	

	$abonnements             = $c_abonnement->get_all();
	$abonnement_daten        = $c_cache->get_abonnement_daten();
	$gesamt_umsatz_pro_monat = 0;

?> 
	
	<div class="row mb-4"> 
		<div class="col-md-12">
            <?php 
				$c_button->button_abonnement_anlegen();
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<?php $c_form->freitext_suche_filter('search-input-abonnement', $c_abonnement->get_status()); ?>
		</div>
	</div>
	
	<?php if($abonnements != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php
						$c_html->card_header(
							$c_table_helper->get_card_title_mit_verfuegbarkeit(
								'Abonnements',
								'abonnement'
							)  
						);?>
					<div class="card-body">
						<?php include 'includes/table/table-abonnements.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php 
	$c_form->modal_abonnement_anlegen();
	$c_html->get_footer(); 
?>