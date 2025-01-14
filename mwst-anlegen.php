<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(isset($_POST['btn_mwst_submit'])) {
		$id = $c_mwst->insert($_POST);

		if($id != false) {
			$message = 'MwSt+wurde+erfolgreich+angelegt&type=success';
			$c_helper->redirect($c_url->get_mwst_uebersicht(), $message);
		}
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('MwSt', $c_url->get_mwst_uebersicht()), array('MwSt anlegen', '#')));

	$button_title = 'MwSt anlegen';


?>

	<?php if((isset($id)) && ($id == false)) $c_helper->__message('MwSt mit diesem Steuersatz ist bereits vorhanden!', 'danger'); ?>
	
	<div class="js_mwst_anlegen_wrapper">
		<div class="card">
			<?php $c_html->card_header('MwSt anlegen'); ?>
			<div class="card-body">
				<form method="POST" action="" class="form-edit">
					<?php 
						include 'includes/form/mwst.php';
						$c_html->sticky_footer(
							array(
								'btn_mwst_submit',
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
	
