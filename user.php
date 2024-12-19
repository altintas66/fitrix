<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('USER_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Benutzer', '#')));
	

	$users = $c_user->get_all();
	

?>
	
	<div class="row mb-4"> 
		<div class="col-md-12">
            <?php 
				$c_button->button_user_anlegen();
			?>
		</div>
	</div>

	
	<?php if($users != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Benutzer ('.sizeof($users).')'); ?>
					<div class="card-body">
						<?php include 'includes/table/table-user.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

   
<?php $c_html->get_footer(); ?>