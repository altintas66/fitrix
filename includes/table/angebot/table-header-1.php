
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<tbody>
				<?php 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Angebotsnummer', 
                        $buff['angebotsnummer']
                    ); 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Bearbeitet am', 
                        $c_helper->german_date($buff['bearbeitet_am'])
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'Angebotsdatum', 
                        $c_helper->german_date_no_time($buff['angebotsdatum'])
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'Fällig am', 
                        $c_helper->german_date_no_time($buff['faellig_am'])
                    );
                ?>
			</tbody>
		</table>
	</div>
