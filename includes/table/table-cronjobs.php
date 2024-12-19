	
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Ausgeführt am'),
					array('title' => 'URL'),
					array('title' => 'Ausführungszeit'),
					array('title' => 'Anmerkungen'),
					array('title' => 'Info')
                ));
            ?>
			<tbody>
				<?php foreach($cronjobs AS $buff) { ?>
					<tr> 
						<td>
							<?php 
								echo $c_html->datum_uhrzeit($buff['ausgefuehrt_am'], true, false); 
							?>
						</td>
						<td>
							<?php echo $buff['url']; ?>
						</td>
						<td>
							<?php echo number_format($buff['ausfuehrungszeit'], 2, ',', ' '); ?> Sek.
						</td>
                        <td>
							<?php echo $buff['anmerkungen']; ?>
						</td>
						<td>
							<?php 
								$info = json_decode($buff['json'], true); 
								echo $c_html->array_2_ul($info);
							?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
