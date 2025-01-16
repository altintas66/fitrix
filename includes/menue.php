<?php
	global $c_helper, $c_html, $c_statistik, $c_url;


?>

<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<?php
				global $c_permission, $einstellungen, $aktive_module;

				$array = array(
					array('Allgemein', NULL, NULL),
					array('Dashboard', 'dashboard.png', $c_url->get_base_url()),
				);
	

				if($c_permission->check_user_has_permission('KUNDEN_VERWALTEN')) {
					$array[] = array('Kunden', 'kunden.png', $c_url->get_kunde_uebersicht());
				}

				if($c_permission->check_user_has_permission('ARTIKEL_VERWALTEN')) {
					$array[] = array('Artikel', 'artikel.png', $c_url->get_artikel_uebersicht());
				}

				if($c_permission->check_user_has_permission('RECHNUNGEN_VERWALTEN')) {
					$array[] = array('Rechnungen', 'rechnung.png', $c_url->get_rechnung_uebersicht());
				}
		
				if(isset($this->aktive_module['angebot'])) {
					if($c_permission->check_user_has_permission('ANGEBOTE_VERWALTEN')) {
						$array[] = array('Angebote', 'angebot.png', $c_url->get_angebot_uebersicht());
					}
				}

				
				if(isset($this->aktive_module['abonnement'])) {
					if($c_permission->check_user_has_permission('ABONNEMENT_VERWALTEN')) {
						$array[] = array('Abonnements', 'abonnement.png', $c_url->get_abonnement_uebersicht());
					}
				}

				if(isset($this->aktive_module['zammad'])) {
					if($einstellungen['zammad_api_tickets'] == '1') {
						if($c_permission->check_user_has_permission('ZAMMAD_API')) {
							$zammad = array();
							$zammad[] = array('Tickets', $c_url->get_zammad_ticket_uebersicht());
							$zammad[] = array('Organisationen', $c_url->get_zammad_organisation_uebersicht());
							$zammad[] = array('Kunden', $c_url->get_zammad_kunden_uebersicht());
							$zammad[] = array('Benutzer', $c_url->get_zammad_benutzer_uebersicht());
							$array[] = array('Zammad', 'zammad_logo.png', '#', $zammad);
						}
					}
				}
				

				$array[] = array('Weiteres', NULL, NULL);

				if(isset($this->aktive_module['mahnung'])) {
					if($c_permission->check_user_has_permission('MAHNUNGEN_VERWALTEN')) {
						$array[] = array('Mahnungen', 'mahnung.png', $c_url->get_mahnung_uebersicht());
					}
				}

				if($c_permission->check_user_has_permission('BERICHTE_ANSEHEN')) {
					$array[] = array('Berichte', 'berichte.png', $c_url->get_berichte_uebersicht());
				}

				if($c_permission->check_user_has_permission('STATISTIK_ANSEHEN')) {
					$array[] = array('Statistik', 'statistik.png', $c_url->get_statistik_uebersicht());
				}

				if($c_permission->check_user_has_permission('USER_VERWALTEN')) {
					$array[] = array('User', 'users.png', $c_url->get_user_uebersicht());
				}

				if($c_permission->check_user_has_permission('RECHTE_VERWALTEN')) {
					$array[] = array('Rechte', 'rechte.png', $c_url->get_permission_uebersicht());
				}

				if($c_permission->check_user_has_permission('INHALTE_VERWALTEN')) {
					
					$inhalte = array();
					$inhalte[] = array('E-Mail Inhalte', $c_url->get_email_inhalt_uebersicht());
					$inhalte[] = array('Einheiten', $c_url->get_einheit_uebersicht());
					$inhalte[] = array('Orte', $c_url->get_ort_uebersicht());
					$inhalte[] = array('Kategorien', $c_url->get_kategorie_uebersicht());
					$inhalte[] = array('MwSt', $c_url->get_mwst_uebersicht());
					
					if($einstellungen['rechnung_datum_nach_leistungsdatum'] == '0') {
						$inhalte[] = array('Zyklen', $c_url->get_zyklus_uebersicht());
					}
					
					$inhalte[] = array('Artikel Typen', $c_url->get_artikel_typ_uebersicht());
					$inhalte[] = array('Zahlungsarten', $c_url->get_zahlungsart_uebersicht());
					
					if(isset($this->aktive_module['hosting_server'])) {
						if($c_permission->check_user_has_permission('SERVER_VERWALTEN')) {
							$inhalte[] = array('Hostings', $c_url->get_hosting_uebersicht());
							$inhalte[] = array('Server', $c_url->get_server_uebersicht());
						}
					}

					$array[] = array('Inhalte', 'inhalte.png', '#', $inhalte);
				}

				if($c_permission->check_user_has_permission('EINSTELLUNGEN_VERWALTEN')) {
					
					$einstellungen = array();
					$einstellungen[] = array('Allgemein', $c_url->get_einstellungen());
					$einstellungen[] = array('E-Mail Logs', $c_url->get_email_log_uebersicht());
					$einstellungen[] = array('Cache', $c_url->get_cache_uebersicht());
					$einstellungen[] = array('Cronjobs', $c_url->get_cronjob_uebersicht());
					$einstellungen[] = array('Module', $c_url->get_modul_uebersicht());
					$einstellungen[] = array('Backups', $c_url->get_backup_uebersicht());
					
					$array[] = array('Einstellungen', 'settings.png', '#', $einstellungen);
				}
				

				echo $c_html->get_navigation($array);
			?>
		</div>
	</div>
</div>