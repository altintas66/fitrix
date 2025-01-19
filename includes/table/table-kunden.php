<?php if(NULL != $kunden) { ?>
	<div class="table-responsive">
		<table class="table table-striped js_table js_table_kunden table-center sortable-table">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Logo'),
					array('title' => 'Firmenname'),
                    array('title' => 'Kontakt<br>Daten'),
                    array('title' => 'Anschrift'),
					array('title' => 'Mwst Satz'),
					array('title' => 'Status'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($kunden AS $buff) { 
				?> 
					<tr data-status="<?php echo $buff['status']; ?>">
                        <td>
							<?php echo $c_table_helper->get_kunde_logo($buff); ?>
						</td>
                        <td>
							<?php echo $c_helper->string_neue_zeilen($buff['firmen_name'], 30); ?><br>
                            <span class="table-data-small">Suchname: <?php echo $buff['suchname']; ?></span>
						</td>
						<td>
							<?php echo $buff['telefon']; ?><br>
							<?php echo $buff['email']; ?><br> 
							<?php if($buff['webseite'] != '') { ?> 
								<a href="<?php echo $buff['webseite']; ?>" class="a_link" target="_blank">Webseite</a>	
							<?php } ?>
						</td>
						<td>
                            <?php echo $buff['strasse']; ?><br>
                            <?php echo $buff['plz']; ?>
                            <?php echo $buff['ort']; ?>
                        </td>
						<td>
                            <?php echo $buff['mwst_bezeichnung']; ?>
                        </td>
						<td>
							<?php $c_form->status_edit($buff['status'], $buff['kunde_id'], $c_kunde->get_tablename()); ?>
						</td>
						<td class="text-right"> 
							<div class="actions">
								<?php 
                                    echo $c_form->edit(
                                        $buff['kunde_id'], 
                                        'edit_kunde', 
                                        $c_url->get_kunde_bearbeiten($buff['kunde_id'])
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