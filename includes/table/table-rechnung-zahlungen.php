<?php if(NULL != $buff['zahlungen']) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Zahlungsdatum'),
					array('title' => 'Zahlungsart'),
					array('title' => 'Zahlungsbetrag'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php foreach($buff['zahlungen'] AS $zahlung) { 
				?>
					<tr>
                        <td>
							<?php echo $c_helper->german_date_no_time($zahlung['zahlungsdatum']); ?> 
						</td>
                        <td>
							<?php echo $zahlung['zahlungsart']; ?> 
						</td>
						<td><?php echo $c_html->waehrung($zahlung['zahlungsbetrag']); ?></td>
						<td class="text-right">
							<div class="actions">
								<?php 
                                    $c_button->button_rechnung_zahlung_loeschen(
                                        $zahlung['rechnung_zahlung_id']
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