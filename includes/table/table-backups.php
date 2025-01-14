	
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Dateiname'),
					array('title' => 'Erstellt am'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($backups AS $buff) { ?>
					<tr> 
                        <td>
							<?php echo $buff['dateiname']; ?>
						</td>
						<td>
							<?php 
								echo $c_html->datum_uhrzeit($buff['erstellt_am'], true, false); 
							?>
						</td>
						<td class="text-right">
							<?php 
								$c_button->button_backup_loeschen(
                                    $buff['backup_id']
                                );
							?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
