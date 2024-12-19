<?php

	global $einstellungen, $c_html, $c_helper, $c_einstellungen, $version, $config, $c_user, $c_url, $c_erinnerung;
	$user         = $c_user->get($_SESSION['id']);
	$erinnerungen = $c_erinnerung->get_all();
	
	$logo       = $config['logo'];
	$logo_klein = $config['logo_klein'];

?>

<!DOCTYPE html>
<html lang="de">
	<?php $c_html->get_head(); ?>
    <body class="<?php if($user['menue_toggle'] == '1') echo 'mini-sidebar'; ?>">
		
		<div class="site-overlay">
			<i class="fa fa-refresh fa-spin fa-3x fa-fw margin-bottom"></i>
		</div>
	erinnerungen
        <div class="main-wrapper">
		
            <div class="header">
			
                <div class="header-left">
                    <a href="index.php" class="logo">
						<img src="<?php echo $logo; ?>" alt="Logo">
					</a>
					<a href="index.php" class="logo logo-small">
						<img src="<?php echo $logo_klein; ?>" alt="Logo" width="30" height="30">
					</a>
                </div>
				
				<a id="toggle_btn">
					<i class="fe fe-text-align-left"></i>
				</a>
				
				<a class="mobile_btn" id="mobile_btn">
					<i class="fa fa-bars"></i>
				</a>
				
				<ul class="nav user-menu">
				
					<?php 
						if($erinnerungen != null) $c_html->get_erinnerungen($erinnerungen);
					?>

					<li class="nav-item dropdown has-arrow">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<i class="fe fe-user"></i>
						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								
								<div class="user-text">
									<h6><?php echo $_SESSION['vorname']; ?> <?php echo $_SESSION['nachname']; ?></h6>
									<p class="text-muted mb-0">Administrator</p>
								</div>
							</div>
							<a class="dropdown-item" href="profil.php?id=<?php echo $_SESSION['id']; ?>">Profil</a>
							<a class="dropdown-item" href="einstellungen.php">Einstellungen</a>
							<a class="dropdown-item" href="version.php">Version & Updates</a>
							<a class="dropdown-item" href="logout.php">Abmelden</a>
						</div>
					</li>
					
					
					
				</ul>
				
            </div>
			
			<?php $c_html->get_menue(); ?>
			
            <div class="page-wrapper">
                <div class="content container-fluid">
			
			
					<?php if(isset($_GET['message'])) $c_helper->__message($_GET['message'], $_GET['type']); ?>

		