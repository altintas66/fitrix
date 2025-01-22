<?php if(NULL != $kunden) { ?>
	<div class="table-responsive">
		<table class="table table-striped js_table js_table_kunden table-center sortable-table">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Logo'),
					array('title' => 'Firmenname'),
                    array('title' => 'Kontakt<br>Daten'),
                    array('title' => 'Anschrift'),
					array('title' => 'Mwst Satz'),
					array('title' => 'Status'),
					array('title' => 'Optionen', 'class' => 'text-right')
                ));
            ?>
			<tbody>
				<?php 
					echo $c_table_helper->get_table_kunden($kunden);
				?>
			</tbody>
		</table>
	</div>
<?php } ?>