<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('SERVER_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Hostings', '#'))); 
	

	$hostings = $c_hosting->get_all();

?>
	
	<div class="row mb-4"> 
		<div class="col-md-12">
            <?php 
				$c_button->button_hosting_anlegen();
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php 
			$c_form->freitext_suche_server_filter('search-input-hosting', $c_server->get_server_names());?>
		</div>
	</div>
	
	<?php if($hostings != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php
						$c_html->card_header(
							$c_table_helper->get_card_title_mit_verfuegbarkeit(
								'Hostings',
								'hostings'
							)  
						);
					?> 
					<div class="card-body">
						<?php include 'includes/table/table-hostings.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php $c_html->get_footer(); ?>