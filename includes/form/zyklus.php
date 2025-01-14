    

    
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
                    'Anzahl der Monate (Für die Berechnung)', 
                    'anzahl_monate', 
                    isset($buff['anzahl_monate']) ? $buff['anzahl_monate'] : '', 
                    '', 
                    true
                ); 
            ?>
        </div>
    </div>


    


