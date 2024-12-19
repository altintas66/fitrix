<?php 
    $gesamt_brutto = 0;
    $gesamt_netto  = 0;
    $gesamt_mwst   = 0;
?>

<?php if(NULL != $rechnungen) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Rechnungsnummer'),
					array('title' => 'Rechnungsdatum'),
                    array('title' => 'Kunde'),
                    array('title' => 'Status'),
					array('title' => 'Netto'),
                    array('title' => 'MwSt.'),
                    array('title' => 'Brutto'),
                ));
            ?>
			<tbody>
				<?php foreach($rechnungen AS $buff) { 
                    
                    $gesamt_brutto += $buff['gesamt_brutto'];
                    $gesamt_mwst   += $buff['gesamt_mwst'];
                    $gesamt_netto  += $buff['gesamt_netto'];
				?>
					<tr>
                        <td>
							<a class="a_link" target="_blank" href="<?php echo $c_url->get_rechnung_bearbeiten($buff['rechnung_id']); ?>">
                                <?php echo $buff['rechnungsnummer']; ?>
                            </a>
						</td>
                        <td>
							<?php echo $c_helper->german_date_no_time($buff['rechnungsdatum']); ?> 
						</td>
                        
                        <td>
							<?php echo $c_table_helper->get_td_kunde($buff); ?> 
						</td>
                        <td><?php echo $buff['status_label']; ?></td>
                        <td><?php echo $c_html->waehrung($buff['gesamt_netto']); ?></td> 
                        <td><?php echo $c_html->waehrung($buff['gesamt_mwst']); ?></td> 
                        <td><?php echo $c_html->waehrung($buff['gesamt_brutto']); ?></td> 
					</tr>
				<?php } ?>
			</tbody>
            <tfoot>
                <tr>
                    <td>Gesamt</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $c_html->waehrung($gesamt_netto); ?></td> 
                    <td><?php echo $c_html->waehrung($gesamt_mwst); ?></td> 
                    <td><?php echo $c_html->waehrung($gesamt_brutto); ?></td> 
                </tr>
            </tfoot>
		</table>
	</div>
<?php } ?>