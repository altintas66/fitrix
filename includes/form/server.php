    
   

    
    <div class="row">
        <div class="col-md-4">
            <?php 
                $c_form->input_text(
                    'Name', 
                    'name', 
                    isset($buff['name']) ? $buff['name'] : '', 
                    '', 
                    true
                ); 
            ?>
        </div>
        <div class="col-md-4">
            <?php 
                $c_form->input_text(
                    'IP-Adresse', 
                    'ip_adresse', 
                    isset($buff['ip_adresse']) ? $buff['ip_adresse'] : '', 
                    '', 
                    true
                ); 
            ?>
        </div>
        <div class="col-md-4">
            <?php 
                $c_form->input_waehrung(
                    'Preis', 
                    'preis', 
                    isset($buff['preis']) ? $buff['preis'] : '', 
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
                    'CPU', 
                    'cpu', 
                    isset($buff['cpu']) ? $buff['cpu'] : '',
                    '', 
                    true
                ); 
            ?>
        </div>
        <div class="col-md-4">
            <?php 
                $c_form->input_text(
                    'Arbeitsspeicher', 
                    'arbeitsspeicher', 
                    isset($buff['arbeitsspeicher']) ? $buff['arbeitsspeicher'] : '',
                    '', 
                    true
                ); 
            ?>
        </div>
        <div class="col-md-4">
            <?php 
                $c_form->input_text(
                    'Speicherplatz', 
                    'speicherplatz', 
                    isset($buff['speicherplatz']) ? $buff['speicherplatz'] : '',
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
                    'Plesk URL', 
                    'plesk_url', 
                    isset($buff['plesk_url']) ? $buff['plesk_url'] : '',
                    '', 
                    true
                ); 
            ?>
        </div>
        <div class="col-md-4">
            <?php 
                $c_form->input_text(
                    'Plesk User', 
                    'plesk_user', 
                    isset($buff['plesk_user']) ? $buff['plesk_user'] : '',
                    '', 
                    true
                ); 
            ?>
        </div>
        <div class="col-md-4">
            <?php 
                $c_form->input_text(
                    'Plesk Passwort', 
                    'plesk_passwort', 
                    isset($buff['plesk_passwort']) ? $buff['plesk_passwort'] : '',
                    '', 
                    true
                ); 
            ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <?php 
                $c_form->textarea(
                    'Bemerkung', 
                    'bemerkung', 
                    isset($buff['bemerkung']) ? $buff['bemerkung'] : '',
                    false
                ); 
            ?>
        </div>
    </div>







