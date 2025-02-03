<?php if($zeitabrechnungen > 0) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
                    array('title' => 'Pos.'),
                    array('title' => 'Kunden ID'),
					array('title' => 'Organisation'),
                    array('title' => 'Tickets'),
                    array('title' => 'Anzahl Tickets'),
                    array('title' => 'Anzahl Takte'),
                ));
            ?>
			<tbody>
				<?php foreach($zeitabrechnungen AS  $buff) { 
   
                    if($buff['anzahl_tickets'] == 0) continue;
                
                ?>
                    <tr>
                        <td><?php echo $counter++; ?>.</td>
                        <td><?php echo $buff['kunde_id']; ?></td>
                        <td><?php echo $buff['firmen_name']; ?></td>
                        <td>
                            <?php 
                                $html = '';
                                $ticket_counter = 0;
                                foreach($buff['tickets'] AS $ticket) {
                                    $html .= '<a target="_blank" class="badge badge-secondary mr-10 mb-10" href="'.$c_url->get_zammad_ticket_bearbeiten($ticket['id']).'">#'.$ticket['number'].' ('.$ticket['takt'].')</a>';
                                    $ticket_counter++;
                                    if($ticket_counter == 5) {
                                        $html .= '<br>';
                                        $ticket_counter = 0;
                                    }
                                }
                                echo $html;
                            ?>
                        </td>
                        <td><?php echo $buff['anzahl_tickets']; ?></td> 
                        <td><?php echo $buff['takt']; ?></td>
                    </tr>
                    <?php $gesamt_takt += floatval($buff['takt']); ?>
                <?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>


