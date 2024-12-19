<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('ZAMMAD_API');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Zammad Tickets', '#')));

    if(!isset($_POST['btn_submit_zammad'])) {
        $jahr  = date('Y');
        $monat = date('m');
        $organisation = '';
    } else {
        $jahr  = $_POST['rechnung_jahr'];
        $monat = $_POST['monat'];
        $organisation = $_POST['zammad_organisation_id'];
    }

    $result = $c_zammad->get_tickets($jahr, $monat, $organisation);
    $response = json_decode($result['response'], true);

    $ticket_nummern = $response['tickets'];
    $tickets = $response['assets']['Ticket'];
    $anzahl_tickets = $response['tickets_count'];
    
    $gesamt_takt = 0;

?>
	
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <?php $c_form->filter_zammad_tickets($jahr, $monat, $organisation); ?>
                </div>
            </div>
        </div>
    </div>



    <?php if((isset($result['http_code'])) && ($result['http_code'] == '200')) { ?>
        <div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Tickets ('.$anzahl_tickets.')'); ?>
					<div class="card-body">
						<?php include 'includes/table/table-tickets.php'; ?>
					</div>
				</div>
                <h3 class="mt-20">Gesamt: <?php echo $gesamt_takt; ?> Takt</h3>
			</div>
		</div>
    <?php } ?>

	



   
<?php $c_html->get_footer(); ?>