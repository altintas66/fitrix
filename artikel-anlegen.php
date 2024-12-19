<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('ARTIKEL_VERWALTEN');

	if(isset($_POST['btn_artikel_submit'])) {
		
		$result = $c_artikel->insert($_POST, $_FILES);

		if($result != false) {
			$message = 'Artikel+wurde+erfolgreich+angelegt&type=success';
			$c_helper->redirect($c_url->get_artikel_uebersicht(), $message);
		} else {
			$message = $this->helper->get_message_for_url($result['message']).'&type=danger';
			$c_helper->redirect($c_url->get_artikel_anlegen(), $message);
		}
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Artikel', $c_url->get_artikel_uebersicht()), array('Artikel anlegen', '#')));

	$button_title = 'Artikel anlegen';


?>

	
	<div class="js_artikel_anlegen_wrapper">
		<form method="POST" action="" enctype="multipart/form-data" class="form-edit">
			<?php 
				include 'includes/form/artikel.php';
				$c_html->sticky_footer(
					array(
						'btn_artikel_submit',
						$button_title
					)
				); 
			?>
		</form>
	</div>
	
	
<?php
	$c_html->get_footer();
?>	
	
