<?php

class Abonnement { 
	
	private $db;
	private $helper;
	private $html;
	private $kunde;
	private $rechnung;
	private $rechnung_position;
	private $rechnung_ticket;
	private $abonnement_vertrag;
	private $abonnement_vertrag_rechnung;
	private $einstellungen;
	private $parkwin;
	private $zammad;
	private $api;
	private $email;
	private $url;

	
	private $fields;
	private $joins;
	private $tablename;
	
	CONST PARKWIN_API_ARTIKEL_NUMMER = '10136';
	CONST ZAMMAD_API_ARTIKEL_NUMMER = '10135';


	
	public function __construct($db, $helper, $html, $kunde, $rechnung, $rechnung_position, $rechnung_ticket, $abonnement_vertrag, $abonnement_vertrag_rechnung, $einstellungen, $parkwin, $zammad, $api, $email, $url) 
	{
		
		$this->db                            = $db;
		$this->helper                        = $helper;
		$this->html                          = $html;
		$this->kunde                         = $kunde;
		$this->rechnung                      = $rechnung;
		$this->rechnung_position             = $rechnung_position;
		$this->rechnung_ticket               = $rechnung_ticket;
		$this->abonnement_vertrag            = $abonnement_vertrag;
		$this->abonnement_vertrag_rechnung   = $abonnement_vertrag_rechnung;
		$this->einstellungen                 = $einstellungen;
		$this->parkwin                       = $parkwin;
		$this->zammad                        = $zammad;
		$this->api                           = $api;
		$this->email                         = $email;
		$this->url                           = $url;

		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		$this->set_joins($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                                  AS 'abonnement_id', 
			".$tablename.".fk_user_id                          AS 'fk_user_id', 
			".$tablename.".fk_kunde_id                         AS 'fk_kunde_id', 
			".$tablename.".angelegt_am                         AS 'angelegt_am', 
			".$tablename.".bearbeitet_am                       AS 'bearbeitet_am',
			".$tablename.".abonnementnummer                    AS 'abonnementnummer',
			".$tablename.".agentur_logo                        AS 'agentur_logo', 
			".$tablename.".agentur_firmen_name                 AS 'agentur_firmen_name', 
			".$tablename.".agentur_strasse                     AS 'agentur_strasse', 
			".$tablename.".agentur_plz                         AS 'agentur_plz', 
			".$tablename.".agentur_ort                         AS 'agentur_ort', 
			".$tablename.".agentur_steuernummer                AS 'agentur_steuernummer', 
			".$tablename.".agentur_umsatzsteuer_id             AS 'agentur_umsatzsteuer_id', 
			".$tablename.".agentur_geschaeftsfuehrer           AS 'agentur_geschaeftsfuehrer', 
			".$tablename.".agentur_registernummer              AS 'agentur_registernummer', 
			".$tablename.".agentur_registergericht             AS 'agentur_registergericht', 
			".$tablename.".agentur_telefon                     AS 'agentur_telefon', 
			".$tablename.".agentur_email                       AS 'agentur_email', 
            ".$tablename.".agentur_webseite                    AS 'agentur_webseite', 
            ".$tablename.".agentur_bank                        AS 'agentur_bank', 
            ".$tablename.".agentur_iban                        AS 'agentur_iban', 
            ".$tablename.".agentur_bic                         AS 'agentur_bic', 
            ".$tablename.".kunde_firmen_name                   AS 'kunde_firmen_name', 
			".$tablename.".kunde_strasse                       AS 'kunde_strasse', 
			".$tablename.".kunde_plz                           AS 'kunde_plz', 
			".$tablename.".kunde_ort                           AS 'kunde_ort', 
			".$tablename.".kunde_umsatzsteuer_id               AS 'kunde_umsatzsteuer_id', 
			".$tablename.".kunde_geschaeftsfuehrer             AS 'kunde_geschaeftsfuehrer', 
			".$tablename.".kunde_telefon                       AS 'kunde_telefon', 
			".$tablename.".kunde_email                         AS 'kunde_email', 
			".$tablename.".kunde_email_angebot_rechnung        AS 'kunde_email_angebot_rechnung', 
            ".$tablename.".kunde_webseite                      AS 'kunde_webseite', 
			".$tablename.".kunde_konto_inhaber                 AS 'kunde_konto_inhaber', 
			".$tablename.".kunde_bank                          AS 'kunde_bank', 
            ".$tablename.".kunde_iban                          AS 'kunde_iban', 
            ".$tablename.".kunde_bic                           AS 'kunde_bic', 
            ".$tablename.".dateiname                           AS 'dateiname', 
			".$tablename.".status                              AS 'status', 
			user.id                                            AS 'user_id',
			user.username                                      AS 'user_username',
			kunde.id                                           AS 'kunde_id',
			kunde.firmen_name                                  AS 'kunde_firmen_name',
			kunde.suchname                                     AS 'kunde_suchname',
			rolle.name                                         AS 'rolle'
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'abonnement';
	}

	public function set_joins($tablename) //joins fehlen noch
	{
		$this->joins = "
			INNER JOIN user ON user.id = ".$tablename.".fk_user_id
			INNER JOIN kunde ON kunde.id = ".$tablename.".fk_kunde_id
			INNER JOIN rolle ON user.fk_rolle_id = rolle.id
		";
	}
	
	public function get_fields()
	{
		return $this->fields;
	}
	
	public function get_tablename()
	{
		return $this->tablename;
	}

	public function get_joins()
	{
		return $this->joins;
	}

	public function get_status()
	{
		return array(
			'aktiv'      => array('label' => 'Aktiv', 'class' => 'btn btn-green btn-status'),
			'deaktiv'    => array('label' => 'Deaktiv', 'class' => 'btn btn-danger btn-status')
		);
	}

	
	/**
		Get by id
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get($id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".id = ".intval($id);

		$row = $this->add_fields($this->db->get($sql));
		return $row;
	}	
	
	/**
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all($status = '') 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".id > 0";
			
		if($status != '') $sql .= " AND ".$this->get_tablename().".status = '".$status."'";

		$sql .= " ORDER BY ".$this->get_tablename().".bearbeitet_am DESC";
		
		$rows = $this->db->get_all($sql);

		return $this->add_multi_fields($rows);
	}

	
	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($post) 
	{
		
		$values            = $this->helper->escape_values($post);
		$date              = $this->helper->get_english_datetime_now();
		$abonnementnummer  = $this->get_abonnementnummer();
		$einstellungen     = $this->einstellungen->get_all();
		$kunde             = $this->kunde->get($post['kunde_id']);

		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
			".intval($_SESSION["id"]).",
			".intval($values["kunde_id"]).",
			'".$date."',
			'".$date."',
			'".$abonnementnummer."',
			'".$einstellungen["logo_angebot_rechnung"]."',
			'".$einstellungen["firmen_name"]."',
			'".$einstellungen["strasse"]."',
			'".$einstellungen["plz"]."',
			'".$einstellungen["ort"]."',
			'".$einstellungen["firma_steuernummer"]."',
			'".$einstellungen["firma_umsatzsteuer_id"]."',
			'".$einstellungen["firma_geschaeftsfuehrer"]."',
			'".$einstellungen["registernummer"]."',
			'".$einstellungen["registergericht"]."',
			'".$einstellungen["telefon"]."',
			'".$einstellungen["email"]."',
			'".$einstellungen["webseite"]."',
			'".$einstellungen["bank"]."',
			'".$einstellungen["iban"]."',
			'".$einstellungen["bic"]."',
			'".$kunde["firmen_name"]."',
			'".$kunde["strasse"]."',
			'".$kunde["plz"]."',
			'".$kunde["ort"]."',
			'".$kunde["umsatzsteuer_id"]."',
			'".$kunde["geschaeftsfuehrer"]."',
			'".$kunde["telefon"]."',
			'".$kunde["email"]."',
			'".$kunde["email_angebot_rechnung"]."',
			'".$kunde["webseite"]."',
			'".$kunde["konto_inhaber"]."',
			'".$kunde["bank"]."',
			'".$kunde["iban"]."',
			'".$kunde["bic"]."',
			'',
			'aktiv'
		)";
	

		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();
		
		$pdf = $this->generiere_pdf($id);

		return array(
			'id'     => $id,
			'result' => $result_insert,
			'pdf'    => $pdf
		);
	}



	/**
		update
		@var: post array
	**/
	
	public function update($post) 
	{
		$values  = $this->helper->escape_values($post);
		$date    = $this->helper->get_english_datetime_now();

	
		 
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				bearbeitet_am                      = '".$date."',
				fk_kunde_id                        = ".intval($values['kunde_id'])."
			WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);
		
		$result = $this->db->update($sql);

		return $result;
	}

