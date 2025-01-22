<?php
require_once dirname(__FILE__).'/../init.php';
date_default_timezone_set('Europe/Berlin');
date_default_timezone_set('Etc/GMT-2');


class AJAX 
{
	
	private $action;
	
	private $helper;
	private $einstellungen;
	private $file_upload;
	private $user;
	private $html;
	private $beitrag;
	private $kommentar;
	private $cache;
	private $permission;
	private $angebot;
	private $angebot_position;
	private $rechnung;
	private $rechnung_position;
	private $rechnung_zahlung;
	private $abonnement;
	private $abonnement_vertrag;
	private $email;
	private $email_log;
	private $table_helper;
	private $ansprechpartner;
	private $zahlungsart;
	private $artikel;
	private $artikel_preis;
	private $mahnung;
	private $kunde;
	private $rechnung_qualityhosting;
	private $backup;
	private $plz_ort_suche;
	

	public function __construct() 
	{
		global 
			$c_helper,
			$c_einstellungen,
			$c_user,
			$c_html,
			$c_beitrag,
			$c_kommentar,
			$c_cache, 
			$c_permission,
			$c_angebot,
			$c_angebot_position,
			$c_rechnung,
			$c_rechnung_position,
			$c_rechnung_zahlung,
			$c_abonnement,
			$c_abonnement_vertrag,
			$c_email,
			$c_email_log,
			$c_table_helper,
			$c_ansprechpartner,
			$c_zahlungsart,
			$c_artikel,
			$c_artikel_preis,
			$c_mahnung,
			$c_kunde,
			$c_rechnung_qualityhosting,
			$c_backup,
			$c_plz_ort_suche;
			
		$this->helper                           = $c_helper;
		$this->einstellungen                    = $c_einstellungen;
		$this->user                             = $c_user;
		$this->html                             = $c_html;
		$this->beitrag                          = $c_beitrag;
		$this->kommentar                        = $c_kommentar;
		$this->cache                            = $c_cache;
		$this->permission                       = $c_permission;
		$this->angebot                          = $c_angebot;
		$this->angebot_position                 = $c_angebot_position;
		$this->rechnung                			= $c_rechnung;
		$this->rechnung_position                = $c_rechnung_position;
		$this->rechnung_zahlung                 = $c_rechnung_zahlung;
		$this->abonnement                       = $c_abonnement;
		$this->abonnement_vertrag               = $c_abonnement_vertrag;
		$this->email                            = $c_email;
		$this->email_log                        = $c_email_log;
		$this->table_helper                     = $c_table_helper;
		$this->ansprechpartner                  = $c_ansprechpartner;
		$this->zahlungsart                      = $c_zahlungsart;
		$this->artikel                          = $c_artikel;
		$this->artikel_preis                    = $c_artikel_preis;
		$this->mahnung                          = $c_mahnung;
		$this->kunde                            = $c_kunde;
		$this->rechnung_qualityhosting          = $c_rechnung_qualityhosting;
		$this->backup			   		        = $c_backup;
		$this->plz_ort_suche                    = $c_plz_ort_suche;

		$this->action = '';
		if(isset($_POST['action'])) $this->action = $_POST['action'];
	}
	
