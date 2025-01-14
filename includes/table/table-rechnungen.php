<?php if(NULL != $rechnungen) { ?>
	<div class="table-responsive">
		<table class="table table-striped js_table js_table_rechnungen table-center sortable-table">
			<?php 
				$gesamt_ausblenden = true;
				$zahlung_ausblenden = true;
				
				if($c_permission->check_user_has_permission('RECHNUNG_UEBERSICHT_GESAMTBETRAG_ANZEIGEN')) $gesamt_ausblenden = false;
				if($c_permission->check_user_has_permission('RECHNUNG_UEBERSICHT_ZAHLUNGSBETRAG_ANZEIGEN')) $zahlung_ausblenden = false;

				
				$c_html->table_header(array(
					array('title' => 'Rechnungsnr.'),
					array('title' => 'Kunde'),
                    array('title' => 'Rechnungs-<br>datum'),
					array('title' => 'Fällig-<br>am'),
					array('title' => 'Gesamt<br>(brutto)', 'ausblenden' => $gesamt_ausblenden),
					array('title' => 'Zahlung', 'ausblenden' => $zahlung_ausblenden),
					array('title' => 'Status'),
					array('title' => 'Gesendet'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($rechnungen AS $buff) { 
				?>
					<tr data-status="<?php echo $buff['status'] ?>">
                        <td <?php
							if($buff['status'] == 'offen' || $buff['status'] == 'bezahlt') echo 'style="font-weight: bold;"';
						?> >
							<a href="<?php echo $c_url->get_rechnung_bearbeiten($buff['rechnung_id']); ?>" class="a_link" style="text-decoration:none;">
								<?php echo $buff['rechnungsnummer']; ?><br>
							</a>
						</td>
						<td>
							<?php echo $c_table_helper->get_td_kunde($buff); ?> 
						</td>
						<td>
							<a href="<?php echo $c_url->get_rechnung_bearbeiten($buff['rechnung_id']); ?>" class="a_link" style="text-decoration:none;">
								<?php echo $c_html->datum($buff['rechnungsdatum'], true, false); ?>
							</a>
						</td>
						<td>
							<span class="<?php echo $buff['faellig_am_class']; ?>">
								<?php echo $c_html->datum($buff['faellig_am'], true, false); ?>
							</span>
						</td>
						<?php if($gesamt_ausblenden == false)  { ?>
							<td>
								<?php echo $c_html->waehrung($buff['gesamt_brutto']); ?>
							</td>
						<?php } ?>
						<?php if($zahlung_ausblenden == false)  { ?>
							<td>
								<span class="<?php echo $buff['gesamt_zahlung_class']; ?>">
									<?php echo $c_html->waehrung($buff['gesamt_zahlung']); ?>
								</span>
							</td>
						<?php } ?>
						<td>
							<?php echo $buff['status_label']; ?>
							<?php if($buff['ausgedruckt'] == 1) echo '<i class="fa fa-print"></i>';?> 
						</td> 
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