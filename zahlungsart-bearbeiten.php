<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(!isset($_GET['id'])) header('Location: '.$c_url->get_zahlungsart_uebersicht());
	if(isset($_POST['btn_zahlungsoption_submit'])) {
		$c_zahlungsart->update($_POST);
		$c_helper->redirect($c_url->get_zahlungsart_bearbeiten($_POST['zahlungsart_id']), 'Änderungen+erfolgreich+gespeichert&type=success');
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Zahlungsarten', $c_url->get_zahlungsart_uebersicht()), array('Zahlungsart bearbeiten', '#')));
	
	$buff = $c_zahlungsart->get($_GET['id']);


	$button_title = 'Änderungen speichern';
  
?> 
	
	<div class="js_zahlungsart_bearbeiten_wrapper">

		<form method="POST" action="" class="form-edit">
			<?php $c_form->input_hidden('zahlungsart_id', $buff['zahlungsart_id']); ?>
			<?php include 'includes/table/info/zahlungsart.php'; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<?php $c_html->card_header('Zahlungsart bearbeiten'); ?>
						<div class="card-body">
							<?php include 'includes/form/zahlungsart.php'; ?>
						</div>
					</div>
				</div>
			</div>

			<?php 
				$c_html->sticky_footer(
					array(
						'btn_zahlungsart_submit',
						$button_title
					)
				);
			?>
			
		</form>
			

		
	
	</div>

<?php
	$c_html->get_footer();
?>	
	