	public function action() 
	{ 
		if($this->action == 'delete_entry')                                          $this->delete_entry();
		else if($this->action == 'update_status')                                    $this->update_status();
		else if($this->action == 'menue_toggle')                                     $this->menue_toggle();
		else if($this->action == 'get_username')                                     $this->get_username();
		else if($this->action == 'insert_beitrag')                                   $this->insert_beitrag();
		else if($this->action == 'get_beitrage')                                     $this->get_beitrage();
		else if($this->action == 'get_beitrag')                                      $this->get_beitrag();
		else if($this->action == 'update_beitrag')                                   $this->update_beitrag();
		else if($this->action == 'delete_beitrag')                                   $this->delete_beitrag();
		else if($this->action == 'insert_kommentar')                                 $this->insert_kommentar();
		else if($this->action == 'delete_kommentar')                                 $this->delete_kommentar();
		else if($this->action == 'get_kommentar')                                    $this->get_kommentar();
		else if($this->action == 'update_kommentar')                                 $this->update_kommentar();
		else if($this->action == 'update_permission')                                $this->update_permission();
		else if($this->action == 'get_angebotsnummer')                               $this->get_angebotsnummer();
		else if($this->action == 'insert_angebot')                                   $this->insert_angebot();
		else if($this->action == 'insert_angebot_position')                          $this->insert_angebot_position();
		else if($this->action == 'insert_angebot_individuelle_position')             $this->insert_angebot_individuelle_position();
		else if($this->action == 'get_angebot_position')                             $this->get_angebot_position();
		else if($this->action == 'update_angebot_position')                          $this->update_angebot_position();
		else if($this->action == 'delete_angebot_position')                          $this->delete_angebot_position();
		else if($this->action == 'insert_abonnement')                                $this->insert_abonnement();
		else if($this->action == 'angebot_kunde_senden')                             $this->angebot_kunde_senden();
		else if($this->action == 'rechnung_kunde_senden')                            $this->rechnung_kunde_senden();
		else if($this->action == 'get_email_logs')                                   $this->get_email_logs();
		else if($this->action == 'insert_abonnement_vertrag_artikel')                $this->insert_abonnement_vertrag_artikel();
		else if($this->action == 'insert_abonnement_vertrag_individuelle_position')  $this->insert_abonnement_vertrag_individuelle_position();
		else if($this->action == 'get_rechnungsnummer')  							 $this->get_rechnungsnummer();
		else if($this->action == 'insert_rechnung')  							  	 $this->insert_rechnung();
		else if($this->action == 'insert_rechnung_artikel_position')  				 $this->insert_rechnung_artikel_position();
		else if($this->action == 'insert_rechnung_individuelle_position')  			 $this->insert_rechnung_individuelle_position();
		else if($this->action == 'delete_rechnung_position')  			             $this->delete_rechnung_position();
		else if($this->action == 'get_rechnung_position')  			                 $this->get_rechnung_position();
		else if($this->action == 'update_rechnung_position')  			             $this->update_rechnung_position();
		else if($this->action == 'insert_ansprechpartner')  			             $this->insert_ansprechpartner();
		else if($this->action == 'get_ansprechpartner')  			                 $this->get_ansprechpartner();
		else if($this->action == 'update_ansprechpartner')  			             $this->update_ansprechpartner();
		else if($this->action == 'rechnung_korrektur')  			                 $this->rechnung_korrektur();
		else if($this->action == 'rechnung_festschreiben')  			             $this->rechnung_festschreiben();
		else if($this->action == 'rechnung_stornieren')  			                 $this->rechnung_stornieren();
		else if($this->action == 'rechnung_zahlung_hinzufuegen')  			         $this->rechnung_zahlung_hinzufuegen();
		else if($this->action == 'rechnung_zahlung_loeschen')  			             $this->rechnung_zahlung_loeschen();
		else if($this->action == 'abonnement_kunde_senden')  			             $this->abonnement_kunde_senden();
		else if($this->action == 'update_abonnement_vertrag')  			             $this->update_abonnement_vertrag();
		else if($this->action == 'get_abonnement_vertrag')  			             $this->get_abonnement_vertrag();
		else if($this->action == 'delete_abonnement_vertrag')  			             $this->delete_abonnement_vertrag();
		else if($this->action == 'validate_zammad_organisation_id')  			     $this->validate_zammad_organisation_id();
		else if($this->action == 'update_theme_mode')  			                     $this->update_theme_mode();
		else if($this->action == 'sort')  			                     			 $this->sort();
		else if($this->action == 'get_abonnement_vertrag_info')  			         $this->get_abonnement_vertrag_info();
		else if($this->action == 'get_rechnung_zahlungserinnerung')  			     $this->get_rechnung_zahlungserinnerung();
		else if($this->action == 'get_artikel_preise')              			     $this->get_artikel_preise();
		else if($this->action == 'insert_artikel_preis')              			     $this->insert_artikel_preis();
		else if($this->action == 'delete_artikel_preis')              			     $this->delete_artikel_preis();
		else if($this->action == 'get_artikel_zyklen')              			     $this->get_artikel_zyklen();
		else if($this->action == 'mahnlauf_starten')              			         $this->mahnlauf_starten();
		else if($this->action == 'get_rechnung_gesamt_brutto')              		 $this->get_rechnung_gesamt_brutto();
		else if($this->action == 'rechnung_gedruckt')     		               		 $this->rechnung_gedruckt();
		else if($this->action == 'rechnung_vorschau_pdf_generieren')     		     $this->rechnung_vorschau_pdf_generieren();
		else if($this->action == 'quality_hosting_rechnung_anlegen')     		     $this->quality_hosting_rechnung_anlegen();
		else if($this->action == 'get_rechnungen_fuer_quality_hosting_rechnung')     $this->get_rechnungen_fuer_quality_hosting_rechnung();
		else if($this->action == 'abonnement_rechnungen_erstellen')                  $this->abonnement_rechnungen_erstellen();
		else if($this->action == 'datenback_backup_erstellen')                       $this->datenback_backup_erstellen();
		else if($this->action == 'delete_backup')   			                     $this->delete_backup();
		else if($this->action == 'angebot_update')   			                     $this->angebot_update();
		else if($this->action == 'rechnung_update')   			                     $this->rechnung_update();
		else if($this->action == 'plz_anlegen')   			                         $this->plz_anlegen();
		else if($this->action == 'get_ort_by_plz')   			                     $this->get_ort_by_plz();
		else if($this->action == 'get_kunden')   			                         $this->get_kunden();
		
		
		exit();
	}

	public function validate_required_field($fields)
	{
		$valid = true;
		foreach($fields AS $field) {
			if(isset($_POST[$field])) {
				if($_POST[$field] == '') $valid = false;
			}
		}

		if($valid == false) {
			echo json_encode(array(
				'result'  => false,
				'message' => 'Pflichtfelder' 
			));
			exit();
		}
	}

