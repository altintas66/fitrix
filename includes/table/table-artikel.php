<?php if(NULL != $artikel) { ?>
	<div class="table-responsive">
		<table class="table table-striped js_table js_table_artikel table-center sortable-table">
			<?php 
				$einr_geb_ausb = false;
				if($einstellungen['artikel_einrichtungsgebuehr_ausblenden'] == '1') $einr_geb_ausb = true;

                $c_html->table_header(array(
                    array('title' => 'Foto'),
					array('title' => 'Artikelname'),
					array('title' => 'Beschreibung'),
					array('title' => 'Preis'),
					array('title' => 'Einrichtungs-<br>gebühr', 'ausblenden' => $einr_geb_ausb),
					array('title' => 'Status'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($artikel AS $buff) { ?>
					<tr data-status="<?php echo $buff['status']; ?>">
                        <td>
							<?php echo $c_table_helper->get_artikel_foto($buff); ?>
						</td>
                        <td>
							<?php echo $buff['artikel_name']; ?><br>
							<span class="table-data-small">
								Artikelnummer: <?php echo $buff['artikel_nummer']; ?><br>
								Artikel Typ: <?php echo $buff['artikel_typ']; ?><br>
								Bearbeitet am: <?php echo $c_html->datum_uhrzeit($buff['bearbeitet_am'], true, false); ?>
							</span>
						</td>		
						<td>
							Beschreibung: <?php if($buff['artikel_beschreibung'] == '') echo 'Nein'; else echo 'Ja'; ?>
							Beschr. Ang.: <?php if($buff['artikel_beschreibung_angebot'] == '') echo 'Nein'; else echo 'Ja'; ?>
						</td>
						<td>
							<?php echo $c_html->waehrung($buff['preis']); ?> <br>
							<span class="table-data-small">
								Variationen: <?php echo $c_helper->get_size_of_array($buff['preise']); ?>
							</span>
						</td>	
						<?php if($einr_geb_ausb == false) { ?>
							<td>
								<?php echo $c_html->waehrung($buff['einrichtungsgebuehr']); ?>
							</td>		
						<?php } ?>
						<td>
							<?php $c_form->status_edit($buff['status'], $buff['artikel_id'], $c_artikel->get_tablename()); ?>
						</td>
						<td class="text-right">
							<div class="actions">
								<?php 
									echo $c_form->edit(
										$buff['artikel_id'], 
										'edit_artikel', 
										$c_url->get_artikel_bearbeiten($buff['artikel_id'])
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