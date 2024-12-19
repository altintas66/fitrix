<div class="row mb-4">
		<div class="col-md-12 button-group">
			<?php 
                $c_button->button_kunde_uebersicht('<i class="fa fa-arrow-left"></i> Zurück zur Übersicht');
                $c_button->button_ansprechpartner_anlegen();
			?>
		</div>
	</div> 


    <div class="row mt-20">
        <div class="col-md-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-center text-center">
                            <?php  
                                $c_html->table_header(array(
                                    array('title' => 'Logo'),
                                    array('title' => 'Kundennummer'),
                                    array('title' => 'Anzahl<br>Ansprechpartner'),
                                    array('title' => 'Angelegt am'),
                                    array('title' => 'Bearbeitet am'),
                                    array('title' => 'Angelegt von'),
                                    
                                ));
                            ?>
                            <tbody> 
                                <tr>
                                    <td>
                                        <?php echo $c_html->get_kunde_logo($buff); ?>
                                    </td>
                                    <td><?php echo $buff['kunde_id']; ?></td>
                                    <td><?php echo $c_helper->get_size_of_array($ansprechpartner); ?></td>
                                    <td><?php echo $c_helper->german_date($buff['angelegt_am']); ?></td>
                                    <td><?php echo $c_helper->german_date($buff['bearbeitet_am']); ?></td>
                                    <td>
                                        <?php echo $c_table_helper->get_td_user($buff); ?>
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>