	public function delete_entry() 
	{	


		$this->helper->delete_entry($_POST['id'], $_POST['table']);

		//Cache leeren
		//$this->cache->update_all();

		echo json_encode(array(
			'result'   => 'true',
			'id'       => $_POST['id'],
			'table'    => $_POST['table']
		));
	}

	public function update_status() 
	{
		
		$this->helper->update_status($_POST['id'], $_POST['table'], $_POST['status']);
	
		if($_POST['table'] == $this->abonnement_vertrag->get_tablename()) {
			$vertrag = $this->abonnement_vertrag->get($_POST['id']);
			if($vertrag != null) {
				$this->abonnement_vertrag->update_feld($_POST['id'], 'bearbeitet_am', $this->helper->get_english_datetime_now());
				$this->abonnement->generiere_pdf($vertrag["fk_abonnement_id"]);
			}
			
		}

		echo json_encode(array('result' => 'true', 'ddd' => $ddd, 'vertrag' => $vertrag));
	}

	
	public function menue_toggle() 
	{
		$result = $this->user->update_menue_toggle($_POST['value']);
		echo json_encode(array('result' => 'true'));
	}
	

	public function get_username() 
	{
		$username = $this->user->get_username($_POST['vorname'], $_POST['nachname']);
		echo json_encode(array(
			'result'   => true,
			'username' => $username
		));
	}

	public function insert_beitrag() {

		$result = $this->beitrag->insert(array(
			'fk_eintrag_id'      => $_POST['typ_id'],
			'typ'                => $_POST['typ'],
			'text'               => $_POST['text']
		));

		$beitraege = $this->beitrag->get_by_eintrag_id($_POST['typ_id'], $_POST['typ']);
		$beitraege_html = $this->html->get_beitraege($beitraege);

		echo json_encode(array(
			'result'          => $result,
			'beitraege_html'  => $beitraege_html
		));


	}

	public function get_beitrage() 
	{

		$beitraege = $this->beitrag->get_by_eintrag_id($_POST['typ_id'], $_POST['typ']);

		if($_POST['disabled'] == 'false') $disabled = false;
		else $disabled = true;
		
		if($beitraege == NULL) {
			echo json_encode(array(
				'result'  => false
			));
		} else {
			$beitraege_html = $this->html->get_beitraege($beitraege, $disabled); 
			echo json_encode(array(
				'beitraege'        => $beitraege,
				'result'           => true,
				'beitraege_html'   => $beitraege_html
			));
		}
	}

	public function get_beitrag() 
	{
		
		$beitrag = $this->beitrag->get($_POST['beitrag_id']);

		session_start();

		if($beitrag['fk_user_id'] != $_SESSION['id']) {
			echo json_encode(array(
				'result'    => false,
				'message'   => 'Es ist Ihnen nicht befugt, diesen Beitrag anzupassen'
			));
			return;
		} else {
			echo json_encode(array(
				'result'    => true,
				'beitrag'   => $beitrag
			));
		}
	}

	public function update_beitrag() {

		$result = $this->beitrag->update(array(
			'beitrag_id' => $_POST['beitrag_id'],
			'text'       => $_POST['text']
		));

		if($result == false) {
			echo json_encode(array(
				'result'    => $result
			));
		} else {
			$beitraege = $this->beitrag->get_by_eintrag_id($_POST['typ_id'], $_POST['typ']);
			$beitraege_html = $this->html->get_beitraege($beitraege);
			echo json_encode(array(
				'result'           => $result,
				'typ'              => $_POST['typ'],
				'beitraege_html'   => $beitraege_html
			));
		}
	}

	public function delete_beitrag() 
	{

		session_start();
		$check = $this->beitrag->check_if_beitrag_assigned_to_user(
			$_POST['beitrag_id'], 
			$_SESSION['id']
		);
		
		if($check == false) {
			echo json_encode(array(
				'result'    => false,
				'message'   => 'Sie sind nicht berechtigt, diesen Beitrag zu löschen'
			));
			return;
		}

		$kommentare = $this->kommentar->get_by_beitrag_id($_POST['beitrag_id']);

		if($kommentare != NULL) {
			echo json_encode(array(
				'result'    => false,
				'message'   => 'Es dürfen keine Beiträge gelöscht werden, die bereits Kommentare besitzen.'
			));
			return;
		}
		

		$result = $this->beitrag->delete(array(
			'beitrag_id' => $_POST['beitrag_id']
		));
		
		$beitraege = $this->beitrag->get_by_eintrag_id($_POST['typ_id'], $_POST['typ']);
		$beitraege_html = $this->html->get_beitraege($beitraege);

		echo json_encode(array(
			'result'         => $result,
			'beitraege_html' => $beitraege_html
		));
	}

	public function insert_kommentar() 
	{

		session_start();
		
		$result = $this->kommentar->insert(
			array(
				'beitrag_id'     => $_POST['beitrag_id'],
				'user_id'        => $_SESSION['id'],
				'text'           => $_POST['text']
			)
		);

		if($result['result'] == false) {
			echo json_encode(array(
				'result'    => $result['result']
			));
			return;
		}

		$beitraege = $this->beitrag->get_by_eintrag_id($_POST['typ_id'], $_POST['typ']);
		$beitraege_html = $this->html->get_beitraege($beitraege);
		
		echo json_encode(array(
			'result'           => $result['result'],
			'beitraege_html'   => $beitraege_html
		));
	}
	

