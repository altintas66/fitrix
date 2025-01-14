
    <div class="table-responsive">
		<table class="table table-center">
			<tbody>
				<?php 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Kunde', 
                        $c_table_helper->get_td_kunde($buff)
                    ); 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Kundennummer', 
                        $kunde['kunde_id']
                    ); 
                    echo $c_table_helper->get_table_tr_th_td(
                        'Firma', 
                        $kunde['firmen_name']
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'E-Mail für Rechnung & Angebot', 
                        $kunde['email_angebot_rechnung']
                    );
                    echo $c_table_helper->get_table_tr_th_td(
                        'Webseite', 
                        $c_table_helper->get_td_kunde_webseite($kunde)
                    ); 
                ?>
			</tbody>
		</table>
	</div>
