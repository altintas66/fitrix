<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('SERVER_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Server', '#'))); 
	

	$server = $c_server->get_all();

?>
	
	<div class="row mb-4"> 
		<div class="col-md-12">
            <?php 
				$c_button->button_server_anlegen();
			?>
		</div>
	</div>
	
	<?php if($server != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Server');?> 
					<div class="card-body">
						<?php include 'includes/table/table-server.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php $c_html->get_footer(); ?>