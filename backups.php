<?php
	include 'init.php';

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Backups', '#')));

    $backups = $c_backup->get_all();
	
?>

    <div class="row mb-4"> 
		<div class="col-md-12">
            <?php 
				$c_button->button_backup_erstellen();
			?>
		</div>
	</div>

    <?php if($backups != NULL) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-table">
                    <?php $c_html->card_header('Backups ('.$c_helper->get_size_of_array($backups).')'); ?>
                    <div class="card-body">
                        <?php include 'includes/table/table-backups.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

   
<?php $c_html->get_footer(); ?>