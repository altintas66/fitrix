<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('USER_VERWALTEN');

	if(!isset($_GET['id'])) header('Location: '.$c_url->get_user_uebersicht());
	if(isset($_POST['btn_user_submit'])) {
		$c_user->update($_POST, $_FILES);
		$c_helper->redirect($c_url->get_user_bearbeiten($_POST['user_id']), 'Änderungen+erfolgreich+gespeichert&type=success');
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('User', $c_url->get_user_uebersicht()), array('User bearbeiten', '#')));
	
	$buff = $c_user->get($_GET['id']);


	$button_title = 'Änderungen speichern';
  
?> 
	
	<div class="js_user_bearbeiten_wrapper">

		<form method="POST" action="" enctype="multipart/form-data" class="form-edit">
			<?php $c_form->input_hidden('user_id', $buff['user_id']); ?>
			<?php include 'includes/table/info/user.php'; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<?php $c_html->card_header('User bearbeiten'); ?>
						<div class="card-body">
							<?php include 'includes/form/user.php'; ?>
						</div>
					</div>
				</div>
			</div>

			<?php 
				$c_html->sticky_footer(
					array(
						'btn_user_submit',
						$button_title
					)
				);
			?>
			
		</form>
			

		
	
	</div>

<?php
	$c_html->get_footer();
?>	
	
