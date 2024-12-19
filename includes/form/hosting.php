     
   

    
    <div class="row">
        <div class="col-md-4">
            <?php 
                $c_form->input_text(
                    'Name', 
                    'name', 
                    isset($buff['name']) ? $buff['name'] : '', 
                    '', 
                    true
                ); 
            ?>
        </div>
        <div class="col-md-4">
            <?php 
                $c_form->server(
                    true, 
                    isset($buff['fk_server_id']) ? $buff['fk_server_id'] : '',
                );
            ?>
        </div>   
        <div class="col-md-4">
            <?php 
                $c_form->artikel_webhosting(
                    true, 
                    isset($buff['fk_artikel_webhosting_id']) ? $buff['fk_artikel_webhosting_id'] : '',
                );
            ?>
        </div>   
       
    </div>


    


    <div class="row">    
        <div class="col-md-4">
            <?php 
                $c_form->kunde(
                    true, 
                    isset($buff['fk_kunde_id']) ? $buff['fk_kunde_id'] : '',
                );
            ?>
        </div>
        <div class="col-md-4">
            <?php 
                $c_form->input_text(
                    'URL', 
                    'url', 
                    isset($buff['url']) ? $buff['url'] : '',
                    '', 
                    true
                ); 
            ?>
        </div>
        <div class="col-md-4">
            <?php 
                $c_form->input_number(
                    'Traffic in MB (monatlich)', 
                    'traffic_mb_monatlich', 
                    isset($buff['traffic_mb_monatlich']) ? $buff['traffic_mb_monatlich'] : '',
                    '', 
                    true
                ); 
            ?>
        </div>

        
    </div>







