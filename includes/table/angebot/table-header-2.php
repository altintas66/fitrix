
<div class="table-responsive">
		<table class="table table-striped table-center">
			<tbody>
				<?php 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Kundennummer', 
                        $kunde['kunde_id']
                    ); 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Firma', 
                        $kunde['firmen_name']
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'Anschrift', 
                        $kunde['adresse']
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'E-Mail für Rechnung & Angebot', 
                        $kunde['email_angebot_rechnung']
                    );
                ?>
			</tbody>
		</table>
	</div>
