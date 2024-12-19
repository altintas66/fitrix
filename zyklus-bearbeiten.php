<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(!isset($_GET['id'])) header('Location: '.$c_url->get_zyklus_uebersicht());
	if(isset($_POST['btn_zyklus_submit'])) {
		$c_zyklus->update($_POST);
		$c_helper->redirect($c_url->get_zyklus_bearbeiten($_POST['zyklus_id']), 'Änderungen+erfolgreich+gespeichert&type=success');
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Zyklen', $c_url->get_zyklus_uebersicht()), array('Zyklus bearbeiten', '#')));
	
	$buff = $c_zyklus->get($_GET['id']);


	$button_title = 'Änderungen speichern';
  
?> 
	
	<div class="js_zyklus_bearbeiten_wrapper">

		<form method="POST" action="" class="form-edit">
			<?php $c_form->input_hidden('zyklus_id', $buff['zyklus_id']); ?>
			<?php include 'includes/table/info/zyklus.php'; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<?php $c_html->card_header('Zyklus bearbeiten'); ?>
						<div class="card-body">
							<?php include 'includes/form/zyklus.php'; ?>
						</div>
					</div>
				</div>
			</div>

			<?php 
				$c_html->sticky_footer(
					array(
						'btn_zyklus_submit',
						$button_title
					)
				);
			?>
			
		</form>
			

		
	
	</div>

<?php
	$c_html->get_footer();
?>	
	
