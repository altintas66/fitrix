<?php if(NULL != $einheiten) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Bezeichnung'),
                    array('title' => 'Bearbeitet am'),
					array('title' => 'Status'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($einheiten AS $buff) { 
				?>
					<tr>
                        <td>
							<?php echo $buff['bezeichnung']; ?><br>
						</td>
                        <td><?php echo $c_html->datum_uhrzeit($buff['bearbeitet_am'], true, false); ?></td>
						<td>
							<?php $c_form->status_edit($buff['status'], $buff['einheit_id'], $c_einheit->get_tablename()); ?>
						</td>
						<td class="text-right">
							<div class="actions">
								<?php 
                                    echo $c_form->edit(
                                        $buff['einheit_id'], 
                                        'edit_einheit', 
                                        $c_url->get_einheit_bearbeiten($buff['einheit_id'])
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