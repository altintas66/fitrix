<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('MAHNUNGEN_VERWALTEN');

	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Alle Mahnungen', '#')));
	

	$mahnungen = $c_mahnung->get_all();
	$faellige_rechnungen = $c_rechnung->get_all_faellige();

	
?>
	
	<div class="row mb-4"> 
		<div class="col-md-12">
            <?php 
				$c_button->button_mahnlauf_starten();
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="tabs">
				<?php 
					echo $c_html->get_tabs_navigation(array(
						'tabs-1' => 'Mahnungen',
						'tabs-2' => 'Versendete Mahnungen'
					));
				?>
				<div id="tabs-1">
					<?php if($faellige_rechnungen != NULL) { ?>
						<div class="row">
							<div class="col-md-12">
								<div class="card card-table">
									<?php $c_html->card_header(
										$c_table_helper->get_card_title_mit_verfuegbarkeit(
											'Mahnungen',
											'mahnung'
										)
									); ?>
									<div class="card-body">
										<?php include 'includes/table/table-mahnungen.php'; ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<div id="tabs-2">
				<?php if($mahnungen != NULL) { ?>
						<div class="row">
							<div class="col-md-12">
								<div class="card card-table">
									<?php $c_html->card_header('Versendete Mahnungen'); ?>
									<div class="card-body">
										<?php include 'includes/table/table-versendete-mahnungen.php'; ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>



   
<?php $c_html->get_footer(); ?>