	
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Erstellt am'),
					array('title' => 'Empfänger'),
					array('title' => 'Betreff'),
					array('title' => 'SMTP Response'),
					array('title' => 'Text')
                ));
            ?>
			<tbody>
				<?php foreach($email_logs AS $buff) { ?>
					<tr> 
						<td>
							<?php echo $c_html->datum_uhrzeit($buff['erstellt_am'], true, false); ?>
						</td>
						<td><?php echo $buff['empfaenger']; ?></td>
                        <td><?php echo $buff['betreff']; ?></td>
                        <td><?php echo $buff['smtp_response']; ?></td>
                        <td><?php echo $c_helper->string_neue_zeilen($buff['text'], 50); ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
