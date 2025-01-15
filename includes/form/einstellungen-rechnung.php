 

    <div class="card">
    <?php $c_html->card_header('Rechnung'); ?>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?php 
                        $c_form->input_text(
                            'Präfix für Rechnungsnummer', 
                            'rechnung_rechnungsnummer_praefix', 
                            $einstellungen['rechnung_rechnungsnummer_praefix'], 
                            '', 
                            true
                        );
                    ?>
                </div>
                <div class="col-md-6">
                    <?php 
                        $c_form->input_number(
                            'Anzahl Tage für Fälligkeit', 
                            'rechnung_anzahl_tage_faelligkeit', 
                            $einstellungen['rechnung_anzahl_tage_faelligkeit'], 
                            '', 
                            true
                        );
                    ?>
                </div>
                <div class="col-md-6">
                    <?php 
                        $c_form->input_number(
                            'Zahlungserinnerung senden nach X Tagen', 
                            'zahlungserinnerung_senden_nach_x_tagen', 
                            $einstellungen['zahlungserinnerung_senden_nach_x_tagen'], 
                            '', 
                            true
                        );
                    ?>
                </div>
                <div class="col-md-3">
                    <?php 
                        $c_form->input_number(
                            'Mahnung senden nach X Tagen', 
                            'mahnungen_senden_nach_x_tagen', 
                            $einstellungen['mahnungen_senden_nach_x_tagen'], 
                            '', 
                            true
                        );
                    ?>
                </div>
                <div class="col-md-3">
                    <?php 
                        $c_form->input_text(
                            'Mahngebühr', 
                            'mahngebuehr', 
                            $einstellungen['mahngebuehr'], 
                            '', 
                            true
                        );
                    ?>
                </div>
                <div class="col-md-12">
                    <?php 
                        $c_form->textarea(
                            'Bedingungen', 
                            'rechnung_bedingungen', 
                            $einstellungen['rechnung_bedingungen'],
                            true
                        );
                    ?>
                </div>
            </div>
        </div>
    </div>

    