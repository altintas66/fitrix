<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('RECHNUNGEN_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Rechnungen', '#')));

	$rechnungen = $c_rechnung->get_all();
	$einstellungen = $c_einstellungen->get_all();

	$gesamt_zahlung_monat = $c_statistik->get_gesamt_zahlung_monat();
	$anzahl_bezahlte_rgs  = $c_statistik->get_anzahl_bezahlte_rechnungen();
	$anzahl_faellige_rgs  = $c_statistik->get_anzahl_faellige_rechnungen_monat();

?>
	
	<div class="row mb-4"> 
		<div class="col-md-12">
			<div class="button-group">
				<?php 
					$c_button->button_rechnung_anlegen();
					if($einstellungen['quality_hosting_rechnungen_ausblenden'] == '0') { 
						$c_button->button_quality_hosting_rechnung_anlegen();
					}
				?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-6 col-md-6">
			<?php 
				$c_html->statistik_widget(
					'Fällige Rechnungen diesen Monat', 
					$anzahl_faellige_rgs, 
					'fe-file', 
					'warning'
				); 
			?>
		</div>
		<div class="col-xs-6 col-md-6">
			<?php 
				$c_html->statistik_widget(
					'Bezahlte Rechnungen diesen Monat', 
					$c_html->waehrung($gesamt_zahlung_monat).' ('.$anzahl_bezahlte_rgs.')', 
					'fa fa-eur', 
					'warning'
					); 
				?>
		</div>
	</div> 
	
	<div class="row">
		<div class="col-md-12">
			<?php $c_form->freitext_suche_filter('search-input-rechnung', $c_rechnung->get_status()); ?>
		</div>
	</div>

	<?php if($rechnungen != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header(
								$c_table_helper->get_card_title_mit_verfuegbarkeit(
									'Rechnungen',
									'rechnung'
								)  
							);?>
					<div class="card-body">
						<?php include 'includes/table/table-rechnungen.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php 
    $c_form->modal_rechnung_anlegen();
	$c_html->get_footer(); 
?> 