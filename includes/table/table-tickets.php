<?php if($anzahl_tickets > 0) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Zammad<br>Ticketnr.'),
					array('title' => 'Titel'),
                    array('title' => 'Besitzer'),
					array('title' => 'Kunde (Orga)'),
					array('title' => 'Takt'),
					array('title' => 'Erstellt<br>Bearbeitet'),
					array('title' => 'Geschlossen?')
                ));
            ?>
			<tbody>
				<?php foreach($tickets AS $ticket_id => $buff) { 
					if($buff['time_unit'] == '') continue;

					$time_unit_lm = $tickets_vor_monat['assets']['Ticket'][$ticket_id]['time_unit'];
					$time_unit = $buff['time_unit'] - $time_unit_lm;

					$gesamt_takt += floatval($time_unit);
                ?>
					<tr>
						<td>
                            <a target="_blank" class="a_link" href="<?php echo $c_url->get_zammad_ticket_bearbeiten($buff['id']); ?>">
                                <?php echo $buff['number']; ?>
                            </a>
                        </td>
                        <td>
							<?php echo $c_helper->string_neue_zeilen($buff['title'], 30); ?><br>
						</td>
						<td>
							<?php echo $buff['owner_id']; ?>
							<br>
							<?php echo $tickets_vor_monat['assets']['Ticket'][$ticket_id]; ?>
                        </td>
                        <td>
                            <?php echo $buff['customer_id']; ?><br>
                            <?php echo $buff['organization_id']; ?>
						</td>
                        <td><?php echo $buff['time_unit']; ?></td>
                        <td>
                            <?php echo $c_zammad->format_date($buff['created_at']); ?><br>
                            <span class="table-data-small">
								<?php echo $c_zammad->format_date($buff['updated_at']); ?>
							</span>
                        </td>
                        <td>
							<?php echo $c_zammad->format_date($buff['last_close_at']); ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>


