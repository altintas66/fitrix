    
   
    <div class="row">
        <div class="col-md-8">

            <div class="card">
			    <?php $c_html->card_header('Allgemeine Daten'); ?>
			    <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_text(
                                    'Firmenname', 
                                    'firmen_name', 
                                    isset($buff['firmen_name']) ? $buff['firmen_name'] : '', 
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_text(
                                    'Suchname', 
                                    'suchname', 
                                    isset($buff['suchname']) ? $buff['suchname'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_text(
                                    'Telefon', 
                                    'telefon', 
                                    isset($buff['telefon']) ? $buff['telefon'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_text(
                                    'Mobil', 
                                    'mobil', 
                                    isset($buff['mobil']) ? $buff['mobil'] : '',
                                    '', 
                                    false
                                ); 
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_text(
                                    'Webseite', 
                                    'webseite', 
                                    isset($buff['webseite']) ? $buff['webseite'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_text(
                                    'Fax', 
                                    'fax', 
                                    isset($buff['fax']) ? $buff['fax'] : '',
                                    '', 
                                    false
                                ); 
                            ?>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <?php 
                                $c_form->input_email(
                                    'E-Mail', 
                                    'email', 
                                    isset($buff['email']) ? $buff['email'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_email(
                                    'E-Mail für Angebot & Rechnung', 
                                    'email_angebot_rechnung', 
                                    isset($buff['email_angebot_rechnung']) ? $buff['email_angebot_rechnung'] : '',
                                    '', 
                                    false
                                ); 
                            ?>
                        </div>
                       

                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <?php 
                                $c_form->input_text(
                                    'Straße', 
                                    'strasse', 
                                    isset($buff['strasse']) ? $buff['strasse'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php 
                                $c_form->input_text(
                                    'PLZ', 
                                    'plz', 
                                    isset($buff['plz']) ? $buff['plz'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-4">    
                            <?php 
                                $c_form->ort(
                                    true,
                                    isset($buff['fk_ort_id']) ? $buff['fk_ort_id'] : ''
                                ); 
                            ?>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?php 
                                $c_form->input_text(
                                    'Geschäftsführer', 
                                    'geschaeftsfuehrer', 
                                    isset($buff['geschaeftsfuehrer']) ? $buff['geschaeftsfuehrer'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php 
                                $c_form->input_text(
                                    'Umsatzsteuer ID', 
                                    'umsatzsteuer_id', 
                                    isset($buff['umsatzsteuer_id']) ? $buff['umsatzsteuer_id'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php 
                                $c_form->mwst(
                                    true,
                                    isset($buff['fk_mwst_id']) ? $buff['fk_mwst_id'] : ''
                                ); 
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_text(
                                    'IBAN', 
                                    'iban', 
                                    isset($buff['iban']) ? $buff['iban'] : '',
                                    '', 
                                    false
                                ); 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_text(
                                    'Bank', 
                                    'bank', 
                                    isset($buff['bank']) ? $buff['bank'] : '',
                                    '', 
                                    false
                                ); 
                            ?>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_text(
                                    'Konto Inhaber', 
                                    'konto_inhaber', 
                                    isset($buff['konto_inhaber']) ? $buff['konto_inhaber'] : '',
                                    '', 
                                    false
                                ); 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_text(
                                    'BIC', 
                                    'bic', 
                                    isset($buff['bic']) ? $buff['bic'] : '',
                                    '', 
                                    false
                                ); 
                            ?>
                        </div>
                       
                    </div>

                </div>
            </div>

        </div>

        <?php include 'kunde-sidebar.php'; ?>
    </div>
    
    
    
    
    
    

    






