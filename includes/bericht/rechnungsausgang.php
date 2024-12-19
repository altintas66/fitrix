<?php 
    $rechnungen = $c_rechnung->get_all(
        '',
        array(
            'von' => $von,
            'bis' => $bis
        ),
    );

?>


    <?php if($rechnungen != null) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-table">
                    <?php $c_html->card_header('Rechnungen für den '.$von.' - '.$bis); ?>
                    <div class="card-body">
                        <?php include 'includes/table/table-berichte-rechnungsausgaenge.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } else $c_helper->__message('Keine Rechnungen zu diesem Zeitraum', 'warning'); ?>

        