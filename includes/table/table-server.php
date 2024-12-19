<?php if(NULL != $server) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Name'),
                    array('title' => 'Anzahl Hostings'),
					array('title' => 'IP'),
					array('title' => 'Plesk'),
                    array('title' => 'Status'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody class="sort" data-table="<?php echo $c_server->get_tablename(); ?>">
				<?php foreach($server AS $buff) { ?>
					<tr data-id="<?php echo $buff['server_id']; ?>">
                        <td><?php echo $buff['name']; ?></td>
                        <td> <?php echo $buff['anzahl_hostings']; ?> </td>
                        <td><?php echo $buff['ip_adresse']; ?></td>
                        <td>
                            <a href="<?php echo $buff['plesk_url']; ?>" target="_blank">URL</a><br>
                            <span class="table-data-small">
                                <?php echo $buff['plesk_user']; ?><br>
                                <?php echo $buff['plesk_passwort']; ?>
                            </span>
                        </td>
                        <td>
							<?php $c_form->status_edit($buff['status'], $buff['server_id'], $c_server->get_tablename()); ?>
						</td>
						<td class="text-right">
							<div class="actions">
								<?php 
									echo $c_form->edit(
										$buff['server_id'], 
										'edit_ort', 
										$c_url->get_server_bearbeiten($buff['server_id'])
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