<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(isset($_POST['btn_einheit_submit'])) {
		$id = $c_einheit->insert($_POST);

		if($id != false) {
			$message = 'Einheit+wurde+erfolgreich+angelegt&type=success';
			$c_helper->redirect($c_url->get_einheit_uebersicht(), $message);
		}
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Einheiten', $c_url->get_einheit_uebersicht()), array('Einheit anlegen', '#')));

	$button_title = 'Einheit anlegen';


?>

	<?php if((isset($id)) && ($id == false)) $c_helper->__message('Einheit mit diesem Namen ist bereits vorhanden!', 'danger'); ?>
	
	<div class="js_einheit_anlegen_wrapper">
		<div class="card">
			<?php $c_html->card_header('Einheit anlegen'); ?>
			<div class="card-body">
				<form method="POST" action="" class="form-edit">
					<?php 
						include 'includes/form/einheit.php';
						$c_html->sticky_footer(
							array(
								'btn_einheit_submit',
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
	
