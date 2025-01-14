<?php
	$count = 1;
	$last = sizeof($entries) - 1;
?>
<div class="page-header">
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<h3 class="page-title"><?php echo $entries[$last][0]; ?></h3>
			<ul class="breadcrumb">
				<li class="breadcrumb-item "><a href="index.php">Dashboard</a></li>
				<?php foreach($entries AS $e) { ?>
						<li class="breadcrumb-item <?php if($count == sizeof($entries)) echo 'active'; ?>">
							<a href="<?php echo $e[1]; ?>"><?php echo $e[0]; ?></a>
						</li>
					<?php $count++; ?>
				<?php } ?>
			</ul>
		</div>	
	</div>
</div>

