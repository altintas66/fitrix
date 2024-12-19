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
                ?>
            </div>
        </div>
    </div>

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
    
   
<?php 
    $c_form->modal_email_logs($buff['abonnement_id'], $c_abonnement->get_tablename());
    $c_form->modal_abonnement_vertrag_anlegen();
    $c_form->modal_abonnement_vertrag_individuelle_position_anlegen();
    $c_form->modal_abonnement_vertrag_bearbeiten();
    $c_form->modal_abonnement_vertrag_info();
    $c_html->get_footer(); 
?>