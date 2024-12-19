<div class="card">
    <?php $c_html->card_header('Allgemein'); ?>
    <div class="card-body">
        
        <div class="row">
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'Firmenname', 
                        'firmen_name', 
                        $einstellungen['firmen_name'], 
                        '', 
                        true
                    ); 
                ?>
            </div>
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'Firmenname (kurz)', 
                        'firmen_name_kurz', 
                        $einstellungen['firmen_name_kurz'], 
                        '', 
                        true
                    ); 
                ?>
            </div> 
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'Geschäftsführer', 
                        'firma_geschaeftsfuehrer', 
                        $einstellungen['firma_geschaeftsfuehrer'], 
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
                        'Umsatzsteuer-ID', 
                        'firma_umsatzsteuer_id', 
                        $einstellungen['firma_umsatzsteuer_id'], 
                        '', 
                        true
                    ); 
                ?>
            </div>
            <div class="col-md-6">
                <?php 
                    $c_form->input_text(
                        'Steuernummer', 
                        'firma_steuernummer', 
                        $einstellungen['firma_steuernummer'], 
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
                        'Registergericht', 
                        'registergericht', 
                        $einstellungen['registergericht'], 
                        '', 
                        true
                    ); 
                ?>
            </div>
            <div class="col-md-6">
                <?php 
                    $c_form->input_text(
                        'Registernummer', 
                        'registernummer', 
                        $einstellungen['registernummer'], 
                        '', 
                        true
                    ); 
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'Strasse', 
                        'strasse', 
                        $einstellungen['strasse'], 
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
                        $einstellungen['plz'], 
                        '', 
                        true
                    ); 
                ?>
            </div>
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'Ort', 
                        'ort', 
                        $einstellungen['ort'], 
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
                        'Breitengrad (Lat)', 
                        'lat', 
                        $einstellungen['lat'], 
                        '', 
                        true
                    ); 
                ?>
            </div>
            <div class="col-md-6">
                <?php 
                    $c_form->input_text(
                        'Längengrad (Lng)', 
                        'lng', 
                        $einstellungen['lng'], 
                        '', 
                        true
                    ); 
                ?>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <?php $c_helper->lat_lng_link(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'Telefon', 
                        'telefon', 
                        $einstellungen['telefon'], 
                        'Telefon', 
                        true
                    ); 
                ?>
            </div>
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'E-Mail', 
                        'email', 
                        $einstellungen['email'], 
                        'E-Mail', 
                        true
                    ); 
                ?>
            </div>
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'Webseite', 
                        'webseite', 
                        $einstellungen['webseite'], 
                        'Webseite', 
                        true
                    ); 
                ?>
            </div>
        </div>

        
        <div class="row">
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'Bank', 
                        'bank', 
                        $einstellungen['bank'], 
                        'Bank', 
                        true
                    ); 
                ?>
            </div>
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'IBAN', 
                        'iban', 
                        $einstellungen['iban'], 
                        'IBAN', 
                        true
                    ); 
                ?>
            </div>
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'BIC', 
                        'bic', 
                        $einstellungen['bic'], 
                        'BIC', 
                        true
                    ); 
                ?>
            </div>
        </div>


    </div>
        

</div>

<br><br>