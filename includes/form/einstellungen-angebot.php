 

    <div class="card">
    <?php $c_html->card_header('Angebot'); ?>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php 
                        $c_form->input_text(
                            'Präfix für Angebotsnummer', 
                            'angebot_angebotsnummer_praefix', 
                            $einstellungen['angebot_angebotsnummer_praefix'], 
                            '', 
                            true
                        );
                    ?>
                </div>
                <div class="col-md-12">
                    <?php 
                        $c_form->input_number(
                            'Erinnern in X Tagen', 
                            'angebot_erinnerin_in_tagen', 
                            $einstellungen['angebot_erinnerin_in_tagen'], 
                            '', 
                            true
                        );
                    ?>
                </div>
                <div class="col-md-12">
                    <?php 
                        $c_form->wysiwyg(
                            'Bedingungen', 
                            'angebot_bedingungen', 
                            $einstellungen['angebot_bedingungen'],
                            '',
                            true
                        );
                    ?>
                </div>
            </div>
        </div>
    </div>

 