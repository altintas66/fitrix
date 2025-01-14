<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
				$c_html->table_header(array(
					array('title' => 'Zuletzt aktualisiert'),
					array('title' => 'Cache'),
					array('title' => 'Optionen', 'class' => 'text-right')
				));
			?>
			<tbody>
				<?php foreach($dateien AS $key => $value) { ?>
					<tr>
						<td><?php echo $c_helper->german_date(date("Y-m-d H:i:s", filectime($value))); ?></td>
						<td><?php echo $key; ?></td>
						<td class="text-right">
							<form method="POST" action="">
								<?php $c_form->button_submit('update_'.strtolower($key), '<i class="fa fa-refresh fa-spin"></i> Cache leeren', 'btn btn-success btn-icon', false); ?>
							</form>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>