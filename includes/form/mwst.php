    

    
    <div class="row">
        <div class="col-md-6">
            <?php 
                $c_form->input_text(
                    'Bezeichnung', 
                    'bezeichnung', 
                    isset($buff['bezeichnung']) ? $buff['bezeichnung'] : '', 
                    '', 
                    true
                ); 
            ?>
        </div>
        <div class="col-md-6">
            <?php 
                $c_form->input_number(
                    'Steuersatz', 
                    'steuersatz', 
                    isset($buff['steuersatz']) ? $buff['steuersatz'] : '', 
                    '', 
                    true
                ); 
            ?>
        </div>
    </div>


    


