<?php 
    $artikel_ids = $c_abonnement_vertrag->get_artikel();
?>



    <div class="row">
        <div class="col-md-12">
            <div class="card card-table">
                <?php $c_html->card_header('Artikel'); ?>
                <div class="card-body">
                    <?php include 'includes/table/table-statistik-artikel.php'; ?>
                </div>
            </div>
        </div>
    </div>