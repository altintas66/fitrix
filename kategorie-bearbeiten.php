<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(!isset($_GET['id'])) header('Location: '.$c_url->get_kategorie_uebersicht());
	if(isset($_POST['btn_kategorie_submit'])) {
		$c_kategorie->update($_POST);
		$c_helper->redirect($c_url->get_kategorie_bearbeiten($_POST['kategorie_id']), 'Änderungen+erfolgreich+gespeichert&type=success');
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Orte', $c_url->get_kategorie_uebersicht()), array('Kategorie bearbeiten', '#')));
	
	$buff = $c_kategorie->get($_GET['id']);


	$button_title = 'Änderungen speichern';
  
?> 
	
	<div class="js_kategorie_bearbeiten_wrapper">

		<form method="POST" action="" class="form-edit">
			<?php $c_form->input_hidden('kategorie_id', $buff['kategorie_id']); ?>
			<?php include 'includes/table/info/kategorie.php'; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<?php $c_html->card_header('Kategorie bearbeiten'); ?>
						<div class="card-body">
							<?php include 'includes/form/kategorie.php'; ?>
						</div>
					</div>
				</div>
			</div>

			<?php 
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
	