	public function erstelle_rechnung_aus_vertraegen($abonnement_id)
	{
		
		$abonnement = $this->get($abonnement_id);
		
		if($abonnement == null) {
			return array(
				'result'  => false,
				'message' => 'Abonnement nicht gefunden!'
			);
		}


		$abzurechnende_vertraege_result = $this->get_abzurechnende_vertraege($abonnement);

		$abzurechnende_vertraege    = $abzurechnende_vertraege_result['abzurechnende_vertraege'];
		$has_parkwin                = $abzurechnende_vertraege_result['has_parkwin'];
		$has_zammad                 = $abzurechnende_vertraege_result['has_zammad'];

		
		if(sizeof($abzurechnende_vertraege) == 0) {
			return array(
				'result'  => false,
				'message' => 'Keine fälligen Verträge vorhanden. Rechnungserstellung nicht notwendig.'
			);
		}

		$kunde = $this->kunde->get($abonnement['fk_kunde_id']);

		if($kunde == null) {
			return array(
				'result'  => false,
				'message' => 'Kunde konnte nicht gefunden werden'
			);
		}

		$rechnung_result = $this->rechnung->insert(array(
			'kunde_id'       => $abonnement['fk_kunde_id'],
			'rechnungsdatum' => null,
			'faellig_am'     => null
		));


		if($rechnung_result['result'] == false) {
			return array(
				'result'  => false,
				'message' => 'Rechnung konnte nicht erstellt werden'
			);
		}

		$parkwin_vertraege = array();
		$zammad_vertraege  = array();

		$this->abonnement_vertrag_rechnung->insert($abonnement_id, $abzurechnende_vertraege, $rechnung_result['id']);

		foreach($abzurechnende_vertraege AS $vertrag) {
			
			$artikel_preis = $this->html->waehrung($vertrag['artikel_preis']);

			$abrechnungszeitraum = $this->abonnement_vertrag->get_abrechnungszeitraum(
				$vertrag['naechste_faelligkeit'],
				$vertrag['zyklus_anzahl_monate']
			);
			

			$position_result = $this->rechnung_position->insert_individuelle_position(array(
				'rechnung_id'              => $rechnung_result['id'],
				'artikel_id'               => $vertrag['fk_artikel_id'],
				'artikel_nummer'           => $vertrag['artikel_nummer'],
				'artikel_name'             => $vertrag['artikel_name'],
				'artikel_beschreibung'     => $vertrag['artikel_beschreibung'],
				'artikel_preis'            => $artikel_preis,
				'artikel_menge'            => $vertrag['artikel_menge'],
				'artikel_zyklus'           => $vertrag['zyklus_bezeichnung'],
				'artikel_einheit'          => $vertrag['einheit_bezeichnung'],
				'artikel_artikel_typ'      => $vertrag['artikel_typ_bezeichnung'],
				'abrechnungszeitraum_von'  => $abrechnungszeitraum['von'],
				'abrechnungszeitraum_bis'  => $abrechnungszeitraum['bis']
			));

			$this->abonnement_vertrag->zyklus_hochzaehlen($vertrag); 
			

			if(($has_parkwin == true) && ($vertrag['artikel_nummer'] == self::PARKWIN_API_ARTIKEL_NUMMER)) {
				if($kunde['parkwin_system_url'] != '') array_push($parkwin_vertraege, $position_result['id']);
			}
			
			if(($has_zammad == true) && ($vertrag['artikel_nummer'] == self::ZAMMAD_API_ARTIKEL_NUMMER)) {
				if($kunde['zammad_organization_id'] != '') array_push($zammad_vertraege, $vertrag['abonnement_vertrag_id']);
			}

		}

		if(($has_parkwin == true) && (sizeof($parkwin_vertraege) > 0)) {
			$this->update_parkwin_vertraege($kunde, $parkwin_vertraege, $rechnung_result['id']);
		}

		if(($has_parkwin == true) && ($kunde['parkwin_system_url'] == '')) {
			$this->email->administrator_email('Fehler. Parkwin Position konnten nicht aktualisiert werden über die API. Parkwin System URL nicht vergeben!');
		}

		if($has_zammad == true) {
			$this->update_zammad_vertraege($kunde, $zammad_vertraege, $rechnung_result['id'], $zammad_artikel_nummer);
		}

		if(($has_zammad == true) && ($kunde['zammad_organization_id'] == '')) {
			$this->email->administrator_email('Fehler. Zammad Position konnten nicht aktualisiert werden über die API. Organization ID nicht vergeben!');
		}
		
		
		if($kunde['automatisiert_abonnement_rechnungen_senden'] == '1') $this->email->rechnung_senden($rechnung_result['id']);

		return array(
			'result'  => true
		);

	}

