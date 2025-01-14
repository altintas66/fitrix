<?php 
    $bilder = $c_einstellungen->get_bilder();
?>

    <div class="card">
        <?php $c_html->card_header('Bilder'); ?>
        <div class="card-body">

            <?php foreach($bilder AS $bild_key => $bild_value) { ?>
                <div class="row mb-50">
                    <?php if($einstellungen[$bild_key] != '') { ?>
                        <div class="col-md-6">
                            <img width="220" src="<?php echo $einstellungen[$bild_key]; ?>" />
                        </div>
                    <?php } ?>
                    <div class="col-md-6">
                        <?php $c_form->input_file($bild_value, $bild_key, '', false); ?>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>


        
        

 
   
   
    <br><br><br>