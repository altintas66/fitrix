<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('SERVER_VERWALTEN');

	if(isset($_POST['btn_server_submit'])) {
		$id = $c_server->insert($_POST);

		if($id != false) {
			$message = 'Server+wurde+erfolgreich+angelegt&type=success';
			$c_helper->redirect($c_url->get_server_uebersicht(), $message);
		}
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Server', $c_url->get_server_uebersicht()), array('Server anlegen', '#')));

	$button_title = 'Server anlegen';


?>

	<?php if((isset($id)) && ($id == false)) $c_helper->__message('Server mit dieser IP Adresse ist bereits vorhanden!', 'danger'); ?>
	
	<div class="js_server_anlegen_wrapper">
		<div class="card">
			<?php $c_html->card_header('Server anlegen'); ?>
			<div class="card-body">
				<form method="POST" action="" class="form-edit">
					<?php 
						include 'includes/form/server.php';
						$c_html->sticky_footer(
							array(
								'btn_server_submit',
								$button_title
							)
						); 
					?>
				</form>
			</div>
		</div>
	</div>
	
	
<?php
	$c_html->get_footer();
?>	
	
