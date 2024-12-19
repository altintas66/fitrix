<?php if(NULL != $zyklen) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Bezeichnung'),
					array('title' => 'Angelegt am'),
					array('title' => 'Bearbeitet am'),
                    array('title' => 'Anzahl Monate für die Berechnung'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($zyklen AS $buff) { 
				?>
					<tr>
                        <td><?php echo $buff['bezeichnung']; ?></td>						
						<td><?php echo $c_html->datum_uhrzeit($buff['angelegt_am'], true, false); ?></td>
						<td><?php echo $c_html->datum_uhrzeit($buff['bearbeitet_am'], true, false); ?></td>
                        <td>
                            <?php 
                                echo $buff['anzahl_monate']; 
                                if($buff['anzahl_monate'] == '1') echo ' Monat';
                                else echo ' Monate';
                            ?>
                        </td>		
						<td class="text-right">
							<div class="actions">
								<?php 
									echo $c_form->edit(
										$buff['zyklus_id'], 
										'edit_zyklus', 
										$c_url->get_zyklus_bearbeiten($buff['zyklus_id'])
									); 
								?>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>