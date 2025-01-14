<?php if(NULL != $faellige_rechnungen) { ?>
	<div class="table-responsive">
		<table class="table table-striped js_table js_table_mahnungen table-center sortable-table">
			<?php 
                $c_html->table_header(array(
					array('title' => 'ID'),
					array('title' => 'Rechnungsnummer<br>Zuletzt bearbeitet'),
					array('title' => 'Kunde'),
                    array('title' => 'Rechnungs-<br>datum'),
					array('title' => 'Fällig-<br>am'),
					array('title' => 'Gesamt<br>(brutto)'),
					array('title' => 'Zahlung'),
					array('title' => 'Status'),
					array('title' => 'Gesendet'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($faellige_rechnungen AS $buff) {
					//if($c_mahnung->get_all_by_rechnung_id($buff['rechnung_id']) != NULL) continue;
				?>
					<tr data-status="<?php echo $buff['status'] ?>">
						<td><?php echo $buff['rechnung_id']; ?>
						<input type="checkbox" id="js_checkbox_mahnungen" data-id = "<?php echo $buff['rechnung_id']; ?>" name="js_checkbox_mahnungen" value="1" checked>
						</td>
                        <td>
							<?php echo $buff['rechnungsnummer']; ?><br>
							<span class="table-data-small"><?php echo $c_html->datum_uhrzeit($buff['bearbeitet_am'], true, false); ?></span>
						</td>
						<td>
							<?php echo $c_table_helper->get_td_kunde($buff); ?> 
						</td>
						<td><?php echo $c_html->datum($buff['rechnungsdatum'], true, false); ?></td>
						<td>
							<span class="<?php echo $buff['faellig_am_class']; ?>">
								<?php echo $c_html->datum($buff['faellig_am'], true, false); ?>
							</span>
						</td>
						<td>
							<?php echo $c_html->waehrung($buff['gesamt_brutto']); ?>
						</td>
						<td>
							<span class="<?php echo $buff['gesamt_zahlung_class']; ?>">
								<?php echo $c_html->waehrung($buff['gesamt_zahlung']); ?>
							</span>
						</td>
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
                                        $buff['rechnung_id'], 
                                        'edit_rechnung', 
                                        $c_url->get_rechnung_bearbeiten($buff['rechnung_id'])
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