<?php

	include 'init.php';
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Version', '#')));
	
	global $version, $versionen;

	
?>

	<p>Version Nummer: <?php echo $version['nummer']; ?></p>

	<div class="card">
		<?php $c_html->card_header('Versionsupdates'); ?>
		<div class="card-body">
			<?php foreach($versionen AS $version_nummer => $version_aenderungen) { ?>
				<p><?php echo $version_nummer; ?></p>
				<ul>
					<?php foreach($version_aenderungen AS $aenderung) { ?>
						<li>
							<?php echo $aenderung; ?>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>
		</div>
	</div>

	
<?php 
	$c_html->get_footer(); 
?>