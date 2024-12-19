<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');

	if(!isset($_GET['id'])) header('Location: '.$c_url->get_mwst_uebersicht());
	if(isset($_POST['btn_mwst_submit'])) {
		$c_mwst->update($_POST);
		$c_helper->redirect($c_url->get_mwst_bearbeiten($_POST['mwst_id']), 'Änderungen+erfolgreich+gespeichert&type=success');
	}
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('MwsTs', $c_url->get_mwst_uebersicht()), array('MwSt bearbeiten', '#')));
	
	$buff = $c_mwst->get($_GET['id']);


	$button_title = 'Änderungen speichern';
  
?> 
	
	<div class="js_mwst_bearbeiten_wrapper">

		<form method="POST" action="" class="form-edit">
			<?php $c_form->input_hidden('mwst_id', $buff['mwst_id']); ?>
			<?php include 'includes/table/info/mwst.php'; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<?php $c_html->card_header('MwSt bearbeiten'); ?>
						<div class="card-body">
							<?php include 'includes/form/mwst.php'; ?>
						</div>
					</div>
				</div>
			</div>

			<?php 
				$c_html->sticky_footer(
					array(
						'btn_mwst_submit',
						$button_title
					)
				);
			?>
			
		</form>
			

		
	
	</div>

<?php
	$c_html->get_footer();
?>	
	
