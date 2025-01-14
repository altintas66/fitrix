<?php if(NULL != $letzte_user) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Foto'),
					array('title' => 'Username'),
                    array('title' => 'E-Mail'),
					array('title' => 'Letzte Aktivität'),
                ));
            ?>
			<tbody>
				<?php foreach($letzte_user AS $buff) { ?>
					<tr>
						<td>
							<?php echo $c_html->get_user_foto($buff); ?>
						</td>
                        <td>
							<?php echo $buff['username']; ?> 
						</td>
                        <td>
							<?php echo $buff['email']; ?> 
						</td>
						<td><?php echo $c_html->datum_uhrzeit($buff['letzter_login'], true, false); ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>