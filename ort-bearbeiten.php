<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(!isset($_GET['id'])) header('Location: '.$c_url->get_ort_uebersicht());
	if(isset($_POST['btn_ort_submit'])) {
		$c_ort->update($_POST);
		$c_helper->redirect($c_url->get_ort_bearbeiten($_POST['ort_id']), 'Änderungen+erfolgreich+gespeichert&type=success');
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Orte', $c_url->get_ort_uebersicht()), array('Ort bearbeiten', '#')));
	
	$buff = $c_ort->get($_GET['id']);


	$button_title = 'Änderungen speichern';
  
?> 
	
	<div class="js_ort_bearbeiten_wrapper">

		<form method="POST" action="" class="form-edit">
			<?php $c_form->input_hidden('ort_id', $buff['ort_id']); ?>
			<?php include 'includes/table/info/ort.php'; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<?php $c_html->card_header('Ort bearbeiten'); ?>
						<div class="card-body">
							<?php include 'includes/form/ort.php'; ?>
						</div>
					</div>
				</div>
			</div>

			<?php 
				$c_html->sticky_footer(
					array(
						'btn_ort_submit',
						$button_title
					)
				);
			?>
			
		</form>
			

		
	
	</div>

<?php
	$c_html->get_footer();
?>	
	
