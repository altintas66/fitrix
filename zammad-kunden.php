<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('ZAMMAD_API');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Zammad Kunden', '#')));

	$kunden            = $c_cache->get_zammad_kunden();
    $anzahl_kunden     = $c_helper->get_size_of_array($kunden);

?>

    <?php if($kunden != null) { ?>
        <div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Kunden ('.$anzahl_kunden.')'); ?>
					<div class="card-body">
						<?php include 'includes/table/table-zammad-kunden.php'; ?>
					</div>
				</div>
			</div>
		</div>
    <?php } ?>

	



   
<?php $c_html->get_footer(); ?>