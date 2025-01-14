<?php if(NULL != $orte) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Ortsname'),
					array('title' => 'Angelegt am'),
					array('title' => 'Bearbeitet'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($orte AS $buff) { 
				?>
					<tr>
                        <td><?php echo $buff['ortsname']; ?></td>
						<td><?php echo $c_html->datum_uhrzeit($buff['angelegt_am'], true, false); ?></td>
						<td><?php echo $c_html->datum_uhrzeit($buff['bearbeitet_am'], true, false); ?></td>
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