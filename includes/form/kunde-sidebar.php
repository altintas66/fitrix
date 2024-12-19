<?php 
    $toggles = array(
        'automatisiert_abonnement_rechnungen_senden'   => 'Automatisierte Abo Rechnungen senden?',
        'mahnung_automatisch_senden_deaktivieren'      => 'Mahnung automatisch senden deaktivieren?'
    );
    if($buff['zammad_takt_individueller_preis'] == 0) $buff['zammad_takt_individueller_preis'] = '';
?>

    
    
    <div class="col-md-4">
        <div class="card">
            <?php $c_html->card_header('Logo & Weitere Daten'); ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php $c_form->input_file('Logo anpassen', 'logo', '', false); ?>
                    </div>
                </div>
 
                <div class="row">
                    <?php foreach($toggles AS $toggle_key => $toggle_value) { ?>
                        <div class="col-md-12">
                            <?php 
                                $c_form->input_toggle(
                                    $toggle_value,
                                    $toggle_key,
                                    isset($buff[$toggle_key]) ? $buff[$toggle_key] : '0', 
                                );
                            ?>
                        </div>
                    <?php } ?>
                    <div class="col-md-12">
                        <?php 
                            $c_form->input_text(
                                'Parkwin System URL', 
                                'parkwin_system_url', 
                                isset($buff['parkwin_system_url']) ? $buff['parkwin_system_url'] : '',
                                '', 
                                false
                            ); 
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php 
                            $c_form->input_text(
                                'Zammad Organisationsnummer', 
                                'zammad_organization_id', 
                                isset($buff['zammad_organization_id']) ? $buff['zammad_organization_id'] : '',
                                '', 
                                false
                            ); 
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php 
                            $c_form->input_number(
                                'Zammad Inklusiv Takt', 
                                'zammad_inklusiv_takt', 
                                isset($buff['zammad_inklusiv_takt']) ? $buff['zammad_inklusiv_takt'] : '',
                                '', 
                                false
                            ); 
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php 
                            $c_form->input_waehrung(
                                'Zammad Takt individueller Preis', 
                                'zammad_takt_individueller_preis', 
                                isset($buff['zammad_takt_individueller_preis']) ? $buff['zammad_takt_individueller_preis'] : '',
                                '', 
                                false
                            ); 
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php 
                            $c_form->input_text(
                                'Quality Hosting Reseller Customer ID', 
                                'quality_hosting_reseller_customer_id', 
                                isset($buff['quality_hosting_reseller_customer_id']) ? $buff['quality_hosting_reseller_customer_id'] : '',
                                '', 
                                false
                            ); 
                        ?>
                    </div>
                </div>

                
                
            </div>
        </div>
    </div>