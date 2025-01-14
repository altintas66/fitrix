<?php

	
	include "init.php";

	global $config;
	global $version;
	
	if(isset($_POST['submit_login'])) {
		$try = $c_login->login($_POST['username'], $_POST['passwort']);
		if($try['result'] == true) header('location: '.$c_url->get_base_url());
    } 
	

	if(isset($_POST['username'])) $username = $_POST['username']; else $username = '';
	$passwort = '';

	if(isset($_GET['username'])) $username = $_GET['username'];
	if(isset($_GET['passwort'])) $passwort = $_GET['passwort'];
	
	
?>

<!DOCTYPE html>
<html lang="de">
    <?php $c_html->get_head(); ?>
    <body class="login-bg" style="background-image: url('<?php echo $config['login_bg']; ?>'); ">
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                    	<div class="login-left">
							<img class="img-fluid" src="<?php echo $config['login_logo']; ?>" alt="Logo">
                        </div>
                        <div class="login-right">
							<div class="login-right-wrap">
								<div class="logo">
									<img width="200" class="img-fluid" src="<?php echo $config['login_logo']; ?>" alt="Logo">
								</div>
								<h1>Login</h1>
								<h3><?php echo $config['stytem_label']; ?></h3>
								<p class="account-subtitle">
									Dashboard Version <?php echo $version['nummer']; ?>
								</p>
								<?php 
									if((isset($try)) && ($try['result'] == false)) {
										$c_helper->__message($try['message'], 'danger'); 
									}
								?>
								<form method="POST" action="">
									<?php 
										$c_form->input_text(
											false, 
											'username', 
											$username, 
											'Username', true
										); 
										$c_form->input_password(
											false, 
											'passwort', 
											$passwort, 
											'Passwort', true
										);
										$c_form->button_submit(
											'submit_login', 
											'Einloggen', 
											'btn-primary btn-block'
										);
									?>
								</form>
								<div class="text-center forgotpass">
									<?php 
										$c_form->link(
											$c_url->get_passwort_vergessen(), 
											'Passwort vergessen?'
										);
									?>
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