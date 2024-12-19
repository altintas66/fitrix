<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('HOSTING_VERWALTEN');

	if(isset($_POST['btn_hosting_submit'])) {
		
		$id = $c_hosting->insert($_POST);

		if($id != false) {
			$message = 'Hosting+wurde+erfolgreich+angelegt&type=success';
			$c_helper->redirect($c_url->get_hosting_uebersicht(), $message);
		}
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Hosting', $c_url->get_hosting_uebersicht()), array('Hosting anlegen', '#')));

	$button_title = 'Hosting anlegen';


?>

	<?php // if((isset($id)) && ($id == false)) $c_helper->__message('Server mit dieser IP Adresse ist bereits vorhanden!', 'danger'); ?>
	
	<div class="js_hosting_anlegen_wrapper">
		<div class="card">
			<?php $c_html->card_header('Hosting anlegen'); ?>
			<div class="card-body">
				<form method="POST" action="" class="form-edit">
					<?php 
						include 'includes/form/hosting.php';
						$c_html->sticky_footer(
							array(
								'btn_hosting_submit',
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
	
