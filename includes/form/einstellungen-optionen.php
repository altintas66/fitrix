<?php 
    $optionen = $c_einstellungen->get_optionen();


?>

    <div class="card">
        <?php $c_html->card_header('Optionen'); ?>
        <div class="card-body">



            <div class="table-responsive">
                <table class="table table-striped table-bordered table-center">
                    <thead>
                        <tr>
                            <th>Beschreibung</th>
                            <th>Wert</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($optionen AS $option_key => $option_value) { ?>
                            <tr>
                                <th><?php echo $option_value; ?></th>
                                <td><?php echo $c_helper->get_toggle_label($einstellungen[$option_key]); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>


        
        

 
   
   
    <br><br><br>