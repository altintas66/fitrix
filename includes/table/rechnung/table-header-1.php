
<div class="table-responsive">
		<table class="table table-striped table-center">
			<tbody>
				<?php 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Rechnungsnummer', 
                        $buff['rechnungsnummer']
                    ); 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Rechnungsdatum', 
                        $c_helper->german_date_no_time($buff['rechnungsdatum'])
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'Fällig am', 
                        $c_helper->german_date_no_time($buff['faellig_am'])
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'Status', 
                        $buff['status_label']
                    );
                ?>
			</tbody>
		</table>
	</div>
