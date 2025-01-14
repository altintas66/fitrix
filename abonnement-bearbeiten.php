<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('ANGEBOTE_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Abonnements', $c_url->get_abonnement_uebersicht()), array('Abonnement bearbeiten', '#')));
	
    if(isset($_POST['btn_abonnement_bearbeiten_submit'])) {
        $result = $c_abonnement->update($_POST);
        if($result != false) $c_helper->redirect($c_url->get_abonnement_bearbeiten($_POST['abonnement_id']));
    }

	$buff = $c_abonnement->get($_GET['id']);
    if($buff == null) $c_helper->redirect($c_url->get_abonnement_uebersicht());

    $abonnement_id = $buff['abonnement_id'];
    
    $buff2 = $c_abonnement_vertrag_rechnung->get_all($abonnement_id);
    
    $rechnungen = array();
    
    if($buff2 != null){
        foreach($buff2 AS $b){
            array_push($rechnungen, $c_rechnung->get($b['fk_rechnung_id']));
        }
    }

    $test = $c_abonnement_vertrag_rechnung_position->get_all(3);


    $kunde     = $c_kunde->get($buff['fk_kunde_id']);
    $vertraege = $buff['vertraege'];

    $c_form->input_hidden('abonnement_id', $abonnement_id);
    
?>

    <div class="row mb-20">
        <div class="col-md-12">
            <div class="button-row">
                <?php 
                    $c_button->button_abonnement_uebersicht('<i class="fa fa-arrow-left"></i> zurück zur Übersicht');
                    $c_button->button_email_logs_anzeigen();
                ?>
            </div>
        </div>
    </div>

    

    <div class="row">
        <div class="col-md-6">
            <div class="card card-table">
                <?php $c_html->card_header('Abonnement Details'); ?>
                <div class="card-body">
                    <?php include 'includes/table/abonnement/table-header-1.php'; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-table">
                <?php $c_html->card_header('Kunden Details'); ?>
                <div class="card-body">
                    <?php include 'includes/table/abonnement/table-header-2.php'; ?>
                </div>
            </div>
        </div> 
    </div>

    <div class="row mb-20">
        <div class="col-md-12">
            <div class="button-row">
                <?php 
                    $c_button->button_abonnement_vertrag_anlegen();
                    $c_button->button_abonnement_vorschau($buff);
                    $c_button->button_abonnement_kunden_senden($buff['abonnement_id']);
                    $c_button->button_abonnement_rechnungen_erstellen($buff['abonnement_id']);
                ?>
            </div>
        </div>
    </div>

    <div class="tabs">
        <?php 
            echo $c_html->get_tabs_navigation(array(
                'tabs-1' => 'Veträge',
                'tabs-2' => 'Rechnungen ('.$c_helper->get_size_of_array($rechnungen).')'
            ));
        ?>


        <div id="tabs-1">

            <?php if($vertraege != NULL) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-table">
                            <?php $c_html->card_header('Verträge ('.$c_helper->get_size_of_array($vertraege).')'); ?>
                            <div class="card-body">
                                <?php include 'includes/table/table-abonnement-vertraege.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php $c_form->beitraege($abonnement_id, $c_abonnement->get_tablename()); ?>

        </div>


        <div id="tabs-2">

        <?php if($rechnungen != NULL) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-table">
                        <?php $c_html->card_header('Rechnungen ('.$c_helper->get_size_of_array($rechnungen).')'); ?>
                        <div class="card-body">
                            <?php include 'includes/table/table-abonnement-rechnungen.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        </div>

    </div>
    
   
<?php 
    $c_form->modal_email_logs($buff['abonnement_id'], $c_abonnement->get_tablename());
    $c_form->modal_abonnement_vertrag_anlegen();
    $c_form->modal_abonnement_vertrag_individuelle_position_anlegen();
    $c_form->modal_abonnement_vertrag_bearbeiten();
    $c_form->modal_abonnement_vertrag_info();
    $c_html->get_footer(); 
?>