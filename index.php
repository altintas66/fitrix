<?php

	include 'init.php';
	$c_html->get_header();
	global $dashboard_monats_statistik, $dashboard_jahr, $user;
	
	if(isset($_GET['jahr'])) $dashboard_jahr = $_GET['jahr'];
	else $dashboard_jahr = date('Y');
	
	$dashboard_monats_statistik = $c_statistik->get_monats_statistik($dashboard_jahr);
	$letzte_user = $c_user->get_letzte_user();

	$zahlungen_gesamt_monat             = $c_rechnung_zahlung->get_zahlungsbetrag_summe(date('Y'), date('m'));
	$ausstehende_gesamt_rechnungssumme  = $c_rechnung->get_ausstehende_gesamt_rechnungssumme();
	$anzahl_offene_rechnungen           = $c_rechnung->get_anzahl_offene_rechnungen();

?>

	<div class="js_dashboard_wrapper">
 
		<div class="row justify-content-center">
			<div class="col-md-10">

				
				<div class="card card_1">
					<?php $c_html->card_header('Herzlich Willkommen'); ?>
					<div class="card-body">
						<h4>Hallo, <?php echo $user['vorname']; ?> <?php echo $user['nachname']; ?>!</h4>
						<p>
							Willkommen zu FITRIX. Deine letzte Aktivität<br>
							war am <?php echo $c_helper->german_date($user['letzter_login']); ?>.
						</p>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<?php 
							$c_html->statistik_widget(
								'Zahlungseingang '.$c_helper->get_monat_label(date('m')), 
								$c_html->waehrung($zahlungen_gesamt_monat), 
								'fa fa-eur', 
								'success'
							);
						?>
					</div>
					<div class="col-md-4">
						<?php 
							$c_html->statistik_widget(
								'Ausstehend', 
								$c_html->waehrung($ausstehende_gesamt_rechnungssumme), 
								'fa fa-info', 
								'danger'
							);
						?>
					</div>
					<div class="col-md-4">
						<?php 
							$c_html->statistik_widget(
								'Offene Rechnungen', 
								$anzahl_offene_rechnungen['offen'].' / '.$anzahl_offene_rechnungen['alle'], 
								'fa fa-info-circle', 
								'warning'
							);
						?>
					</div>
				</div>
		
				<div class="card card-table same-height">
					<?php $c_html->card_header('Letzte Aktivitäten'); ?>
					<div class="card-body">
						<?php include 'includes/table/table-letzte-user.php'; ?>
					</div>
				</div>
		
				<div class="card">
					<?php $c_html->card_header('Filter'); ?>
					<div class="card-body">
						<div class="row">
							<div class="col-md-8">
								<?php 
									$c_form->rechnung_jahr();
								?>
							</div>
							<div class="col-md-4">
								<label>&nbsp;</label>
								<?php 
									$c_form->button(
										'btn_submit_dashboard_filter', 
										'Filtern',
										'btn btn-primary btn-block',
										true
									);
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<?php $c_html->card_header('Rechnungsausgang '.$dashboard_jahr); ?>
					<div class="card-body">
						<div id="chart_rechnungsausgang"></div>
					</div>
				</div> 

				<div class="card">
					<?php $c_html->card_header('Zahlungseingang '.$dashboard_jahr); ?>
					<div class="card-body">
						<div id="chart_zahlungseingang"></div>
					</div>
				</div>


			</div>
		</div>

	</div> 

	
<?php 
	$c_html->get_footer(); 
?>