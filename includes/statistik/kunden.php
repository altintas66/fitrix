<?php 
    $kunden = $c_kunde->get_all('', true);
?>



    <div class="row">
        <div class="col-md-12">
            <div class="card card-table">
                <?php $c_html->card_header('Kunden'); ?>
                <div class="card-body">
                    <?php include 'includes/table/table-statistik-kunden.php'; ?>
                </div>
            </div>
        </div>
    </div>