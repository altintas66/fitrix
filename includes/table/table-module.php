	
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Bezeichnung'),
					array('title' => 'Status'),
                ));
            ?>
			<tbody>
				<?php foreach($module AS $key => $buff) { ?>
					<tr> 
						<td><?php echo $buff['bezeichnung']; ?></td>
						<td><?php echo $buff['status']; ?></td>	
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
