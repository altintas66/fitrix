<?php
	session_start();
	ob_start();
	include "init.php";
	
	global $config;
	global $version;
	
	if(isset($_POST['submit'])) {
		$mitarbeiter = $c_mitarbeiter->get_by_username($_POST['username']);
		if($mitarbeiter != NULL) {
			$try = $c_mitarbeiter->passwort_zusenden($mitarbeiter);
		} else {
			$try = false;
		}
    }
	
	
?>

<!DOCTYPE html>
<html lang="de">
    <?php $c_html->get_head(); ?>
    <body class="login-bg" style="background-image: url('<?php echo $config['login_bg']; ?>'); ">
        <div class="main-wrapper login-body">
			<div class="login-wrapper">
            	<div class="container">
					<?php 
						if((isset($try)) && ($try == false) && ($mitarbeiter == NULL)) $c_helper->__message(
							'Es tut uns leid, zu Ihrem Usernamen "'.$_POST['username'].'" konnten wir keinen Mitarbeiter Account finden.',
							'danger'
						);
						if((isset($try)) && ($try == true) && ($mitarbeiter != NULL)) $c_helper->__message(
							'Es wurde Ihnen ein neues Passwort zugesendet.'
						);
					?>
                	<div class="loginbox">
                    	<div class="login-left">
							<img class="img-fluid" src="<?php echo $config['logo_weiss']; ?>" alt="Logo">
                        </div>
                        <div class="login-right">
							<div class="login-right-wrap">
								
								<div class="logo">
									<img width="200" class="img-fluid" src="<?php echo $config['logo']; ?>" alt="Logo">
								</div>
								<h1>Passwort vergessen</h1>
								<h3><?php echo $config['stytem_label']; ?></h3>
								<p class="account-subtitle mt-4">
									Bitte geben Sie Ihren Usernamen ein. Falls wir in der Datenbank zu Ihren 
									Usernamen einen gültigen Mitarbeiter Account finden, wird Ihnen das neu generierte
									Passwort auf die jeweilige E-Mail Adresse oder per WhatsApp zugesendet.
								</p>
								<?php if((isset($mitarbeiter)) && ($mitarbeiter == NULL)) $c_helper->__message('E-Mail existiert nicht!', 'danger'); ?>
								<form method="POST" action="">
									<?php 
										$c_form->input_text(
											false, 
											'username', 
											'', 
											'Username (Hilfe: vorname.nachname)', 
											true
										); 
										$c_form->button_submit(
											'submit', 
											'Passwort zusenden', 
											'btn-primary btn-block'
										);
									?>
								</form>
								<div class="text-center forgotpass">
									<a href="login.php">Zum Login</a>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $c_html->get_javascript(); ?>
    </body>
</html>