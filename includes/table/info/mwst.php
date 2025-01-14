<div class="row mb-4">
		<div class="col-md-12 button-group">
			<?php 
                $c_button->button_mwst_uebersicht('<i class="fa fa-arrow-left"></i> Zurück zur Übersicht');
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
                                ));
                            ?>
                            <tbody> 
                                <tr>
                                    <td><?php echo $c_helper->german_date($buff['angelegt_am']); ?></td>
                                    <td><?php echo $c_helper->german_date($buff['bearbeitet_am']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>