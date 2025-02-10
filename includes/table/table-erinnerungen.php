<?php if(NULL != $erinnerungen) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
                    array('title' => 'User'),
                    array('title' => 'Datum'),
                    array('title' => 'Text'),
                    array('title' => 'Erstellt am'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($erinnerungen AS $buff) { 
					$user = $c_user->get($buff['fk_user_id']);
				?>
					<tr>
                        <td><?php echo $user['username'] ?></td>
                        <td><?php echo $c_html->datum($buff['datum'], false); ?></td>
						<td><?php echo wordwrap($buff['text'], 130, "<br>"); ?></td>
                        <td><?php echo $c_html->datum_uhrzeit($buff['erstellt_am'], true, false); ?></td>
						<td class="text-right">
							<div class="actions">
								<?php 
                                    $c_form->delete($buff['erinnerung_id'], $c_erinnerung->get_tablename(), '');
                                ?>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>