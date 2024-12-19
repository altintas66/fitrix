<?php if(NULL != $abonnements) { ?>
	<div class="table-responsive">
		<table class="table table-striped js_table js_table_abonnements table-center sortable-table">
			<?php 
                $c_html->table_header(array(
					array('title' => 'ID'),
					array('title' => 'Kunde'),
					array('title' => 'Umsatz<br>pro Monat'),
					array('title' => 'Verträge'),
                    array('title' => 'Zuletzt bearbeitet'),
					array('title' => 'Status'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
				
            ?>
			<tbody>
				<?php foreach($abonnements AS $buff) {  
					$umsatz_pro_monat = $abonnement_daten[$buff['abonnement_id']]['umsatz_pro_monat'];
					$gesamt_umsatz_pro_monat += $umsatz_pro_monat;

				?>
					<tr data-status="<?php echo $buff['status']; ?>">
						<td><?php echo $buff['abonnement_id']; ?></td>
						<td>
							<?php echo $c_table_helper->get_td_kunde($buff); ?> 
						</td>
						<td>
							<?php echo $c_html->waehrung($umsatz_pro_monat); ?> 
						</td>
						<td>
							<?php echo $c_helper->get_size_of_array($buff['vertraege']); ?> 
						</td>
                        <td><?php echo $c_html->datum_uhrzeit($buff['bearbeitet_am'], true, false); ?></td>
						<td>
							<?php $c_form->status_edit($buff['status'], $buff['abonnement_id'], $c_abonnement->get_tablename()); ?>
						</td>
						<td class="text-right">
							<div class="actions">
								<?php 
                                    echo $c_form->edit(
                                        $buff['abonnement_id'], 
                                        'edit_abonnement', 
                                        $c_url->get_abonnement_bearbeiten($buff['abonnement_id'])
                                    ); 
                                ?>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td>
						<?php echo $c_html->waehrung($gesamt_umsatz_pro_monat); ?> 
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>
<?php } ?>