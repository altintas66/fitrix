<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(!isset($_GET['id'])) header('Location: '.$c_url->get_einheit_uebersicht());
	if(isset($_POST['btn_einheit_submit'])) {
		$c_einheit->update($_POST);
		$c_helper->redirect($c_url->get_einheit_bearbeiten($_POST['einheit_id']), 'Änderungen+erfolgreich+gespeichert&type=success');
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Einheiten', $c_url->get_einheit_uebersicht()), array('Einheit bearbeiten', '#')));
	
	$buff = $c_einheit->get($_GET['id']);


	$button_title = 'Änderungen speichern';
  
?> 
	
	<div class="js_einheit_bearbeiten_wrapper">

		<form method="POST" action="" class="form-edit">
			<?php $c_form->input_hidden('einheit_id', $buff['einheit_id']); ?>
			<?php include 'includes/table/info/einheit.php'; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<?php $c_html->card_header('Einheit bearbeiten'); ?>
						<div class="card-body">
							<?php include 'includes/form/einheit.php'; ?>
						</div>
					</div>
				</div>
			</div>

			<?php 
				$c_html->sticky_footer(
					array(
						'btn_einheit_submit',
						$button_title
					)
				);
			?>
			
		</form>
			

		
	
	</div>

<?php
	$c_html->get_footer();
?>	
	
