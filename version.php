<?php

	include 'init.php';
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Version', '#')));
	
	global $version, $versionen;

	
?>

	<p>Version Nummer: <?php echo $version['nummer']; ?></p>

	
	<?php foreach($versionen AS $version_nummer => $version_aenderungen) { ?>
		<div class="card">
			<?php $c_html->card_header($version_nummer); ?>
			<div class="card-body">
				<ul>
					<?php foreach($version_aenderungen AS $aenderung) { ?>
						<li>
							<?php echo $aenderung; ?>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	<?php } ?>

	
<?php 
	$c_html->get_footer(); 
?>