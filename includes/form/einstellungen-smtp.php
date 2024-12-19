<div class="card">
    <?php $c_html->card_header('SMTP Einstellungen'); ?>
    <div class="card-body">
        
        <div class="row">
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'Server', 
                        'smtp_server', 
                        $einstellungen['smtp_server'], 
                        '', 
                        true
                    ); 
                ?>
            </div>
            <div class="col-md-4">
                <?php 
                    $c_form->input_email(
                        'E-Mail', 
                        'smtp_email', 
                        $einstellungen['smtp_email'], 
                        '', 
                        true
                    ); 
                ?>
            </div>
            <div class="col-md-4">
                <?php 
                    $c_form->input_text(
                        'Passwort', 
                        'smtp_passwort', 
                        $einstellungen['smtp_passwort'], 
                        '', 
                        true
                    ); 
                ?>
            </div>
        </div>


    </div>
        

</div>