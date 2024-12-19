<?php
	include 'init.php';

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Erinnerungen', '#')));
	

	$erinnerungen = $c_erinnerung->get_all();

	
	
?>

	<?php if($erinnerungen != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Erinnerungen');?>
					<div class="card-body">
						<?php include 'includes/table/table-erinnerungen.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php $c_html->get_footer(); ?>