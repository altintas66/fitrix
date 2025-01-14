<?php if(NULL != $rechnungen) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Rechnungsnummer'),
					array('title' => 'Erstellt am'),
					array('title' => 'berechnete Verträge'),
					array('title' => 'Status'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($rechnungen AS $buff) { 
                    $positionen = $c_rechnung_position->get_all($buff['rechnung_id']);
				?>
					<tr>
						<td>
                            <?php echo $buff['rechnungsnummer']; ?>
						</td>
						<td>
                            <?php echo $c_html->datum_uhrzeit($buff['angelegt_am'], true, false); ?>
						</td>
						<td>
                            <ul>
                                <?php foreach($positionen AS $position){ ?>
                                    <li>
                                        <?php echo $position['artikel_name']; ?> (<?php echo $position['artikel_menge']; ?> <?php echo $position['artikel_einheit']; ?>)
                                        <br>
                                        <span class="table-data-small"><?php echo $c_html->waehrung($position['artikel_preis']); ?>  <?php echo $position['artikel_zyklus']; ?></span>
                                    </li>
                                <?php } ?>
                            </ul>
						</td>
						<td>
                            <?php echo $buff['status_label']; ?>
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