<?php if(NULL != $angebote) { ?>
	<div class="table-responsive">
		<table class="table table-striped js_table js_table_angebote table-center sortable-table">
			<?php 
                $c_html->table_header(array(
					array('title' => 'ID'),
					array('title' => 'Angebotsnummer'),
                    array('title' => 'Zuletzt bearbeitet'),
					array('title' => 'Kunde'),
                    array('title' => 'Angebotsdatum'),
					array('title' => 'Gesamt'),
					array('title' => 'Status'),
					array('title' => 'Gesendet'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?> 
			<tbody>
				<?php foreach($angebote AS $buff) { 
				?> 
					<tr data-status="<?php echo $buff['status'] ?>">
						<td><?php echo $buff['angebot_id']; ?></td>
                        <td><?php echo $buff['angebotsnummer']; ?></td>
                        <td><?php echo $c_html->datum_uhrzeit($buff['bearbeitet_am'], true, false); ?></td>
						<td>
							<?php echo $c_table_helper->get_td_kunde($buff); ?> 
						</td>
						<td><?php echo $c_html->datum($buff['angebotsdatum'], true, false); ?></td>
						<td><?php echo $c_html->waehrung($buff['brutto_betrag']); ?></td>
						<td><?php echo $buff['status_label']; ?></td>
						<td>
							<?php 
								if($buff['gesendet'] == '1') echo 'Ja ('.$c_helper->german_date($buff['gesendet_am']).')';
								else echo 'Nein';
							?>
						</td>
						<td class="text-right">
							<div class="actions">
								<?php 
                                    echo $c_form->edit(
                                        $buff['angebot_id'], 
                                        'edit_angebot', 
                                        $c_url->get_angebot_bearbeiten($buff['angebot_id'])
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