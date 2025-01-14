<?php if(NULL != $zahlungsarten) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Bezeichnung'),
                    array('title' => 'Bearbeitet am'),
					array('title' => 'Status'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($zahlungsarten AS $buff) { 
				?>
					<tr>
                        <td>
							<?php echo $buff['bezeichnung']; ?><br>
						</td>
                        <td><?php echo $c_html->datum_uhrzeit($buff['bearbeitet_am'], true, false); ?></td>
						<td>
							<?php $c_form->status_edit($buff['status'], $buff['zahlungsart_id'], $c_zahlungsart->get_tablename()); ?>
						</td>
						<td class="text-right">
							<div class="actions">
								<?php 
                                    echo $c_form->edit(
                                        $buff['zahlungsart_id'], 
                                        'edit_zahlungsart', 
                                        $c_url->get_zahlungsart_bearbeiten($buff['zahlungsart_id'])
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