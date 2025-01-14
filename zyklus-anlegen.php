<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(isset($_POST['btn_zyklus_submit'])) {
		$id = $c_zyklus->insert($_POST);

		if($id != false) {
			$message = 'Zyklus+wurde+erfolgreich+angelegt&type=success';
			$c_helper->redirect($c_url->get_zyklus_uebersicht(), $message);
		}
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Zyklen', $c_url->get_zyklus_uebersicht()), array('Zyklus anlegen', '#')));

	$button_title = 'Zyklus anlegen';


?>

	<?php if((isset($id)) && ($id == false)) $c_helper->__message('Zyklus mit dem selben Berechnungsmonat ist bereits vorhanden!', 'danger'); ?>
	
	<div class="js_zyklus_anlegen_wrapper">
		<div class="card">
			<?php $c_html->card_header('Zyklus anlegen'); ?>
			<div class="card-body">
				<form method="POST" action="" class="form-edit">
					<?php 
						include 'includes/form/zyklus.php';
						$c_html->sticky_footer(
							array(
								'btn_zyklus_submit',
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
	
