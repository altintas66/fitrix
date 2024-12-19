<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('USER_VERWALTEN');

	if(isset($_POST['btn_user_submit'])) {
		$id = $c_user->insert($_POST, $_FILES);

		if($id != false) {
			$message = 'User+wurde+erfolgreich+angelegt&type=success';
			$c_helper->redirect($c_url->get_user_uebersicht(), $message);
		}
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('User', $c_url->get_user_uebersicht()), array('User anlegen', '#')));

	$button_title = 'User anlegen';


?>

	<?php if((isset($id)) && ($id == false)) $c_helper->__message('User mit dieser E-Mail Adresse ist bereits vorhanden!', 'danger'); ?>
	
	<div class="js_user_anlegen_wrapper">
		<div class="card">
			<?php $c_html->card_header('User anlegen'); ?>
			<div class="card-body">
				<form method="POST" action="" enctype="multipart/form-data" class="form-edit">
					
					<?php 
						include 'includes/form/user.php';
						$c_html->sticky_footer(
							array(
								'btn_user_submit',
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
	