	public function delete_kommentar() 
	{
		session_start();
		$check = $this->kommentar->check_if_kommentar_assigned_to_user(
			$_POST['kommentar_id'], 
			$_SESSION['id']
		);

		if($check == false) {
			echo json_encode(array(
				'result'    => false,
				'message'   => 'Sie sind nicht berechtigt, diesen Kommentar zu löschen'
			));
			return;
		}
		
		$result = $this->kommentar->delete(array(
			'kommentar_id' => $_POST['kommentar_id']
		));
		
		$beitraege = $this->beitrag->get_by_eintrag_id($_POST['typ_id'], $_POST['typ']);
		$beitraege_html = $this->html->get_beitraege($beitraege);
		
		echo json_encode(array(
			'result'           => $result,
			'beitraege_html'   => $beitraege_html
		));
	}

	public function get_kommentar() 
	{
		session_start();
		$kommentar = $this->kommentar->get($_POST['kommentar_id']);

		$check = $this->kommentar->check_if_kommentar_assigned_to_user(
			$_POST['kommentar_id'], 
			$_SESSION['id']
		);

		if($check == false) {
			echo json_encode(array(
				'result'    => false,
				'message'   => 'Es ist Ihnen nicht befugt, diesen Kommentar anzupassen'
			));
			return;
		} else {
			echo json_encode(array(
				'result'      => true,
				'kommentar'   => $kommentar
			));
		}

	}

	public function update_kommentar() 
	{
		$result = $this->kommentar->update(
			array(
				'kommentar_id'  => $_POST['kommentar_id'],
				'text'          => $_POST['text']
			)
		);

		$beitraege = $this->beitrag->get_by_eintrag_id($_POST['typ_id'], $_POST['typ']);
		$beitraege_html = $this->html->get_beitraege($beitraege);

		echo json_encode(array(
			'result'           => $result,
			'beitraege_html'   => $beitraege_html
		));

	}

	public function update_permission()
	{

		$update = $this->permission->set_permission(
			intval($_POST['permission_id']), 
			intval($_POST['rolle_id']), 
			$_POST['checked']
		);

		echo json_encode(
			array(
				'result' => true,
				'reply' => $update
			)
		);

	}

	public function get_angebotsnummer()
	{
		$angebotsnummer = $this->angebot->get_angebotsnummer();

		echo json_encode(
			array(
				'angebotsnummer' => $angebotsnummer
			)
		);

	}

	public function insert_angebot()
	{
		$this->validate_required_field(
			array('kunde_id', 'angebotsdatum', 'faellig_am')
		);

		$result = $this->angebot->insert(array(
			'kunde_id'       => $_POST['kunde_id'],
			'angebotsdatum'  => $_POST['angebotsdatum'],
			'faellig_am'     => $_POST['faellig_am']
		));


		echo json_encode($result);
		
	}

	public function insert_angebot_position()
	{

		$this->validate_required_field(
			array('angebot_id', 'artikel_id', 'menge', 'zyklus_id')
		);

		$result = $this->angebot_position->insert_position($_POST);

		echo json_encode($result);
	}


	public function insert_angebot_individuelle_position()
	{

		$this->validate_required_field(
			array('angebot_id', 'artikel_name', 'einheit_id', 'menge', 'artikel_typ_id', 'zyklus_id', 'einrichtungsgebuehr', 'netto_preis', 'beschreibung')
		);

		$result = $this->angebot_position->insert_individuelle_position($_POST);

		echo json_encode($result);
	}

	public function get_angebot_position()
	{
		$this->validate_required_field(
			array('angebot_position_id')
		);

		$position = $this->angebot_position->get($_POST['angebot_position_id']);

		echo json_encode(array(
			'result' => $position
		));
	}

	

	public function update_angebot_position() 
	{
		$this->validate_required_field(
			array(
				'angebot_id', 
				'angebot_position_id', 
				'artikel_name', 
				'menge', 
				'netto_preis', 
				'artikel_typ_id', 
			)
		);

		$result = $this->angebot_position->update($_POST);

		echo json_encode(array(
			'result' => $position
		));


	}

	public function delete_angebot_position()
	{
		$this->validate_required_field(
			array('angebot_id', 'angebot_position_id')
		);

		$result = $this->angebot_position->delete(
			$_POST['angebot_id'],
			$_POST['angebot_position_id']
		);

		echo json_encode(array(
			'result' => $result
		));
	} 

	public function insert_abonnement()
	{
		$this->validate_required_field(
			array('kunde_id')
		);
 
		$result = $this->abonnement->insert($_POST);

		echo json_encode(array(
			'result' => $result
		));
	}

	public function angebot_kunde_senden()
	{
		$this->validate_required_field(
			array('angebot_id')
		);	

		$result = $this->email->angebot_senden($_POST['angebot_id']);
		echo json_encode($result);
	}

