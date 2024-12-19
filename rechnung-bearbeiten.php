<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('RECHNUNGEN_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Rechnungen', $c_url->get_rechnung_uebersicht()), array('Rechnung bearbeiten', '#')));
	
    if(isset($_POST['btn_rechnung_bearbeiten_submit'])) {
        $result = $c_rechnung->update($_POST);
        if($result != false) $c_helper->redirect($c_url->get_rechnung_bearbeiten($_POST['rechnung_id']));
    }

	$buff = $c_rechnung->get($_GET['id']);
   
    if($buff == null) $c_helper->redirect($c_url->get_rechnung_uebersicht());

    $kunde = $c_kunde->get($buff['fk_kunde_id']);

    if($buff['fk_user_id'] == null) $erstellt_von = 'Automatisch';
    else $erstellt_von = $c_table_helper->get_td_user($buff);

    $c_form->input_hidden('rechnung_id', $buff['rechnung_id']);

?>

    <div class="row mb-20">
        <div class="col-md-12">
            <div class="button-row">
                <?php 
                    $c_button->button_rechnung_uebersicht('<i class="fa fa-arrow-left"></i> zurück zur Übersicht');
                    $c_button->button_email_logs_anzeigen();
                    if($buff['rechnung_zahlungserinnerung_id'] != null) { 
                        $c_button->button_rechnung_zahlungserinnerung_anzeigen($buff['rechnung_id']);
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="row print_hidden">
        <div class="col-md-6">
            <div class="card card-table">
                <?php $c_html->card_header('Rechnung Details'); ?>
                <div class="card-body">
                    <?php include 'includes/table/rechnung/table-header-1.php'; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-table">
                <?php $c_html->card_header('Weitere Details'); ?>
                <div class="card-body">
                    <?php include 'includes/table/rechnung/table-header-2.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="invoice-box-wrapper ">
        <div class="button-row mb-20">
            <?php 
                if($buff['status'] == 'entwurf') {
                    $c_button->button_rechnung_bearbeiten();
                    $c_button->button_rechnung_position_hinzufuegen();
                }

                $c_button->button_rechnung_vorschau($buff);

                if($buff['status'] == 'offen') {
                    $c_button->button_rechnung_kunden_senden($buff['rechnung_id']);
                }
                if($buff['status'] == 'offen') { 
                    $c_button->button_rechnung_korrektur($buff['rechnung_id']);
                } else if(($buff['status'] == 'entwurf') || ($buff['status'] == 'storniert')) { 
                    $c_button->button_rechnung_festschreiben($buff['rechnung_id']);
                }
                if(($buff['status'] == 'offen') || ($buff['status'] == 'gesendet') || ($buff['status'] == 'bezahlt')) {
                    $c_button->button_rechnung_zahlung_hinzufuegen($buff['rechnung_id']);
                }
                if(($buff['status'] != 'storniert') && ($buff['zahlungen'] == null)) { 
                    $c_button->button_rechnung_stornieren($buff['rechnung_id']);
                }
                if($buff['status'] != 'entwurf') {
                    $c_button->button_rechnung_drucken($buff['rechnung_id']);
                }
            ?>
        </div>
      
        <?php 
            if($buff['status'] == 'entwurf') {
                $c_html->rechnung_box($buff, $kunde);
            } else {
                $c_html->iframe_rechnung($buff);
            }
        ?>

        <?php if($buff['status'] == 'entwurf') { ?>
            <form method="POST" action="">
            <?php $c_form->input_hidden('rechnung_id', $buff['rechnung_id']); ?>
            <?php $c_form->input_hidden('status', $buff['status']); ?>
                <div id="rechnung-bearbeiten" class="card mt-20">
                    <?php $c_html->card_header('Rechnung bearbeiten'); ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <?php 
                                    $c_form->kunde(
                                        true,
                                        $buff['fk_kunde_id']
                                    );
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?php 
                                    $c_form->input_date(
                                        'Rechnungsdatum', 
                                        'rechnungsdatum', 
                                        $buff['rechnungsdatum'], 
                                        '', 
                                        $required = true
                                    );
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?php 
                                    $c_form->input_date(
                                        'Fällig am', 
                                        'faellig_am', 
                                        $buff['faellig_am'], 
                                        '', 
                                        $required = true
                                    );
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php 
                                    $c_form->wysiwyg(
                                        'Bedingungen', 
                                        'bedingungen', 
                                        $buff['bedingungen'], 
                                        $required = true
                                    );
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php 
                                    $c_form->wysiwyg(
                                        'Zusätzlicher Inhalt', 
                                        'zusatz_text', 
                                        $buff['zusatz_text'], 
                                        $required = false
                                    );
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?php 
                                    $c_form->button_submit(
                                        'btn_rechnung_bearbeiten_submit', 
                                        'Änderungen speichern', 
                                        'btn btn-success'
                                    );
                                ?>
                            </div>
                        </div>

                    </div>
                </div>

            </form>
        <?php } ?>

        <?php if(($buff['status'] == 'offen') || ($buff['status'] == 'gesendet') || ($buff['status'] == 'bezahlt')) { ?>
            <?php if($buff['zahlungen'] != null) { ?>
                <div class="row mt-20">
                    <div class="col-md-12">
                        <div class="card card-table">
                            <?php $c_html->card_header('Zahlungen'); ?>
                            <div class="card-body">
                                <?php include 'includes/table/table-rechnung-zahlungen.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

    </div>

    
   
<?php 
    $c_form->modal_email_logs($buff['rechnung_id'], $c_rechnung->get_tablename());
    
    if($buff['status'] == 'entwurf') {
        $c_form->modal_rechnung_position_hinzufuegen();
        $c_form->modal_rechnung_position_bearbeiten();
        $c_form->modal_rechnung_individuelle_position_hinzufuegen();
    }
    $c_form->modal_rechnung_zahlung_hinzufuegen();
    $c_html->get_footer(); 
?>