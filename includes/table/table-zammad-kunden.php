<?php if(NULL != $kunden) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'ID'),
                    array('title' => 'Name'),
                    array('title' => 'Erstellt am'),
                    array('title' => 'E-Mail'),
                ));
            ?>
			<tbody>
				<?php foreach($kunden AS $kunde_id => $buff) { ?>
					<tr>
                        <td>
							<?php echo $kunde_id; ?>
						</td>
                        <td>
							<?php echo $buff['vorname']; ?><br>
                            <?php echo $buff['nachname']; ?>
						</td>
                        <td>
							<?php echo $buff['erstellt_am']; ?><br>
						</td>
                        <td>
							<?php echo $buff['email']; ?>
						</td>
                        
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>