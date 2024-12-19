<div class="row mb-4">
		<div class="col-md-12 button-group">
			<?php 
                $c_button->button_artikel_uebersicht('<i class="fa fa-arrow-left"></i> Zurück zur Übersicht');
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
                                    array('title' => 'Angelegt am'),
                                    array('title' => 'Bearbeitet am'),
                                    array('title' => 'Angelegt von'),
                                    array('title' => 'Artikelnummer'),
                                    array('title' => 'Artikeltyp'),
                                    array('title' => 'Zyklus'),
                                ));
                            ?>
                            <tbody> 
                                <tr>
                                    <td><?php echo $c_helper->german_date($buff['angelegt_am']); ?></td>
                                    <td><?php echo $c_helper->german_date($buff['bearbeitet_am']); ?></td>
                                    <td>
                                        <?php echo $c_table_helper->get_td_user($buff); ?>
                                    </td>
                                    <td><?php echo $buff['artikel_nummer']; ?></td>
                                    <td><?php echo $buff['artikel_typ']; ?></td>
                                    <td><?php echo $buff['zyklus']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>