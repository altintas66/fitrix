<?php
	include 'init.php';
    global $module;

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Module', '#')));
	
?>
	
    <?php 
        $c_helper->__message('Module können nur vom Systemadministrator aktiviert werden.', 'info');
    ?>

	<div class="row">
        <div class="col-md-12">
            <div class="card card-table">
                <?php $c_html->card_header('Module'); ?>
                <div class="card-body">
                    <?php include 'includes/table/table-module.php'; ?>
                </div>
            </div>
        </div>
    </div>



   
<?php $c_html->get_footer(); ?>