<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('ARTIKEL_VERWALTEN');

	if(!isset($_GET['id'])) header('Location: '.$c_url->get_artikel_uebersicht());
	if(isset($_POST['btn_artikel_submit'])) {
		$c_artikel->update($_POST, $_FILES);
		$c_helper->redirect($c_url->get_artikel_bearbeiten($_POST['artikel_id']), 'Änderungen+erfolgreich+gespeichert&type=success');
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Artikel', $c_url->get_artikel_uebersicht()), array('Artikel bearbeiten', '#')));
	
	$buff = $c_artikel->get($_GET['id']);
	$artikel_id = $buff['artikel_id'];

	$button_title = 'Änderungen speichern';
  
?> 
	
	<div class="js_artikel_bearbeiten_wrapper">

		<form method="POST" action="" enctype="multipart/form-data" class="form-edit">
			<?php $c_form->input_hidden('artikel_id', $artikel_id); ?>
			<?php include 'includes/table/info/artikel.php'; ?>

			<div class="row">
				<div class="col-md-12">
				<div class="tabs">
						<?php 
							echo $c_html->get_tabs_navigation(array(
								'tabs-1' => 'Allgemeine Daten',
								'tabs-2' => 'Preise',
								'tabs-3' => 'Beiträge',
							));
						?>
						<div id="tabs-1">
							<?php include 'includes/form/artikel.php'; ?>
						</div>
						<div id="tabs-2">
							<?php include 'includes/form/artikel-preise.php'; ?>
						</div>
						<div id="tabs-3">
							<?php $c_form->beitraege($artikel_id, $c_artikel->get_tablename()); ?>
						</div>
					</div>

					<?php  ?>
				</div>
			</div>

			<?php 
				$c_html->sticky_footer(
					array(
						'btn_artikel_submit',
						$button_title
					)
				);
			?>
			
		</form>
		
	
	</div>

<?php
	$c_form->modal_artikel_preis_anlegen();
	$c_html->get_footer();
?>	
	