	public function rechnung_kunde_senden()
	{
		$this->validate_required_field(
			array('rechnung_id')
		);	

		$result = $this->email->rechnung_senden($_POST['rechnung_id']);
		echo json_encode($result);
	}

	public function get_email_logs()
	{
		$this->validate_required_field(
			array('eintrag_typ', 'id')
		);	

		$message = '';
		$html    = '';

		$eintraege = $this->email_log->get_all(
			$_POST['eintrag_typ'], 
			$_POST['id']
		);

		if($eintraege == null) $message = 'Keine Mails versendet';

		if($eintraege != null) $html = $this->table_helper->get_table_email_log($eintraege);

		echo json_encode(array(
			'eintraege' => $eintraege,
			'html'      => $html,
			'message'   => $message
		));
	}

	public function insert_abonnement_vertrag_artikel()
	{
		$this->validate_required_field(
			array(
				'abonnement_id', 
				'artikel_id', 
				'artikel_menge', 
				'zahlungsart_id', 
				'start', 
				'ende', 
				'zyklus_id'
			)
		);	

		$result = $this->abonnement_vertrag->insert_vertrag_produkt($_POST);

		echo json_encode($result);
	}

	public function insert_abonnement_vertrag_individuelle_position()
	{
		$this->validate_required_field(
			array(
				'abonnement_id', 
				'artikel_name', 
				'artikel_menge', 
				'artikel_preis', 
				'zahlungsart_id', 
				'einheit_id',
				'artikel_typ_id',
				'zyklus_id',
				'start',
				'ende',
				'artikel_beschreibung'
			)
		);		

		$result = $this->abonnement_vertrag->insert_vertrag_individuelle_position($_POST);

		echo json_encode($result);
	}

	public function get_rechnungsnummer()
	{
		$rechnungsnummer = $this->rechnung->get_rechnungsnummer();

		echo json_encode(
			array(
				'rechnungsnummer' => $rechnungsnummer
			)
		);

	}
	
	public function insert_rechnung()
	{
		$this->validate_required_field(
			array('kunde_id', 'rechnungsdatum', 'faellig_am')
		);

		$result = $this->rechnung->insert($_POST);


		echo json_encode($result);
		
	}

	public function insert_rechnung_artikel_position()
	{
		$this->validate_required_field(
			array('rechnung_id', 'artikel_id', 'menge', 'zyklus_id', 'leistungsdatum')
		);

		$result = $this->rechnung_position->insert_artikel_position($_POST);

		echo json_encode($result);

	}

	public function insert_rechnung_individuelle_position()
	{
		$this->validate_required_field(array(
			'rechnung_id', 
			'artikel_name',
			'artikel_preis',
			'artikel_menge',
			'einheit_id',
			'artikel_typ_id',
		));

		$result = $this->rechnung_position->insert_individuelle_position($_POST);


		echo json_encode($result);


	}


	public function delete_rechnung_position()
	{
		$this->validate_required_field(
			array('rechnung_id', 'rechnung_position_id')
		);

		$result = $this->rechnung_position->delete(
			$_POST['rechnung_id'],
			$_POST['rechnung_position_id']
		);

		echo json_encode(array(
			'result' => $result
		));
	}

	public function get_rechnung_position()
	{
		$this->validate_required_field(
			array('rechnung_position_id')
		);

		$position = $this->rechnung_position->get($_POST['rechnung_position_id']);
		$position['teppichreinigung_laenge'] = $this->helper->format_input_decimal($position['teppichreinigung_laenge']);
		$position['teppichreinigung_breite'] = $this->helper->format_input_decimal($position['teppichreinigung_breite']);

		echo json_encode(array(
			'result' => $position
		));
	}

	public function update_rechnung_position() 
	{
		$this->validate_required_field(array(
			'rechnung_id', 
			'rechnung_position_id', 
			'artikel_name', 
			'artikel_menge', 
			'artikel_preis', 
			'artikel_artikel_typ', 
			'artikel_einheit', 
			'artikel_zyklus'
		));

		$result = $this->rechnung_position->update($_POST);

		echo json_encode(array(
			'result' => $result
		));


	}

	public function insert_ansprechpartner()
	{
		$this->validate_required_field(array(
			'kunde_id', 
			'anrede', 
			'vorname', 
			'nachname', 
			'email',
			'mobilnummer', 
			'whatsapp',
			'bemerkung'
		));

		$result = $this->ansprechpartner->insert($_POST);

		echo json_encode(array(
			'result' => $result
		));

	}

	public function get_ansprechpartner()
	{
		$this->validate_required_field(array('id'));

		$ansprechpartner = $this->ansprechpartner->get($_POST['id']);

		echo json_encode(array(
			'result' => $ansprechpartner
		));

	}

