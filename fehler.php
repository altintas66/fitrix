<?php
	include 'init.php';
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Fehler', '#')));
	
	

?>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <?php $c_html->card_header('Fehlermeldung'); ?>
                <div class="card-body">
                    <?php $c_helper->__message($_GET['message'], 'danger'); ?>
                </div>
            </div>
        </div>
    </div>

   
<?php $c_html->get_footer(); ?>