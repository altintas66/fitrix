<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(isset($_POST['btn_ort_submit'])) {
		$id = $c_ort->insert($_POST);

		if($id != false) {
			$message = 'Ort+wurde+erfolgreich+angelegt&type=success';
			$c_helper->redirect($c_url->get_ort_uebersicht(), $message);
		}
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Orte', $c_url->get_ort_uebersicht()), array('Ort anlegen', '#')));

	$button_title = 'Ort anlegen';


?>

	<?php if((isset($id)) && ($id == false)) $c_helper->__message('Ort mit diesem Namen ist bereits vorhanden!', 'danger'); ?>
	
	<div class="js_ort_anlegen_wrapper">
		<div class="card">
			<?php $c_html->card_header('Ort anlegen'); ?>
			<div class="card-body">
				<form method="POST" action="" class="form-edit">
					<?php 
						include 'includes/form/ort.php';
						$c_html->sticky_footer(
							array(
								'btn_ort_submit',
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
	
