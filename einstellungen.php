<?php
	include 'init.php';
	
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Einstellungen', '#')));

	if(isset($_POST['submit'])) {
		$errors = $c_einstellungen->update_einstellungen($_POST, $_FILES);
	}
	
	global $config;
	
	$einstellungen = $c_einstellungen->get_all();

	$nav_array = array(
		'allgemein'        => 'Allgemein',
		'smtp'             => 'SMTP Einstellungen',
		'bilder'           => 'Bilder',
		'angebot'          => 'Angebot',
		'rechnung'         => 'Rechnung',
		'optionen'         => 'Optionen'
	);
?>

	<form action="#" method="POST" enctype="multipart/form-data" class="form-edit">
	
		<?php 
			$c_form->tabs_navigation('Einstellungen', $nav_array);
			$counter = 1;
		?>

		<?php foreach($nav_array AS $nav_key => $nav_value) { ?>

			<div id="<?php echo $nav_key; ?>" class="tabcontent" <?php if($counter > 1) echo 'style="display:none;"'; ?>>
				<?php include 'includes/form/einstellungen-'.$nav_key.'.php'; ?>
			</div>
			<?php $counter++; ?>
			
		<?php }?>


		<?php 
			$c_html->sticky_footer(
				array(
					'submit',
					'Änderungen speichern'
				)
			);
		?>
		
	</form>	

	
 
   
<?php $c_html->get_footer(); ?>