	public function update_parkwin_vertraege($kunde, $parkwin_vertraege, $rechnung_id)
	{

		$menge = $this->api->get_parkwin_buchungen($kunde);
		$kosten = $this->parkwin->berechne_kosten($menge);
		
		foreach($parkwin_vertraege AS $parkwin_vertrag_id) {
			$this->rechnung_position->update_feld('artikel_menge', $kosten['menge'], $parkwin_vertrag_id, $rechnung_id);
			$this->rechnung_position->update_feld('artikel_preis', floatval($kosten['preis']), $parkwin_vertrag_id, $rechnung_id);
			$this->rechnung_position->update_feld('artikel_beschreibung', $kosten['artikel_beschreibung'], $parkwin_vertrag_id, $rechnung_id);
		}
	}

	public function update_zammad_vertraege($kunde, $zammad_vertraege, $rechnung_id, $zammad_artikel_nummer)
	{
		$heute = new DateTime();
		$heute->modify('- 1month');

		foreach($zammad_vertraege AS $zammad_vertrag_id) {

			$jahr = $heute->format('Y');
			$monat = $heute->format('m');
			
			$result = $this->zammad->get_time_accounting($jahr, $monat);
    		
			$entries = json_decode($result['response'], true);

			
			$menge = 0;
			$tickets_html;
			$ticket_liste = array();
			$ticket_eintrag_ticket_liste = array();

			foreach($entries AS $ticket) {
				$time_unit        = floatval($ticket['time_unit']);
				$organization_id  = $ticket['ticket']['organization_id'];
				
				if($time_unit == null) continue;
				if($time_unit == '') continue;
				if($time_unit == 0.00) continue;
				if($organization_id == null) continue;

				// var_dump($organization_id);
				// var_dump($ticket['ticket']['id']);
				// var_dump($ticket['time_unit']);

				if($kunde['zammad_organization_id'] != $organization_id) continue;


				$menge += $time_unit;
				$this->rechnung_ticket->insert(array(
					'rechnung_id'  => $rechnung_id,
					'ticketnummer' => $ticket['ticket']['number'],
					'takt'         => $ticket['time_unit']
				));

				$ticket_liste[$ticket['ticket']['number']] += $time_unit;
				$ticket_eintrag_ticket_liste[$ticket['ticket']['id']] += $time_unit;
			}

			foreach($ticket_liste AS $number => $ticket_menge){
				$tickets_html .= '#'.$number.' ('.floatval($ticket_menge).') Takt, ';
			}

			foreach($ticket_eintrag_ticket_liste AS $ticket_id => $ticket_menge){
		
					$rechnung = $this->rechnung->get($rechnung_id);
					$rechnung_link;
					$kunden_name;
					$kunden_nummer;

					$this->zammad_ticket_eintrag_erstellen($ticket_id, $rechnung, $ticket_menge, $kunde);
			}


			$tickets_html = substr($tickets_html, 0, -2);
			$rechnung_position_id =$this->rechnung_position->get_by_rechnung_and_artikelnummer($rechnung_id, $zammad_artikel_nummer);

			$this->rechnung_position->update_feld('artikel_menge', $menge, $rechnung_position_id['rechnung_position_id'], $rechnung_id);
			$this->rechnung_position->update_feld('artikel_beschreibung', $tickets_html, $rechnung_position_id['rechnung_position_id'], $rechnung_id);

		}


	}

