<?php if(NULL != $vertraege) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Menge'),
					array('title' => 'Artikel'),
					array('title' => 'Start'),
					array('title' => 'Demnächst fällig'),
					array('title' => 'Beschreibung'),
					array('title' => 'Betrag'),
					array('title' => 'Status'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody class="sort" data-table="<?php echo $c_abonnement_vertrag->get_tablename(); ?>">
				<?php foreach($vertraege AS $buff) { 
				?>
					<tr data-id="<?php echo $buff['abonnement_vertrag_id']; ?>">
						<td>
							<?php echo $buff['artikel_menge']; ?>
							<br>
							<?php echo $buff['einheit_bezeichnung']; ?>
						</td>
						<td>
							<?php echo $buff['artikel_name']; ?>
						</td>
						<td>
							<?php echo $c_helper->german_date_no_time($buff['start']); ?>
						</td>
						<td>
							<?php 
								echo $c_abonnement_vertrag->get_naechste_faelligkeit($buff);
							?>
							<br>
							<span class="table-data-small"><?php echo $buff['zyklus_bezeichnung']; ?></span>
						</td>
						<td><?php echo $buff['artikel_beschreibung']; ?></td>
						<td>
							<?php echo $c_html->waehrung($buff['artikel_preis']); ?>
						</td>
						<td>
							<?php $c_form->status_edit($buff['status'], $buff['abonnement_vertrag_id'], $c_abonnement_vertrag->get_tablename()); ?>
						</td>
						<td class="text-right">
							<div class="actions">
								<?php 
									if($buff['naechste_faelligkeit'] == null) {
										$c_button->button_abonnement_vertrag_loeschen(
											$buff['abonnement_vertrag_id']
										);
									}
                                    $c_button->button_abonnement_vertrag_bearbeiten(
                                        $buff['abonnement_vertrag_id']
                                    );
									$c_button->button_abonnement_vertrag_info(
                                        $buff['abonnement_vertrag_id']
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