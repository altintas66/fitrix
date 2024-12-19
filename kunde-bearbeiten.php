<?php
	include 'init.php';
	
	$c_permission->check_user_permission_redirect('KUNDEN_VERWALTEN');

	if(!isset($_GET['id'])) header('Location: '.$c_url->get_kunde_uebersicht());
	if(isset($_POST['btn_kunde_submit'])) {
		$c_kunde->update($_POST, $_FILES);
		$c_helper->redirect($c_url->get_kunde_bearbeiten($_POST['kunde_id']), 'Änderungen+erfolgreich+gespeichert&type=success');
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Kunden', $c_url->get_kunde_uebersicht()), array('Kunde bearbeiten', '#')));
	
	$buff = $c_kunde->get($_GET['id']);
	if($buff == null) $c_helper->redirect($c_url->get_kunde_uebersicht());
	$kunde_id = $buff['kunde_id'];

	$ansprechpartner = $c_ansprechpartner->get_all($kunde_id);

	$files = $c_datei_zuweisung->get_all($c_kunde->get_tablename(), $kunde_id);
	$anzahl_dateien = $c_helper->get_size_of_array($files);

	$button_title = 'Änderungen speichern';
  
?> 
	
	<div class="js_kunde_wrapper">

		<form method="POST" action="" enctype="multipart/form-data" class="form-edit">
			<?php $c_form->input_hidden('kunde_id', $kunde_id); ?>
			<?php include 'includes/table/info/kunde.php'; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="tabs">
						<?php 
							echo $c_html->get_tabs_navigation(array(
								'tabs-1' => 'Allgemeine Daten',
								'tabs-2' => 'Dateien',
								'tabs-3' => 'Ansprechpartner',
								'tabs-4' => 'Beiträge',
							));
						?>
						<div id="tabs-1">
							<?php include 'includes/form/kunde.php'; ?>
						</div>
						<div id="tabs-2">
							<?php $c_form->upload_area($c_kunde->get_tablename(), $files); ?>
						</div>
						<div id="tabs-3">
							<?php if($ansprechpartner != null) { ?>
								<div class="card card-table">
									<?php $c_html->card_header('Ansprechpartner'); ?>
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">
												<?php include 'includes/table/table-ansprechpartner.php'; ?>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
						<div id="tabs-4">
							<?php $c_form->beitraege($kunde_id, $c_kunde->get_tablename()); ?>
						</div>
					</div>
					
				</div>
			</div>

			<?php 
				$c_html->sticky_footer(
					array(
						'btn_kunde_submit',
						$button_title
					)
				);
			?>


		</form>

		
			

		
	
	</div>

<?php
	$c_form->modal_ansprechpartner_anlegen();
	$c_html->get_footer();
?>	
	
