    <div class="card">
        <?php $c_html->card_header('Kunden'); ?>
        <div class="card-body">
            
            <div class="row">
                <div class="col-md-4">
                    <?php 
                        $c_form->kunde_suche(
                            true,
                            $einstellungen['kunde_suche']
                        ); 
                    ?>
                </div>
                
        </div>
            

    </div>

<br><br>