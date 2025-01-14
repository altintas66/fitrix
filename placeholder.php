<?php
	include 'init.php';
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Placeholder', '#')));
	
	$check = $c_permissions->check_user_permission($_SESSION['position_id'], 10);


	$placeholder = $c_placeholder->get_all();

?> 
	<p>
        Placeholder werden bei Benachrichtigungen sowie bei den Whatsapp und E-Mail Texten genutzt.
        Die Zuweisung, welche Placeholder jeweils bei einer Benachrichtigung oder bei einem Text 
        genutzt werden, wird dabei vom Systemadministrator übernommen.
    </p>
    
	<?php if($placeholder != NULL) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Placeholder ( '.sizeof($placeholder).' )'); ?>
					<div class="card-body">
						<?php include 'includes/table/table-placeholder.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>


<?php $c_html->get_footer(); ?>