<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(isset($_POST['btn_artikel_typ_submit'])) {
		$id = $c_artikel_typ->insert($_POST);

		if($id != false) {
			$message = 'Artikel+Typ+wurde+erfolgreich+angelegt&type=success';
			$c_helper->redirect($c_url->get_artikel_typ_uebersicht(), $message);
		}
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Artikel Typen', $c_url->get_artikel_typ_uebersicht()), array('Artikel Typ anlegen', '#')));

	$button_title = 'Artikel Typ anlegen';


?>

	<?php if((isset($id)) && ($id == false)) $c_helper->__message('Artikel Typ mit diesem Namen ist bereits vorhanden!', 'danger'); ?>
	
	<div class="js_artikel_typ_anlegen_wrapper">
		<div class="card">
			<?php $c_html->card_header('Artikel Typ anlegen'); ?>
			<div class="card-body">
				<form method="POST" action="" class="form-edit">
					<?php 
						include 'includes/form/artikel_typ.php';
						$c_html->sticky_footer(
							array(
								'btn_artikel_typ_submit',
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
	
