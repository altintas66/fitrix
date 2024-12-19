<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('HOSTING_VERWALTEN');

	if(!isset($_GET['id'])) header('Location: '.$c_url->get_hosting_uebersicht());
	if(isset($_POST['btn_hosting_submit'])) {
		$c_hosting->update($_POST);
		$c_helper->redirect($c_url->get_hosting_bearbeiten($_POST['hosting_id']), 'Änderungen+erfolgreich+gespeichert&type=success');
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Hosting', $c_url->get_hosting_uebersicht()), array('Hosting bearbeiten', '#')));
	
	$buff = $c_hosting->get($_GET['id']);


	$button_title = 'Änderungen speichern';
  
?> 
	
	<div class="js_hosting_bearbeiten_wrapper">

		<form method="POST" action="" class="form-edit">
			<?php $c_form->input_hidden('hosting_id', $buff['hosting_id']); ?>
			<?php include 'includes/table/info/hosting.php'; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<?php $c_html->card_header('Hosting bearbeiten'); ?>
						<div class="card-body">
							<?php include 'includes/form/hosting.php'; ?>
						</div>
					</div>
				</div>
			</div>

			<?php 
				$c_html->sticky_footer(
					array(
						'btn_hosting_submit',
						$button_title
					)
				);
			?>
			
		</form>
			

		
	
	</div>

<?php
	$c_html->get_footer();
?>	
	
