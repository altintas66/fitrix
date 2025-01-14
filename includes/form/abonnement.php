    
   <div class="row">
        <div class="col-md-12">

            <div class="card">
                <?php $c_html->card_header('Allgemein'); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?php 
                                $c_form->input_text(
                                    'Kunde', 
                                    'kunde', 
                                    isset($buff['kunde']) ? $buff['kunde'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php 
                                $c_form->input_text(
                                    'Angelegt am', 
                                    'angelegt_am', 
                                    isset($buff['angelegt_am']) ? $buff['angelegt_am'] : '', 
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php 
                                $c_form->input_text(
                                    'Bearbeitet am', 
                                    'bearbeitet_am', 
                                    isset($buff['bearbeitet_am']) ? $buff['bearbeitet_am'] : '', 
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <?php $c_html->card_header('Abonnement Verträge'); ?>
                <div class="card-body">
                    <div class="row">
                       hier kommt die tabelle
                    </div>
                </div>
            </div>



        </div>
    </div>
    
    
    
    


    
    
    
    







