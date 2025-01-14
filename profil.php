<?php
	include 'init.php';
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Profil', '#')));
	
	if(!isset($_SESSION['id'])) $c_html->keine_berechtigung();
	
	if(isset($_POST['btn_passwort_submit'])) {
		$c_user->update_passwort($_SESSION['id'], $_POST['passwort']);
		$c_helper->redirect($c_url->get_profil(), 'Änderungen+erfolgreich+gespeichert&type=success');
	}

	$user = $c_user->get($_SESSION['id']);


?>
	
	<div class="row js_profil_wrapper">
		<div class="col-lg-12">
			<div class="card">
				<?php $c_html->card_header('Persönliche Daten'); ?>
				<div class="card-body">
					<form method="POST" action="" class="form-edit">
						<div class="row">
							<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">
								Name
							</p>
							<p class="col-sm-10">
								<?php echo $user['nachname']; ?> <?php echo $user['vorname']; ?>
							</p>
						</div>
						<div class="row">
							<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">
								Registriert am
							</p>
							<p class="col-sm-10">
								<?php echo $c_helper->german_date($user['angelegt_am']); ?>
							</p>
						</div>
						<div class="row">
							<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">
								Letzte Aktivität
							</p>
							<p class="col-sm-10">
								<?php echo $c_helper->german_date($user['letzter_login']); ?>
							</p>
						</div>
						<div class="row">
							<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">
								Email
							</p>
							<p class="col-sm-10">
								<?php echo $user['email']; ?>
							</p>
						</div>
						<div class="row">
							<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">
								Username
							</p>
							<p class="col-sm-10">
								<?php echo $user['username']; ?>
							</p>
						</div>
						<div class="row">
							<p class="col-sm-2 text-muted text-sm-right mb-0">
								Theme Mode
							</p>
							<div class="col-sm-10">
								<?php 
									$c_form->theme_mode(
										false, 
										$user['theme_mode']
									);
								?>
							</div>
						</div>
						<div class="row">
							<p class="col-sm-2 text-muted text-sm-right mb-0">
								Passwort
							</p>
							<p class="col-sm-10">
								Falls Sie ein neues Passwort wünschen, geben Sie bitte weiter unten 
								Ihr neues Passwort ein.
							</p>
						</div>
						<?php 
							$c_form->input_password(
								false, 
								'passwort', 
								'', 
								'Neues Passwort hier eingeben', 
								true
							);
							$c_html->sticky_footer(
								array(
									'btn_passwort_submit',
									'Passwort aktualisieren'
								)
							); 
						?>
					</form>
				</div>
			</div>
		</div>
	</div>



   
<?php 
	$c_html->get_footer(); 
?>