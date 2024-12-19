<?php if(NULL != $ansprechpartner) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Name'),
					array('title' => 'Angelegt am'),
					array('title' => 'Bearbeitet am'),
                    array('title' => 'E-Mail'),
                    array('title' => 'Mobil'),
                    array('title' => 'Whatsapp'),
					array('title' => 'Bemerkung'),
                    array('title' => 'Status'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($ansprechpartner AS $buff) { 
				?>
					<tr>
                        <td>
                            <?php echo $buff['anrede']; ?>
                            <?php echo $buff['vorname']; ?>
                            <?php echo $buff['nachname']; ?>
                        </td>						
						<td><?php echo $c_html->datum_uhrzeit($buff['angelegt_am'], true, false); ?></td>
						<td><?php echo $c_html->datum_uhrzeit($buff['bearbeitet_am'], true, false); ?></td>
                        <td><?php echo $buff['email']; ?></td>		
                        <td>
                            <?php echo $buff['mobilnummer']; ?><br>
                            
                        </td>
                        <td><?php if($buff['whatsapp'] == '1') echo 'Ja'; else echo 'Nein'; ?></td>
                        <td>
							<?php 
								echo $c_helper->string_neue_zeilen(
									$buff['bemerkung'], 
									30
								); 
							?>
						</td>
						<td>
							<?php $c_form->status_edit($buff['status'], $buff['ansprechpartner_id'], $c_ansprechpartner->get_tablename()); ?>
						</td>
						<td class="text-right">
							<div class="actions">
								<?php 
									echo $c_button->button_ansprechpartner_bearbeiten($buff['ansprechpartner_id']); 
								?>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>