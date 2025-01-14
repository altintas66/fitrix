<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('BERICHTE_ANSEHEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Berichte', '#')));

    if(isset($_GET['btn_submit_berichte_filter'])) {
        $von     = $_GET['von'];
        $bis     = $_GET['bis'];
        $bericht = $_GET['bericht'];
    } else {
        $von     = '01.'.date('m.Y');
        $bis     = date("t.m.Y", strtotime(date('Y-m-d')));
        $bericht = 'einkommen';
    }




?>
	
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <?php $c_html->card_header('Filter'); ?>
                <div class="card-body">
                    <?php $c_form->filter_berichte($von, $bis, $bericht); ?>
                </div>
            </div>
        </div>
    </div>

    <?php 
        if($bericht == 'einkommen') {
            include 'includes/bericht/einkommen.php';
        } else if($bericht == 'rechnungsausgang') {
            include 'includes/bericht/rechnungsausgang.php';
        }
    ?>






   
<?php $c_html->get_footer(); ?>