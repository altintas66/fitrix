<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(isset($_POST['btn_kategorie_submit'])) {
		$id = $c_kategorie->insert($_POST);

		if($id != false) {
			$message = 'Kategorie+wurde+erfolgreich+angelegt&type=success';
			$c_helper->redirect($c_url->get_kategorie_uebersicht(), $message);
		}
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Kategorien', $c_url->get_kategorie_uebersicht()), array('Kategorie anlegen', '#')));

	$button_title = 'Kategorie anlegen';


?>

	<?php if((isset($id)) && ($id == false)) $c_helper->__message('Kategorie mit diesem Namen ist bereits vorhanden!', 'danger'); ?>
	
	<div class="js_kategorie_anlegen_wrapper">
		
		<form method="POST" action="" class="form-edit">
			<?php 
				include 'includes/form/kategorie.php';
				$c_html->sticky_footer(
					array(
						'btn_kategorie_submit',
						$button_title
					)
				); 
			?>
		</form>
			
	</div>
	
	
<?php
	$c_html->get_footer();
?>	
	