	public function zammad_ticket_eintrag_erstellen($ticket_id, $rechnung, $taktzahl, $kunde){

		$html = '<ul>';
        	$html .= '<li>Rechnungsnummer: '.$rechnung['rechnungsnummer'].'</li>';
        	$html .= '<li>Link zur Rechnung: <a class="a_link" href="';
			$html .= $this->url->get_rechnung_bearbeiten($rechnung['rechnung_id']);
			$html .= '" target="_blank">Hier klicken</a></li>';
        	$html .= '<li>Takte: '.$taktzahl.'</li>';
        	$html .= '<li>Kunde: '.$kunde['firmen_name'].'</li>';
        	$html .= '<li>Kundennummer: '.$kunde['kunde_id'].'</li>';
    	$html .= '</ul>';

		$this->zammad->insert_ticket_eintrag($ticket_id,'Fitrix Rechnung', $html);

	}
	
	public function add_multi_fields($rows)
	{
		if($rows == null) return null;
		if(is_array($rows) == false) return null;
		$result = array();

		foreach($rows AS $row) {
			$row = $this->add_fields($row);
			array_push($result, $row);
		}

		return $result; 
	}

	public function add_fields($row)
	{
		if($row == null) return null;
		
		$row['vertraege'] = $this->abonnement_vertrag->get_all($row['abonnement_id']);
		return $row;
	}

