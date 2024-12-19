<?php 
    $zahlungen = $c_rechnung_zahlung->get_all(
        null,
        array(
            'von' => $von,
            'bis' => $bis
        ),
    );
    $einstellungen = $c_einstellungen->get_all();


?>


    <?php if($zahlungen != null) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-table">
                    <?php $c_html->card_header('Einkommen für den '.$von.' - '.$bis); ?>
                    <div class="card-body">
                        <?php include 'includes/table/table-berichte-rechnungen.php'; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?php 
                    $c_html->statistik_widget(
                        'Zeitraum', 
                        $von.' - '.$bis, 
                        'fa fa-calendar', 
                        'primary'
                    );
                ?>
            </div>
            <div class="col-md-4">
                <?php 
                    $c_html->statistik_widget(
                        'Einkommen', 
                        $c_html->waehrung($gesamt_netto), 
                        'fa fa-info', 
                        'warning'
                    );
                ?>
            </div>
            <div class="col-md-4">
                <?php 
                    $c_html->statistik_widget(
                        'Gewinn', 
                        $c_html->waehrung($gesamt_netto), 
                        'fa fa-info', 
                        'success'
                    );
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-table">
                    <?php $c_html->card_header('Umsatzsteuer-Voranmeldung (Steuernummer: '.$einstellungen['firma_steuernummer'].')'); ?>
                    <div class="card-body">
                        <?php include 'includes/table/table-umsatzsteuer-voranmeldung.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } else $c_helper->__message('Keine Zahlungen zu diesem Zeitraum', 'warning'); ?>