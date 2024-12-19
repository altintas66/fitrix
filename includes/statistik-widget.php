<?php 
	if (strpos($icon, 'fa') === false) $pre_icon = 'fe ';
	else $pre_icon = '';

?>

<div class="card statistik-widget">
	<?php $this->card_header($label); ?>
	<div class="card-body">
		<div class="dash-widget-header">
			<span class="dash-widget-icon text-<?php echo $farbe; ?> border-<?php echo $farbe; ?>">
				<i class="<?php echo $pre_icon.$icon; ?>"></i>
			</span>
			<div class="dash-count">
				<h3><?php echo $value; ?></h3>
			</div>
		</div>
	</div>
</div>