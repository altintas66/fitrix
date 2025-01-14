<?php if(NULL != $hostings) { ?>
	<div class="table-responsive">
		<table class="table table-striped js_table js_table_hostings table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Name'),
                    array('title' => 'Server'),
					array('title' => 'Kunde'),
					array('title' => 'Webhosting'),
					array('title' => 'Traffic (MB) monatlich'),
					array('title' => 'URL'),
                    array('title' => 'Status'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($hostings AS $buff) { 
				?>
					<tr data-server="<?php echo $buff['server_name']; ?>">
                        <td><?php echo $buff['name']; ?></td>
                        <td><?php echo $buff['server_name']; ?></td>
                        <td><?php echo $buff['kunde_firmen_name']; ?></td>
                        <td>
                            <?php echo $buff['artikel_name']; ?>
                        </td>
						<td>
                            <?php echo $buff['traffic_mb_monatlich']; ?> MB
                        </td>
                        <td>
                            <a href="<?php echo $buff['url']; ?>" target="_blank">URL</a><br>
						</td>
                        <td>
							<?php $c_form->status_edit($buff['status'], $buff['hosting_id'], $c_server->get_tablename()); ?>
						</td>
						<td class="text-right">
							<div class="actions">
								<?php 
									echo $c_form->edit(
										$buff['hosting_id'], 
										'edit_ort', 
										$c_url->get_hosting_bearbeiten($buff['hosting_id'])
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