	public function update_ansprechpartner()
	{
		$this->validate_required_field(array(
			'id',
			'anrede', 
			'vorname', 
			'nachname', 
			'email',
			'mobilnummer', 
			'bemerkung', 
			'whatsapp'
		));

		$result = $this->ansprechpartner->update(array(
			'ansprechpartner_id'  => $_POST['id'],
			'anrede'              => $_POST['anrede'],
			'vorname'             => $_POST['vorname'],
			'nachname'            => $_POST['nachname'],
			'email'               => $_POST['email'],
			'mobilnummer'         => $_POST['mobilnummer'],
			'whatsapp'            => $_POST['whatsapp'],
			'bemerkung'           => $_POST['bemerkung']
		));

		echo json_encode(array(
			'result' => $result
		));

	}

	public function rechnung_korrektur()
	{
		$this->validate_required_field(array(
			'rechnung_id'
		));

		$result = $this->rechnung->update_status($_POST['rechnung_id'], 'entwurf', true);

		echo json_encode(array(
			'result' => $result
		));

	}

	public function rechnung_festschreiben()
	{
		$this->validate_required_field(array(
			'rechnung_id'
		));
		$rechnung_k = $this->rechnung->get($_POST['rechnung_id']);
		
		$korrektur = false;
		if(!str_ends_with($rechnung_k['rechnungsnummer'], 'XXXX')) $korrektur = true;

		$result = $this->rechnung->update_status($_POST['rechnung_id'], 'offen', $korrektur);

		echo json_encode(array(
			'result' => $result
		));

	}

	public function rechnung_stornieren()
	{
		$this->validate_required_field(array(
			'rechnung_id'
		));

		$result = $this->rechnung->update_status($_POST['rechnung_id'], 'storniert');

		echo json_encode(array(
			'result' => $result
		));

	}

	function rechnung_zahlung_hinzufuegen()
	{

		$this->validate_required_field(array(
			'rechnung_id',
			'zahlungsart_id',
			'zahlungsbetrag',
			'zahlungsdatum'
		));

		$zahlungsart = $this->zahlungsart->get($_POST['zahlungsart_id']);

		$result = $this->rechnung_zahlung->insert(array(
			'rechnung_id'    => $_POST['rechnung_id'],
			'zahlungsart'    => $zahlungsart['bezeichnung'],
			'zahlungsbetrag' => $_POST['zahlungsbetrag'],
			'zahlungsdatum'  => $_POST['zahlungsdatum']
		));

		echo json_encode(array(
			'result' => $result
		));

	}

	public function rechnung_zahlung_loeschen()
	{
		$this->validate_required_field(array(
			'rechnung_id',
			'rechnung_zahlung_id'
		));

		$result = $this->rechnung_zahlung->delete(
			$_POST['rechnung_id'],
			$_POST['rechnung_zahlung_id']
		);

		echo json_encode(array(
			'result' => $result
		));

	}
	
	public function abonnement_kunde_senden()
	{
		$this->validate_required_field(
			array('abonnement_id')
		);	

		$result = $this->email->abonnement_senden($_POST['abonnement_id']);
		echo json_encode($result);
	}

	public function update_abonnement_vertrag() 
	{
		$this->validate_required_field(
			array(	
					'abonnement_id',
					'abonnement_vertrag_id', 
					'artikel_name', 
					'artikel_beschreibung', 
					'artikel_menge', 
					'einheit_id', 
					'artikel_typ_id', 
					'artikel_preis', 
					'zyklus_id', 
					'start',
					'ende',
					'zahlungsart_id'
				)
		);

		$response = $this->abonnement_vertrag->update($_POST);

		echo json_encode(array(
			'result' => $response['result']
		));
	}
	
	public function get_abonnement_vertrag()
	{
		$this->validate_required_field(
			array('abonnement_vertrag_id')
		);

		$result = $this->abonnement_vertrag->get($_POST['abonnement_vertrag_id']);
		$result['start'] = $this->helper->german_date_no_time($result['start'], false);

		echo json_encode(array(
			'result' => $result
		));
	}

	public function delete_abonnement_vertrag()
	{
		$this->validate_required_field(
			array('abonnement_id', 'abonnement_vertrag_id')
		);

		$vertrag = $this->abonnement_vertrag->get($_POST['abonnement_vertrag_id']);
		
		if($vertrag['naechste_faelligkeit'] != null) {
			echo json_encode(array(
				'result'  => false,
				'message' => 'Vertrag kann nicht gelöscht werden, da dies bereits verrechnet wurde. Bitte deaktiviere den Vertrag!' 
			));
		}

		$this->abonnement_vertrag->delete($_POST['abonnement_id'], $_POST['abonnement_vertrag_id']);
		echo json_encode(array(
			'result'  => true
		));

	}

	public function validate_zammad_organisation_id()
	{
		$this->validate_required_field(
			array('organisation_id')
		);

		$valid = false;

		$orgnisationen = $this->cache->get_zammad_organisationen();

		foreach($orgnisationen AS $id => $organisation) {
			if($id == $_POST['organisation_id']) $valid = true;
		}

		echo json_encode(array(
			'valid'  => $valid
		));



	}
	
	public function update_theme_mode()
	{
		$this->validate_required_field(
			array('theme_mode')
		);

		session_start();

		$result = $this->user->update_theme_mode($_SESSION['id'], $_POST['theme_mode']);

		echo json_encode(array(
			'result'  => $result
		));

	}
 
