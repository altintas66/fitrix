<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(isset($_POST['btn_zahlungsart_submit'])) {
		$id = $c_zahlungsart->insert($_POST);

		if($id != false) {
			$message = 'Zahlungsart+wurde+erfolgreich+angelegt&type=success';
			$c_helper->redirect($c_url->get_zahlungsart_uebersicht(), $message);
		}
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Zahlungsarten', $c_url->get_zahlungsart_uebersicht()), array('Zahlungsart anlegen', '#')));

	$button_title = 'Zahlungsart anlegen';


?>

	<?php if((isset($id)) && ($id == false)) $c_helper->__message('Zahlungsart mit dieser Bezeichnung ist bereits vorhanden!', 'danger'); ?>
	
	<div class="js_zahlungsart_anlegen_wrapper">
		<div class="card">
			<?php $c_html->card_header('Zahlungsart anlegen'); ?>
			<div class="card-body">
				<form method="POST" action="" class="form-edit">
					<?php 
						include 'includes/form/zahlungsart.php';
						$c_html->sticky_footer(
							array(
								'btn_zahlungsart_submit',
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
	
