<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('ANGEBOTE_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Angebote', $c_url->get_angebot_uebersicht()), array('Angebot bearbeiten', '#')));
	
    if(isset($_POST['btn_angebot_bearbeiten_submit'])) {
        $result = $c_angebot->update($_POST);
        if($result != false) $c_helper->redirect($c_url->get_angebot_bearbeiten($_POST['angebot_id']));
    }

	$buff = $c_angebot->get($_GET['id']);
    if($buff == null) $c_helper->redirect($c_url->get_angebot_uebersicht());

    $kunde = $c_kunde->get($buff['fk_kunde_id']);
    $angebot_id = $buff['angebot_id'];
	
?> 
 
    <div class="row mb-20">
        <div class="col-md-12">
            <div class="button-row">
                <?php 
                    $c_button->button_email_logs_anzeigen();
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-table">
                <?php $c_html->card_header('Angebot Details'); ?>
                <div class="card-body">
                    <?php include 'includes/table/angebot/table-header-1.php'; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-table">
                <?php $c_html->card_header('Kunden Details'); ?>
                <div class="card-body">
                    <?php include 'includes/table/angebot/table-header-2.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="invoice-box-wrapper">
        <div class="button-row mb-20">
            <?php 
                $c_button->button_angebot_bearbeiten();
                $c_button->button_angebot_position_hinzufuegen();
                $c_button->button_angebot_vorschau($buff);
                $c_button->button_angebot_kunden_senden($buff['angebot_id']);
            ?>
        </div>

        <?php 
            $c_html->angebot_box($buff, $kunde);
        ?>

        <form method="POST" action="">
            <?php $c_form->input_hidden('angebot_id', $buff['angebot_id']); ?>
            <div id="angebot-bearbeiten" class="card mt-20">
                <?php $c_html->card_header('Angebot bearbeiten'); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php 
                                $c_form->kunde(
                                    true,
                                    $buff['fk_kunde_id']
                                );
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                                $c_form->angebot_status(
                                    true,
                                    $buff['status']
                                );
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_date(
                                    'Angebotsdatum', 
                                    'angebotsdatum', 
                                    $buff['angebotsdatum'], 
                                    '', 
                                    $required = true
                                );
                            ?>
                        </div>
                        <div class="col-md-6">
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
                                $c_form->textarea(
                                    'Bedingungen', 
                                    'bedingungen', 
                                    $buff['bedingungen'], 
                                    $required = false
                                );
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php 
                                $c_form->textarea(
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
                                $c_form->button(
                                    'js_btn_angebot_speichern', 
                                    'Änderungen speichern', 
                                    'btn btn-success'
                                );
                            ?>
                        </div>
                    </div>

                </div>
            </div>

        </form>

        
    </div>

    <?php $c_form->beitraege($angebot_id, $c_angebot->get_tablename()); ?>
    
   
<?php 
    $c_form->modal_email_logs($buff['angebot_id'], $c_angebot->get_tablename());
    $c_form->modal_angebot_position_hinzufuegen();
    $c_form->modal_angebot_position_bearbeiten();
    $c_form->modal_angebot_individuelle_position_hinzufuegen();

    $c_html->get_footer(); 
?>