	public function sort() 
	{
		$result = $this->helper->update_sort($_POST['rows'], $_POST['table']);
		
		echo json_encode(array(
			'result' => 'true',
			'sql'	 => $result
		));
	} 

	public function get_abonnement_vertrag_info()
	{
		$this->validate_required_field(
			array('abonnement_vertrag_id')
		);

		$result = $this->abonnement_vertrag->get($_POST['abonnement_vertrag_id']);
		$html   = $this->table_helper->get_abonnement_vertrag_info($result);
		
		echo json_encode(array(
			'result' => $result,
			'html'   => $html
		));

	}

	public function get_rechnung_zahlungserinnerung()
	{
		$this->validate_required_field(
			array('rechnung_id')
		);

		$rechnung      = $this->rechnung->get($_POST['rechnung_id']);
		$gesendet_am   = $rechnung['rechnung_zahlungserinnerung_gesendet_am'];
		$eintraege     = $this->email_log->get_all('rechnung_zahlungserinnerung', $_POST['rechnung_id']);
		if($eintraege != null) $html = $this->table_helper->get_table_email_log($eintraege);

		echo json_encode(array(
			'result' => $gesendet_am,
			'html'   => $html
		));

	}

	public function get_artikel_preise()
	{
		$this->validate_required_field(
			array('artikel_id')
		);

		$preise = $this->artikel_preis->get_all($_POST['artikel_id']);
		$html   = $this->table_helper->get_artikel_preise($preise);

		echo json_encode(array(
			'result' => $preise,
			'html'   => $html
		));

	}

	public function insert_artikel_preis()
	{
		$this->validate_required_field(
			array('artikel_id', 'zyklus_id', 'artikel_preis')
		);

		$this->validate_required_field(
			array('artikel_id', 'zyklus_id', 'artikel_preis')
		);

		//Überprüfen, ob es zu diesem Eintrag bereits etwas in der Datenbank existiert
		$entry = $this->artikel_preis->get($_POST['artikel_id'], $_POST['zyklus_id']);
		if($entry != null) {
			echo json_encode(array(
				'result'   => false,
				'message'   => 'Ein Preis zu diesem Zyklus wurde bereits angelegt'
			));
			return;
		}

		//Überprüfen, ob der Standard Zyklus bereits der Zyklus ist 
		$artikel = $this->artikel->get($_POST['artikel_id']);
		if($artikel['fk_zyklus_id'] == $_POST['zyklus_id']) {
			echo json_encode(array(
				'result'   => false,
				'message'   => 'Der Standartzyklus ist bereits '.$artikel['zyklus'].'! Anlegen nicht möglich.'
			));
			return;
		}

		$result = $this->artikel_preis->insert(array(
			'artikel_id' => $_POST['artikel_id'],
			'zyklus_id'  => $_POST['zyklus_id'],
			'preis'      => $_POST['artikel_preis']
		));

		$preise = $this->artikel_preis->get_all($_POST['artikel_id']);
		$html   = $this->table_helper->get_artikel_preise($preise);

		echo json_encode(array(
			'result' => $result,
			'html'   => $html
		));
	}

	public function delete_artikel_preis()
	{
		$this->validate_required_field(
			array('artikel_preis_id', 'artikel_id')
		);

		$result = $this->artikel_preis->delete($_POST['artikel_preis_id']);

		$preise = $this->artikel_preis->get_all($_POST['artikel_id']);
		$html   = $this->table_helper->get_artikel_preise($preise);

		echo json_encode(array(
			'result' => $result,
			'html'   => $html
		));
	}

	public function get_artikel_zyklen()
	{
		$this->validate_required_field(
			array('artikel_id')
		);

		$optionen      = $this->artikel->get_artikel_zyklen($_POST['artikel_id']);
		$select_values = $this->helper->get_select_values($optionen);
		
		echo json_encode(array(
			'select_values' => $select_values
		));

	}
	
	
	public function mahnlauf_starten()
	{
		$this->validate_required_field(
			array('mahnungen')
		);

		foreach($_POST['mahnungen'] AS $rechnung_id){
			
			$rechnung          = $this->rechnung->get($rechnung_id);
			$result            = $this->mahnung->insert($rechnung_id, $rechnung['gesamt_brutto']);
			$dateiname_mahnung = $this->mahnung->generiere_pdf($result['id']);
			
		}

		
		
		echo json_encode(array(
			'result' => $result
		));

	}
	
	public function get_rechnung_gesamt_brutto()
	{
		$this->validate_required_field(array(
			'rechnung_id'
		));
		$rechnung = $this->rechnung->get($_POST['rechnung_id']);

		echo json_encode(
			array(
				'gesamt_brutto' => strval($rechnung['offene_zahlung'])
			)
		);

	}

	public function rechnung_gedruckt()
	{
		$this->validate_required_field(array(
			'rechnung_id'
		));

		$result = $this->rechnung->update_ausgedruckt($_POST['rechnung_id']);

		echo json_encode(array(
			'result' => $result
		));

	}

