<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(!isset($_GET['id'])) header('Location: '.$c_url->get_artikel_typ_uebersicht());
	if(isset($_POST['btn_artikel_typ_submit'])) {
		$c_artikel_typ->update($_POST);
		$c_helper->redirect($c_url->get_artikel_typ_bearbeiten($_POST['artikel_typ_id']), 'Änderungen+erfolgreich+gespeichert&type=success');
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Artikel Typen', $c_url->get_artikel_typ_uebersicht()), array('Artikel Typ bearbeiten', '#')));
	
	$buff = $c_artikel_typ->get($_GET['id']);


	$button_title = 'Änderungen speichern';
  
?> 
	
	<div class="js_artikel_typ_bearbeiten_wrapper">

		<form method="POST" action="" class="form-edit">
			<?php $c_form->input_hidden('artikel_typ_id', $buff['artikel_typ_id']); ?>
			<?php include 'includes/table/info/artikel_typ.php'; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<?php $c_html->card_header('Artikel Typ bearbeiten'); ?>
						<div class="card-body">
							<?php include 'includes/form/artikel_typ.php'; ?>
						</div>
					</div>
				</div>
			</div>

			<?php 
				$c_html->sticky_footer(
					array(
						'btn_artikel_typ_submit',
						$button_title
					)
				);
			?>
			
		</form>
			

		
	
	</div>

<?php
	$c_html->get_footer();
?>	
	
