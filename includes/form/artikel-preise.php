    <div class="card">
        <?php $c_html->card_header('Preise'); ?>
        <div class="card-body">
            <div class="mb-20">
                <?php 
                    $c_button->button_artikel_preis_anlegen();
                ?>
            </div>
            <?php include 'includes/table/table-artikel-preise.php'; ?>
        </div>
    </div>