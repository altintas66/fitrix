<?php
	include 'init.php';

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Cache', '#')));
	
 
	if(isset($_POST['update_zammad_organisationen'])) $c_cache->set_zammad_organisationen();
    else if(isset($_POST['update_zammad_kunden'])) $c_cache->set_zammad_kunden();
    else if(isset($_POST['update_zammad_benutzer'])) $c_cache->set_zammad_benutzer();
    else if(isset($_POST['update_einstellungen'])) $c_cache->set_einstellungen();
	else if(isset($_POST['update_abonnement_daten'])) $c_cache->set_abonnement_daten();
    
	$dateien = $c_cache->get_cache_dateien();


?>
	
	

	
    <div class="row">
        <div class="col-md-12">
            <div class="card card-table">
                <?php $c_html->card_header('Cache'); ?>
                <div class="card-body">
                    <?php include 'includes/table/table-cache.php'; ?>
                </div>
            </div>
        </div>
    </div>

 


   
<?php $c_html->get_footer(); ?>