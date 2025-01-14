
    <div class="table-responsive">
		<table class="table table-center">
			<tbody>
				<?php 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Angelegt von', 
                        $c_table_helper->get_td_user($buff)
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'Anzahl Verträge', 
                        $c_helper->get_size_of_array($vertraege)
                    ); 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Angelegt am', 
                        $c_helper->german_date($buff['angelegt_am'])
                    ); 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Bearbeitet am', 
                        $c_helper->german_date($buff['bearbeitet_am'])
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'Letzte Rechnung', 
                        $c_table_helper->get_td_letzte_rechnung($rechnungen[0])
                    );
                ?>
			</tbody>
		</table>
	</div>
