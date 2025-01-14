

    <div class="col-md-4">
        <div class="card">
            <?php $c_html->card_header('Foto & Weiteres'); ?>
            <div class="card-body">
                
                <?php if((isset($buff['foto'])) && ($buff['foto'] != '')) { ?>
                    <img class="img-responsive mb-20" src="<?php echo $c_helper->get_upload_path($buff['foto']); ?>" />
                <?php } ?>

                <div class="row mt-20">
                    <div class="col-md-12">
                        <?php $c_form->input_file('Foto anpassen', 'foto', '', false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php 
                            $c_form->zyklus(
                                true,
                                isset($buff['fk_zyklus_id']) ? $buff['fk_zyklus_id'] : ''
                            ); 
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php 
                            $c_form->kategorien(
                                true,
                                isset($buff['kategorie_ids']) ? $buff['kategorie_ids'] : ''
                            ); 
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php 
                            $c_form->einheit(
                                true,
                                isset($buff['fk_einheit_id']) ? $buff['fk_einheit_id'] : ''
                            ); 
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php 
                            $c_form->input_waehrung(
                                'Einkaufspreis', 
                                'einkaufspreis', 
                                isset($buff['einkaufspreis']) ? $buff['einkaufspreis'] : '',
                                '', 
                                false
                            ); 
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php 
                            $c_form->input_text(
                                'Quality Hosting Product ID', 
                                'quality_hosting_product_id', 
                                isset($buff['quality_hosting_product_id']) ? $buff['quality_hosting_product_id'] : '',
                                '', 
                                false
                            ); 
                        ?>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>