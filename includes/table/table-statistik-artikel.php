<?php if(NULL != $artikel_ids) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
                    array('title' => 'Foto'),
					array('title' => 'Artikelname'),
					array('title' => 'Anzahl'),
                ));
            ?>
			<tbody>
				<?php foreach($artikel_ids AS $buff) { 
                    if($buff['artikel_id'] == null) continue;
                    if($buff['anzahl'] == 0) continue;
                    $artikel = $c_artikel->get($buff['artikel_id']);
                ?>
					<tr data-status="<?php echo $buff['status']; ?>">
                        <td>
							<?php echo $c_table_helper->get_artikel_foto($artikel); ?>
						</td>
                        <td>
							<?php echo $artikel['artikel_name']; ?><br>
							<span class="table-data-small">
								Artikelnummer: <?php echo $buff['artikel_nummer']; ?><br>
								Artikel Typ: <?php echo $buff['artikel_typ']; ?>
							</span>
							
						</td>		
						<td><?php echo $buff['anzahl']; ?></td>	
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?> 