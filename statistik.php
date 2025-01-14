<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('STATISTIK_ANSEHEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Statistik', '#')));

    if(isset($_GET['btn_submit_statistik_filter'])) {
        $statistik = $_GET['statistik'];
    } else {
        $statistik = 'kunden';
    }


?>
	
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <?php $c_html->card_header('Filter'); ?>
                <div class="card-body">
                    <?php $c_form->filter_statistik($statistik); ?>
                </div>
            </div>
        </div>
    </div>

    <?php 
        if($statistik == 'kunden') {
            include 'includes/statistik/kunden.php';
        } else if($statistik == 'artikel') {
            include 'includes/statistik/artikel.php';
        }
    ?>






   
<?php $c_html->get_footer(); ?>