<?php if(NULL != $artikel_typen) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Bezeichnung'),
					array('title' => 'Angelegt am'),
					array('title' => 'Bearbeitet'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($artikel_typen AS $buff) { 
				?>
					<tr>
                        <td>
							<?php echo $buff['bezeichnung']; ?> 
						</td>
						<td><?php echo $c_html->datum_uhrzeit($buff['angelegt_am'], true, false); ?></td>
						<td><?php echo $c_html->datum_uhrzeit($buff['bearbeitet_am'], true, false); ?></td>
						<td class="text-right">
							<div class="actions">
								<?php 
									echo $c_form->edit(
										$buff['artikel_typ_id'], 
										'edit_artikel_typ', 
										$c_url->get_artikel_typ_bearbeiten($buff['artikel_typ_id'])
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