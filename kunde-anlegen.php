<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('KUNDEN_VERWALTEN');

	if(isset($_POST['btn_kunde_submit'])) {
		$id = $c_kunde->insert($_POST, $_FILES);

		if($id != false) {
			$message = 'Kunde+wurde+erfolgreich+angelegt&type=success';
			$c_helper->redirect($c_url->get_kunde_uebersicht(), $message);
		}
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Kunden', $c_url->get_kunde_uebersicht()), array('Kunde anlegen', '#')));

	$button_title = 'Kunde anlegen';


?>

	<?php if((isset($id)) && ($id == false)) $c_helper->__message('Kunde mit dieser E-Mail Adresse ist bereits vorhanden!', 'danger'); ?>
	
	<div class="js_kunde_anlegen_wrapper">

		<form method="POST" action="" enctype="multipart/form-data" class="form-edit">
			
			<?php 
				include 'includes/form/kunde.php';
				$c_html->sticky_footer(
					array(
						'btn_kunde_submit',
						$button_title
					)
				); 
			?>
		</form>
			
	</div>
	
	
<?php
	$c_html->get_footer();
?>	
	