	public function rechnung_vorschau_pdf_generieren()
	{
		$this->validate_required_field(array(
			'rechnung_id'
		));

		$result = $this->rechnung->generiere_pdf($_POST['rechnung_id']);
		
		echo json_encode(array(
			'result' => $result
		));
	}

	public function get_rechnungen_fuer_quality_hosting_rechnung()
	{
		$this->validate_required_field(array(
			'reseller_customer_id'
		));

		global $c_kunde;

		$kunde_id   = $c_kunde->get_id_by_reseller_customer_id($_POST['reseller_customer_id']);
		$rechnungen = $this->rechnung->get_rechnungen_by_kunde_id($kunde_id);
		$html       = '';


		if($rechnungen == null) $vorhanden = false;
		else $vorhanden = true;

		if($vorhanden == true) $html = $this->table_helper->get_table_quality_hosting_rechnungen($rechnungen, $_POST['reseller_customer_id']);

		echo json_encode(array(
			'html'      => $html,
			'vorhanden' => $vorhanden
		));
		
	}

	public function quality_hosting_rechnung_anlegen()
	{
		$this->validate_required_field(array(
			'reseller_customer_id',
			'positionen',
			'csv_dateiname',
			'rechnung_id'
		));

		global $c_kunde, $c_rechnung_qualityhosting;

		$kunde_id = $c_kunde->get_id_by_reseller_customer_id($_POST['reseller_customer_id']);
		$rechnung_id = $_POST['rechnung_id'];

		if($rechnung_id == 0) {
			$rechnung['kunde_id'] = $kunde_id;
			$result = $this->rechnung->insert($rechnung);
			$rechnung_id = $result['id'];
		}

		$qh_rechnung = array(
			'rechnung_id'   => $rechnung_id,
			'csv_dateiname' => $_POST['csv_dateiname']
		);
		$c_rechnung_qualityhosting->insert($qh_rechnung);

		foreach($_POST['positionen'] AS $position) {
			$position['zyklus_id']   		  = 1;
			$position['einheit_id']  		  = 1;
			$position['artikel_typ_id'] 	  = 1;
			$position['artikel_beschreibung'] ='Lizenz';
			$position['rechnung_id']		  = $rechnung_id;

			$this->rechnung_position->insert_individuelle_position($position);
		}

		$this->rechnung->update_zahlen($rechnung_id);

		echo json_encode(array(
			'result' => $result
		));
	}

	public function abonnement_rechnungen_erstellen()
	{
		$this->validate_required_field(array(
			'abonnement_id'
		));

		$result = $this->abonnement->erstelle_rechnung_aus_vertraegen(
			$_POST['abonnement_id']
		);

		echo json_encode(array(
			'result'  => $result['result'],
			'message' => $result['message']
		));
	}
	
	public function datenback_backup_erstellen()
	{
		global $c_backup;

		$result = $c_backup->create_backup();

		echo json_encode(array(
			'result' => $result
		));
	}

	public function delete_backup()
	{
		$this->validate_required_field(array(
			'backup_id'
		));

		global $c_backup;

		$result = $c_backup->delete($_POST['backup_id']);

		echo json_encode(array(
			'result' => $result
		));
	}

	public function angebot_update()
	{
		$this->validate_required_field(array(
			'angebot_id', 'kunde_id', 'status', 'angebotsdatum', 'faellig_am'
		));

	
		$result = $this->angebot->update($_POST);

		echo json_encode(array(
			'result' => $result
		));

	}

	public function rechnung_update()
	{
		$this->validate_required_field(array(
			'rechnung_id', 'kunde_id', 'rechnungsdatum', 'faellig_am'
		));

	
		$result = $this->rechnung->update($_POST);

		echo json_encode(array(
			'result' => $result
		));

	}


	public function plz_anlegen() 
	{


		$plz = $this->plz_ort_suche->get_by_plz($_POST['suchbegriff_plz'],$_POST['fk_ort_id']);
		if($plz == NULL) {
			$neue_plz = $this->plz_ort_suche->insert($_POST);
			$result = true;
			$plzs = $this->plz_ort_suche->get_by_ort_id($_POST['fk_ort_id']);
		}
		else $result = 'vorhanden';
		
		echo json_encode(array(
			'result'       => $result,
			'plzs'         => $plzs,
			'ort_id'       => $neuer_ort['id'],
			'ort_name'     => $_POST['name']


		));
	}
	
	public function get_ort_by_plz() 
	{
		$response = $this->plz_ort_suche->get_ort_by_api($_POST['plz']);
		$ortsname = $response['ort_name'];

		$ort_obj = $this->ort->get_by_name($ortsname);
		$ort_id = $ort_obj['ort_id'];

		echo json_encode(array(
			'ort'               => $ortsname,
			'ort_id'            => $ort_id,
			'ort_hinzugefuegt'  => $response['ort_hinzugefuegt'],
			'plz'               => $_POST['plz']
		));
	}

	public function get_kunden()
	{
		$kunden = $this->kunde->get_all();
		$html = $this->table_helper->get_table_kunden($kunden);

		echo json_encode(array(
			'result' => $kunden,
			'html'   => $html
		));


	}


}
  

$ajax = new AJAX();
$ajax->action();