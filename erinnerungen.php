<?php
	include 'init.php';

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Erinnerungen', '#')));
	

	$erinnerungen = $c_erinnerung->get_all();

?>

	<?php 
		$c_button->button_erinnerung_anlegen();
	?>

	<br><br>

	<?php if($erinnerungen != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Erinnerungen'. ' (<span>'.$c_helper->get_size_of_array($erinnerungen).'</span>)');?>
					<div class="card-body">
						<?php include 'includes/table/table-erinnerungen.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php
	$c_form->modal_erinnerung_anlegen();
	$c_html->get_footer(); 
?>