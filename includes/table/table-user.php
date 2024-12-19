<?php if(NULL != $users) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Foto'),
					array('title' => 'Username/<br>Name'),
                    array('title' => 'Rolle'),
					array('title' => 'Letzte Aktivität'),
					array('title' => 'E-Mail'),
					array('title' => 'Status'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($users AS $buff) { ?>
					<tr>
						<td>
							<?php echo $c_html->get_user_foto($buff); ?>
						</td>
                        <td>
							<?php echo $buff['username']; ?><br>
							<span class="table-data-small"><?php echo $buff['nachname']; ?> 
							<?php echo $buff['vorname']; ?></span>
						</td>
						<td>
							<?php echo $buff['rolle']; ?>
						</td>
						<td><?php echo $c_html->datum_uhrzeit($buff['letzter_login'], true, false); ?></td>
						<td><?php echo $buff['email']; ?></td>
						<td>
							<?php $c_form->status_edit($buff['status'], $buff['user_id'], $c_user->get_tablename()); ?>
						</td>
						<td class="text-right">
							<div class="actions">
								<?php echo $c_form->edit($buff['user_id'], 'edit_user', $c_url->get_user_bearbeiten($buff['user_id'])); ?>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>