<?php 
    $gesamt_brutto = 0;
    $gesamt_mwst   = 0;
    $gesamt_netto  = 0;
?>

<?php if(NULL != $zahlungen) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Rechnungsnummer'),
					array('title' => 'Datum'),
					array('title' => 'Netto'),
                    array('title' => 'MwSt.'),
                    array('title' => 'Brutto'),
                ));
            ?>
			<tbody>
				<?php foreach($zahlungen AS $buff) { 
                    $rechnung = $c_rechnung->get($buff['fk_rechnung_id']);
                    
                    $brutto = floatval($buff['zahlungsbetrag']);
		            $netto  = $c_helper->get_netto($brutto, $rechnung['mwst_satz']);
                    $mwst   = $c_helper->get_mwst($netto, $rechnung['mwst_satz']);

                    $gesamt_brutto += $brutto;
                    $gesamt_netto  += $netto;
                    $gesamt_mwst   += $mwst;

				?>
					<tr>
                        <td>
							<a class="a_link" target="_blank" href="<?php echo $c_url->get_rechnung_bearbeiten($rechnung['rechnung_id']); ?>">
                                <?php echo $rechnung['rechnungsnummer']; ?>
                            </a>
						</td>
                        <td>
							<?php echo $c_helper->german_date_no_time($buff['zahlungsdatum']); ?> 
						</td>
                        <td><?php echo $c_html->waehrung($netto); ?></td> 
                        <td><?php echo $c_html->waehrung($mwst); ?></td> 
                        <td><?php echo $c_html->waehrung($brutto); ?></td> 
					</tr>
				<?php } ?>
			</tbody>
            <tfoot>
                <tr>
                    <td>Gesamt</td>
                    <td></td>
                    <td><?php echo $c_html->waehrung($gesamt_netto); ?></td> 
                    <td><?php echo $c_html->waehrung($gesamt_mwst); ?></td> 
                    <td><?php echo $c_html->waehrung($gesamt_brutto); ?></td> 
                </tr>
            </tfoot>
		</table>
	</div>
<?php } ?>