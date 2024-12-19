<?php if(NULL != $mehrwertsteuersaetze) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Name'),
					array('title' => 'Angelegt am'),
					array('title' => 'Bearbeitet am'),
                    array('title' => 'Steuersatz'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($mehrwertsteuersaetze AS $buff) { 
				?>
					<tr>
                        <td>
							<?php echo $buff['name']; ?> 
						</td>
						<td><?php echo $c_html->datum_uhrzeit($buff['angelegt_am'], true, false); ?></td>
						<td><?php echo $c_html->datum_uhrzeit($buff['bearbeitet_am'], true, false); ?></td>
                        <td>
							<?php echo $buff['steuersatz']; ?> %
						</td>
						<td class="text-right">
							<div class="actions">
								<?php 
									echo $c_form->edit(
										$buff['ort_id'], 
										'edit_ort', 
										$c_url->get_ort_bearbeiten($buff['ort_id'])
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