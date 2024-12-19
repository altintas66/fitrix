<?php if($anzahl_tickets > 0) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'ID'),
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
					$gesamt_takt += floatval($buff['time_unit']);
                ?>
					<tr>
						<td>
                            <a target="_blank" class="a_link" href="<?php echo $config['zammad_url']; ?>#ticket/zoom/<?php echo $buff['id']; ?>">
                                <?php echo $buff['number']; ?>
                            </a>
                        </td>
                        <td>
							<?php echo $c_helper->string_neue_zeilen($buff['title'], 30); ?><br>
						</td>
						<td>
							<?php echo $buff['owner_id']; ?>
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


