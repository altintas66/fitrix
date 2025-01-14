<?php if(NULL != $erinnerungen) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
                    array('title' => 'Erstellt am'),
					array('title' => 'Verlinkung'),
                    array('title' => 'Text'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($erinnerungen AS $buff) { 
				?>
					<tr>
                        <td><?php echo $c_html->datum_uhrzeit($buff['erstellt_am'], true, false); ?></td>
                        <td><?php echo $c_erinnerung->get_verlinkung($buff['fk_eintrag_id'], $buff['typ']); ?></td>
						<td><?php echo $buff['text']; ?></td>
						<td class="text-right">
							<div class="actions">
								<?php 
                                    $c_form->delete($buff['erinnerung_id'], $c_erinnerung->get_tablename());
                                ?>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>