<?php if(NULL != $kunden) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Firmenname'),
                    array('title' => 'Quality Hosting Reseller Customer ID')
                ));
            ?>
			<tbody>
				<?php foreach($kunden AS $buff) { ?> 
					<tr>
                        <td>
							<?php echo $c_helper->string_neue_zeilen($buff['firmen_name'], 30); ?><br>
                            <span class="table-data-small">Suchname: <?php echo $buff['suchname']; ?></span>
						</td>
						<td>
							<?php echo $buff['quality_hosting_reseller_customer_id']; ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>