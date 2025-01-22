<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('KUNDEN_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Kunden', '#'))); 
	

	$kunden = $c_kunde->get_all(
		$status = '', 
		$join_rechnung = false, 
		1000
	);

	$anzahl_kunden = $c_kunde->get_anzahl_kunden();

	$filter_arten= array(
		'Aktive Kunden anzeigen'       => 'aktiv',
		'Deaktive Kunden anzeigen'	   => 'deaktiv',
		'Alle Kunden anzeigen'         => 'alle'
	);

?>
	
	<div class="js_kunde_uebersicht_wrapper" data-anzahl-kunden="<?php echo $anzahl_kunden; ?>">

		<div class="row mb-4"> 
			<div class="col-md-12">
				<?php 
					$c_button->button_kunde_anlegen();
				?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<?php 
					$c_form->kunde(
						$wrapper = true, 
						$value = '', 
						$field_name = 'kunde_id', 
						$label = 'Kunde', 
						$required = true, 
						$alle_kunden = true
					);
				?>
			</div>
		</div>
		
		<?php if($kunden != NULL) { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="card card-table">
						<?php
							$c_html->card_header(
								$c_table_helper->get_card_title_mit_verfuegbarkeit(
									'Kunden',
									'kunde'
								)  
							);?> 
						<div class="card-body">
							<?php include 'includes/table/table-kunden.php'; ?>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

	</div>

   
<?php $c_html->get_footer(); ?>