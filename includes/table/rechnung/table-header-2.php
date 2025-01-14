
<div class="table-responsive">
		<table class="table table-striped table-center">
			<tbody>
				<?php 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Kunde Firma', 
                        $kunde['firmen_name']
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'Erstellt von', 
                        $erstellt_von
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'Bereits bezahlt', 
                        $c_html->waehrung($buff['gesamt_zahlung'])
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'Offener Zahlungsbetrag', 
                        $c_html->waehrung($buff['offene_zahlung'])
                    );
                ?>
			</tbody>
		</table>
	</div>
