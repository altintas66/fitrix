<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('SERVER_VERWALTEN');

	if(!isset($_GET['id'])) header('Location: '.$c_url->get_server_uebersicht());
	if(isset($_POST['btn_server_submit'])) {
		$c_server->update($_POST);
		$c_helper->redirect($c_url->get_server_bearbeiten($_POST['server_id']), 'Änderungen+erfolgreich+gespeichert&type=success');
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Server', $c_url->get_server_uebersicht()), array('Server bearbeiten', '#')));
	
	$buff = $c_server->get($_GET['id']);


	$button_title = 'Änderungen speichern';
  
?> 
	
	<div class="js_server_bearbeiten_wrapper">

		<form method="POST" action="" class="form-edit">
			<?php $c_form->input_hidden('server_id', $buff['server_id']); ?>
			<?php include 'includes/table/info/server.php'; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<?php $c_html->card_header('Server bearbeiten'); ?>
						<div class="card-body">
							<?php include 'includes/form/server.php'; ?>
						</div>
					</div>
				</div>
			</div>

			<?php 
				$c_html->sticky_footer(
					array(
						'btn_server_submit',
						$button_title
					)
				);
			?>
			
		</form>
			

		
	
	</div>

<?php
	$c_html->get_footer();
?>	
	
