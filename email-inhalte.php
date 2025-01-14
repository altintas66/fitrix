<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('EINSTELLUNGEN_VERWALTEN');
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('E-Mail Texte', '#')));
	
	if(isset($_POST['submit'])) {
		$c_inhalt->update_all($_POST);
	}

	$inhalte = $c_inhalt->get_all();

	$nav_array = array();

    foreach($inhalte AS $in) {
        $nav_array[$in['metakey']] = $in['bezeichnung'];
    }
 
?>

	<form method="POST" action="" class="form_email_inhalte">

		<?php 
			$c_form->tabs_navigation('E-Mail Inhalte', $nav_array);
			$counter = 1;
		?>

		<?php foreach($inhalte AS $in) { 
			$placeholders = $c_inhalt_placeholder->get_all($in['inhalt_id']);	
			$placeholder_html = $c_placeholder->get_placeholders_html($placeholders);
			
		?>
		
			<div id="<?php echo $in['metakey']; ?>" class="tabcontent" <?php if($counter > 1) echo 'style="display:none;"'; ?>>
				
				<div class="row">
					<div class="col-12">
						<div class="card">
							<?php  echo $c_html->card_header($in['bezeichnung']); ?>
							<div class="card-body">
								<p><?php echo $in['bemerkung']; ?></p>
								<p>Betreff: <?php echo $in['betreff']; ?></p>
								<?php 
									$c_form->textarea(
										'Nachricht', 
										$in['metakey'], 
										$in['metavalue'], 
										$required = false, 
										$wrapper = true
									); 
								?>
								<p>Folgende Placeholder können genutzt werden:</p>
								<?php echo $placeholder_html; ?>
							</div>    
						</div>
					</div>
				</div>
					
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