	/**
		Generiere PDF Datei
		return String abonnementnummer
	**/

	public function generiere_pdf($id) 
	{
		global $c_pdf;
		$dateiname = $c_pdf->generiere_abonnement_pdf(
			$id
		);
		return $this->update_dateiname($id, $dateiname);
	}
	
	public function get_abonnementnummer()
	{
		global $einstellungen;
		$sql = "SELECT MAX(id) AS 'max_id' FROM ".$this->get_tablename();
		$row = $this->db->get($sql);
		
		if($row == null) $id = '1';
		else if($row['max_id'] == null) $id = '1';
		else $id = $row['max_id'];

		$abonnement_nummer = $einstellungen['abonnement_abonnementnummer_praefix'].'-'.date('Y-m-d').'-'.$id;
		return $abonnement_nummer;
	}
		
	public function update_dateiname($id, $dateiname)
	{
		$sql = "UPDATE ".$this->get_tablename()." 
			SET dateiname = '".$dateiname."' 
			WHERE ".$this->get_tablename().".id = ".intval($id);
		return $this->db->update($sql);
	}

	public function get_abzurechnende_vertraege($abonnement)
	{
		$vertraege = $this->abonnement_vertrag->get_all($abonnement['abonnement_id'], 'aktiv');

		$abzurechnende_vertraege = array();
		$has_parkwin = false;
		$has_zammad = false;

		if(!is_array($vertraege)) {
			return array(
				'abzurechnende_vertraege' => $abzurechnende_vertraege,
				'has_parkwin'             => $has_parkwin,
				'has_zammad'              => $has_zammad
			);
		}

		foreach($vertraege AS $vertrag) {

			if($this->abonnement_vertrag->ubepruefe_ob_vertrag_rechnung_faellig($vertrag) == false) continue;

			if($vertrag['artikel_nummer'] == self::PARKWIN_API_ARTIKEL_NUMMER) $has_parkwin = true;
			if($vertrag['artikel_nummer'] == self::ZAMMAD_API_ARTIKEL_NUMMER) $has_zammad = true;

			array_push(
				$abzurechnende_vertraege,
				$vertrag
			);

		}

		return array(
			'abzurechnende_vertraege' => $abzurechnende_vertraege,
			'has_parkwin'             => $has_parkwin,
			'has_zammad'              => $has_zammad
		);

	}

	

}