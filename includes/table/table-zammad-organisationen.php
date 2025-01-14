<?php if(NULL != $organisationen) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'ID'),
                    array('title' => 'Name'),
					array('title' => 'Domain'),
                    array('title' => 'Erstellt am'),
                    array('title' => 'Anzahl Kunden')
                ));
            ?>
			<tbody>
				<?php foreach($organisationen AS $orga_id => $buff) { ?>
					<tr>
                        <td>
							<?php echo $buff['id']; ?><br>
						</td>
                        <td>
							<?php echo $buff['name']; ?><br>
						</td>
                        <td>
							<?php echo $c_zammad->get_zammad_domains($buff['domain']); ?><br>
						</td>
                        <td>
							<?php echo $buff['erstellt_am']; ?><br>
						</td>
                        <td>
                            <?php 
								echo sizeof($buff['member_ids']);
								$html = '';
								foreach($buff['member_ids'] AS $member_id) {
									if(!isset($kunden[$member_id])) continue; 
									$kunde = $kunden[$member_id];
									$html .= $kunde['vorname'].' '.$kunde['nachname'].', ';
								}
								$html = substr($html, 0, -2);
								$html = $c_helper->string_neue_zeilen($html, 40);
							?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>