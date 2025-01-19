<?php

class Rechnung { 
	
	private $db;
	private $helper;
	private $rechnung_position;
	private $rechnung_zahlung;
	private $kunde;
	private $pdf;
	private $mwst;
	private $mahnung;
	private $einstellungen;
	private $einstellungen_controller;
	
	private $fields;
	private $joins;
	private $tablename;


	
	public function __construct($db, $helper, $rechnung_position, $rechnung_zahlung, $kunde, $pdf, $mwst, $mahnung, $einstellungen) 
	{
		
		$this->db                        = $db;
		$this->helper                    = $helper;
		$this->rechnung_position         = $rechnung_position;
		$this->rechnung_zahlung          = $rechnung_zahlung;
		$this->kunde                     = $kunde;
		$this->pdf                       = $pdf;
		$this->mwst                      = $mwst;
		$this->mahnung                   = $mahnung;
		$this->einstellungen             = $einstellungen->get_all();
		$this->einstellungen_controller  = $einstellungen;
		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		$this->set_joins($this->get_tablename());
		
	}
	 
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                             AS 'rechnung_id', 
			".$tablename.".fk_kunde_id                    AS 'fk_kunde_id', 
			".$tablename.".fk_user_id                     AS 'fk_user_id', 
			".$tablename.".angelegt_am                    AS 'angelegt_am', 
			".$tablename.".bearbeitet_am                  AS 'bearbeitet_am', 
			".$tablename.".rechnungsdatum                 AS 'rechnungsdatum', 
			".$tablename.".faellig_am                     AS 'faellig_am', 
			".$tablename.".rechnungsnummer                AS 'rechnungsnummer', 
			".$tablename.".agentur_firmen_name            AS 'agentur_firmen_name',
			".$tablename.".agentur_firmen_name_kurz       AS 'agentur_firmen_name_kurz',
			".$tablename.".agentur_logo                   AS 'agentur_logo',
			".$tablename.".agentur_strasse                AS 'agentur_strasse',
			".$tablename.".agentur_plz                    AS 'agentur_plz',
			".$tablename.".agentur_ort                    AS 'agentur_ort',
			".$tablename.".agentur_steuernummer           AS 'agentur_steuernummer',
			".$tablename.".agentur_umsatzsteuer_id        AS 'agentur_umsatzsteuer_id',
			".$tablename.".agentur_geschaeftsfuehrer      AS 'agentur_geschaeftsfuehrer',
			".$tablename.".agentur_registernummer         AS 'agentur_registernummer',
			".$tablename.".agentur_registergericht        AS 'agentur_registergericht',
			".$tablename.".agentur_telefon                AS 'agentur_telefon',
			".$tablename.".agentur_email                  AS 'agentur_email',
			".$tablename.".agentur_webseite               AS 'agentur_webseite',
			".$tablename.".agentur_bank                   AS 'agentur_bank',
			".$tablename.".agentur_iban                   AS 'agentur_iban',
			".$tablename.".agentur_bic                    AS 'agentur_bic',
			".$tablename.".kunde_firmen_name              AS 'rg_kunde_firmen_name',
			".$tablename.".kunde_strasse                  AS 'rg_kunde_strasse',
			".$tablename.".kunde_plz                      AS 'rg_kunde_plz',
			".$tablename.".kunde_ort                      AS 'rg_kunde_ort',
			".$tablename.".kunde_umsatzsteuer_id          AS 'rg_kunde_umsatzsteuer_id',
			".$tablename.".kunde_geschaeftsfuehrer        AS 'rg_kunde_geschaeftsfuehrer',
			".$tablename.".kunde_telefon                  AS 'rg_kunde_telefon',
			".$tablename.".kunde_email                    AS 'rg_kunde_email',
			".$tablename.".kunde_email_angebot_rechnung   AS 'rg_kunde_email_angebot_rechnung',
			".$tablename.".kunde_webseite                 AS 'rg_kunde_webseite',
			".$tablename.".kunde_konto_inhaber            AS 'rg_kunde_konto_inhaber',
			".$tablename.".kunde_bank                     AS 'rg_kunde_bank',
			".$tablename.".kunde_iban                     AS 'rg_kunde_iban',
			".$tablename.".kunde_bic                      AS 'rg_kunde_bic',
			".$tablename.".gesendet                       AS 'gesendet',
			".$tablename.".gesendet_am                    AS 'gesendet_am',
			".$tablename.".ausgedruckt                    AS 'ausgedruckt', 
			".$tablename.".storno_datum                   AS 'storno_datum', 
			".$tablename.".zusatz_text                    AS 'zusatz_text', 
			".$tablename.".bedingungen                    AS 'bedingungen', 
			".$tablename.".mwst_satz                      AS 'mwst_satz', 
			".$tablename.".gesamt_netto                   AS 'gesamt_netto', 
			".$tablename.".gesamt_mwst                    AS 'gesamt_mwst', 
			".$tablename.".gesamt_brutto                  AS 'gesamt_brutto', 
			".$tablename.".dateiname                      AS 'dateiname', 
			".$tablename.".dateiname_e_rechnung           AS 'dateiname_e_rechnung', 
			".$tablename.".status                         AS 'status',
			user.id                                       AS 'user_id',
			user.username                                 AS 'user_username',
			kunde.id                                      AS 'kunde_id',
			kunde.firmen_name                             AS 'kunde_firmen_name',
			kunde.suchname                                AS 'kunde_suchname',
			rechnung_zahlungserinnerung.id                AS 'rechnung_zahlungserinnerung_id',
			rechnung_zahlungserinnerung.gesendet_am       AS 'rechnung_zahlungserinnerung_gesendet_am'
		";
	}

	public function set_joins($tablename) 
	{
		$this->joins = "
			INNER JOIN kunde ON kunde.id = ".$tablename.".fk_kunde_id
			LEFT JOIN user ON user.id = ".$tablename.".fk_user_id
			LEFT JOIN rechnung_zahlungserinnerung ON rechnung_zahlungserinnerung.fk_rechnung_id = ".$tablename.".id
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'rechnung';
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
			'offen'      => array('label' => 'Offen', 'class' => 'btn btn-warning btn-status'),
			'entwurf'    => array('label' => 'Entwurf', 'class' => 'btn btn-secondary btn-status'),
			'storniert'  => array('label' => 'Storniert', 'class' => 'btn btn-danger btn-status'),
			'bezahlt'   => array('label' => 'Bezahlt', 'class' => 'btn btn-success btn-status'),
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
	
		$row = $this->db->get($sql);
		return $this->add_fields($row);
	}	

	/**
		Get by id
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_by_rechnungsnummer($rechnungsnummer) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".rechnungsnummer = '".$rechnungsnummer."'";
	
		$row = $this->db->get($sql);
		return $this->add_fields($row);
	}
	
	/**
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all($status = '', $zeitraum = null) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".id > 0";
			
		if($status != '') $sql .= " AND ".$this->get_tablename().".status = '".$status."'";

		if(is_array($zeitraum)) {
			$von = $this->helper->english_date_no_time($zeitraum['von']);
			$bis = $this->helper->english_date_no_time($zeitraum['bis']);
			$sql .= " AND ".$this->get_tablename().".rechnungsdatum BETWEEN '".$von."' AND '".$bis."'";
			$sql .= " ORDER BY ".$this->get_tablename().".rechnungsdatum DESC";
		} else {
			$sql .= " ORDER BY ".$this->get_tablename().".angelegt_am DESC";
		}

		

		$rows = $this->db->get_all($sql);
		return $this->add_multi_fields($rows);
	}


	
	public function get_all_faellige() 
	{
		$datum = date('Y-m-d');
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".id > 0";
		$sql .= " AND ".$this->get_tablename().".faellig_am < '".$datum."'";


		$rows = $this->db->get_all($sql);
		return $this->add_multi_fields($rows);
	}

	public function get_rechnungen_by_kunde_id($kunde_id, $status = 'entwurf'){
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE fk_kunde_id = " .$kunde_id. " AND ".$this->get_tablename().".status = '" .$status."'";


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
		global $einstellungen;
		$values   = $this->helper->escape_values($post);
		$date     = $this->helper->get_english_datetime_now();
		$kunde    = $this->kunde->get($values['kunde_id']);
		$mwst     = $this->mwst->get($kunde['fk_mwst_id']);

		if((isset($values['rechnungsdatum'])) && ($values['rechnungsdatum'] != null)) $rechnungsdatum = $this->helper->english_date_no_time($values['rechnungsdatum']);
		else $rechnungsdatum = date('Y-m-d');
		
		if((isset($values['faellig_am'])) && ($values['faellig_am'] != null)) $faellig_am  = $this->helper->english_date_no_time($values['faellig_am']);
		else $faellig_am = $this->get_faellig_am($rechnungsdatum);

		if((isset($values['status'])) && ($values['status'] != null)) $status = $values['status'];
		else $status = 'entwurf';

		$rechnungsnummer  = $this->get_rechnungsnummer($status);
	
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
				NULL, 
				".intval($values['kunde_id']).",
				".intval($_SESSION['id']).",
				'".$date."',
				'".$date."',
				'".$rechnungsdatum."',
				'".$faellig_am."',
				'".$rechnungsnummer."',
				'".$einstellungen["firmen_name"]."',
				'".$einstellungen["firmen_name_kurz"]."',
				'".$einstellungen["logo_angebot_rechnung"]."',
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
				'0', 
				'NULL', 
				'0',
				NULL,
				'', 
				'".$einstellungen["rechnung_bedingungen"]."', 
				".intval($mwst['steuersatz']).",
				0,
				0,
				0,
				'',
				'',
				'".$status."'
			)"; 
	

		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();

		if(!isset($_SESSION['id'])) $this->set_field_to_null('fk_user_id', $id);

		$this->generiere_pdf($id);

		
		return array(
			'id'     => $id,
			'result' => $result_insert
		);
	}
 

	/**
		GET Rechnungsnummer
		return String rechnungsnummer
	**/

	public function get_rechnungsnummer($status = 'offen', $korrektur = false) 
	{
		if($korrektur == true) return false;
		$praefix      = $this->einstellungen['rechnung_rechnungsnummer_praefix'].'-'.date('Y').date('m').'-';
		if(($status == 'entwurf')) return $praefix.'XXXX';

		if($this->einstellungen['rechnungsnummer_generierung_inkrementell'] == '1') {
			
			$zuletzt_vergebene_rechnungsnummer = intval($this->einstellungen['zuletzt_vergebene_rechnungsnummer']);

			$zuletzt_vergebene_rechnungsnummer++;

			$this->einstellungen_controller->sql_update(
				'zuletzt_vergebene_rechnungsnummer', 
				$zuletzt_vergebene_rechnungsnummer
			); 

			return $zuletzt_vergebene_rechnungsnummer;
		}
	
		$z_verg_rgnr  = $this->einstellungen['zuletzt_vergebene_rechnungsnummer'];
		$suffix       = $this->get_rechnungsnummer_suffix($z_verg_rgnr);
		
		$freie_nummer = $this->get_freie_rechnungsnummer($suffix, $praefix, $z_verg_rgnr);
		
		$this->einstellungen_controller->sql_update('zuletzt_vergebene_rechnungsnummer', $freie_nummer['z_verg_rgnr']); 

		return $praefix.$freie_nummer['suffix'];
	}

	public function get_rechnungsnummer_suffix($nummer) 
	{
		$nummer = strval($nummer);
		if(strlen($nummer) == 1) return '000'.$nummer;
		else if(strlen($nummer) == 2) return '00'.$nummer; 
		else if(strlen($nummer) == 3) return '0'.$nummer;
		else return $nummer;
	}

	public function get_freie_rechnungsnummer($suffix, $praefix, $z_verg_rgnr)
	{
		$exist = true;
		$neuer_suffix = null;
		$z_verg_rgnr = intval($z_verg_rgnr);

		while($exist != false) {
			
			$rechnung = $this->get_by_rechnungsnummer($praefix.$suffix);
			if($rechnung == null) {
				$exist = false;
				$neuer_suffix = $suffix;
			} else {
				$z_verg_rgnr++;
				$suffix = $this->get_rechnungsnummer_suffix($z_verg_rgnr);
			}
		}

		$z_verg_rgnr++;

		return array(
			'suffix'      => $neuer_suffix,
			'z_verg_rgnr' => $z_verg_rgnr
		);

	}

	/**
		Generiere PDF Datei
		return String rechnungsnummer
	**/

	public function generiere_pdf($id) 
	{
		$this->update_zahlen($id);

		$dateiname = $this->pdf->generiere_rechnung_pdf(
			$id
		);

		$this->update_dateiname($id, $dateiname['dateiname']);
		$this->update_dateiname_e_rechnung($id, $dateiname['dateiname_e_rechnung']);

		return $dateiname;
	}
	
	/**
		update
		@var: post array
	**/
	
	public function update($post) 
	{
		$values  = $this->helper->escape_values($post);
		$date    = $this->helper->get_english_datetime_now();
		$vorher  = $this->get($post['rechnung_id']);
		$id      = $post[$this->get_tablename().'_id'];
		
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				bearbeitet_am          = '".$date."',
				fk_kunde_id            = ".intval($values['kunde_id']).",
				rechnungsdatum         = '".$this->helper->english_date_no_time($values['rechnungsdatum'])."',
				faellig_am             = '".$this->helper->english_date_no_time($values['faellig_am'])."',
				bedingungen            = '".$values['bedingungen']."',
				zusatz_text            = '".$values['zusatz_text']."'
		WHERE ".$this->get_tablename().".id = ".intval($id);

		$result = $this->db->update($sql);

		if($values['kunde_id'] != $vorher['fk_kunde_id']) $this->update_kunde($values['rechnung_id'], $values['kunde_id']);

		$this->generiere_pdf($values['rechnung_id']);
	
		return $result;
	}

	public function update_dateiname($id, $dateiname)
	{
		$sql = "
			UPDATE ".$this->get_tablename()." SET
				dateiname = '".$dateiname."' 
			WHERE ".$this->get_tablename().".id = ".intval($id);
		return $this->db->update($sql);
	}

	public function update_dateiname_e_rechnung($id, $dateiname)
	{
		$sql = "
			UPDATE ".$this->get_tablename()." SET
				dateiname_e_rechnung = '".$dateiname."' 
			WHERE ".$this->get_tablename().".id = ".intval($id);
		return $this->db->update($sql);
	}

	public function update_status($id, $status, $korrektur = false)
	{
		$rechnungsnummer  = $this->get_rechnungsnummer($status, $korrektur);

		$sql = "
			UPDATE ".$this->get_tablename()." SET
				status = '".$status."'";
		
		if($korrektur == false){
			$sql .=", rechnungsnummer = '".$rechnungsnummer."'";
		}
		$sql .= " WHERE ".$this->get_tablename().".id = ".intval($id);

			$result = $this->db->update($sql);
			$this->generiere_pdf($id);
		return true;
	}
	

	public function update_kunde($rechnung_id, $kunde_id) 
	{
		$kunde = $this->kunde->get($kunde_id);
		$sql = "
			UPDATE ".$this->get_tablename()." SET
				kunde_firmen_name              = '".$kunde['firmen_name']."',
				kunde_strasse                  = '".$kunde['strasse']."',
				kunde_plz                      = '".$kunde['plz']."',
				kunde_ort                      = '".$kunde['ort']."',
				kunde_umsatzsteuer_id          = '".$kunde['umsatzsteuer_id']."',
				kunde_geschaeftsfuehrer        = '".$kunde['geschaeftsfuehrer']."',
				kunde_telefon                  = '".$kunde['telefon']."',
				kunde_email                    = '".$kunde['email']."',
				kunde_email_angebot_rechnung   = '".$kunde['email_angebot_rechnung']."',
				kunde_webseite                 = '".$kunde['webseite']."',
				kunde_konto_inhaber            = '".$kunde['konto_inhaber']."',
				kunde_bank                     = '".$kunde['bank']."',
				kunde_iban                     = '".$kunde['iban']."',
				kunde_bic                      = '".$kunde['bic']."'
			WHERE ".$this->get_tablename().".id = ".intval($rechnung_id);
		return $this->db->update($sql);
	}

	public function get_faellig_am($rechnungsdatum)
	{

		if($rechnungsdatum == null) return '';
		if($rechnungsdatum == '') return '';

		$rechnungsdatum = new DateTime($rechnungsdatum);
		$faellig_am = $rechnungsdatum->modify('+'.$this->einstellungen['rechnung_anzahl_tage_faelligkeit'].' days');

		return $faellig_am->format('Y-m-d');
	}

	public function set_field_to_null($feldname, $id)
	{
		$sql = "UPDATE ".$this->get_tablename()." SET ".$feldname." = NULL WHERE id = ".$id;
		return $this->db->update($sql);
	}

	public function get_anzahl_faellige_rechnungen_monat($jahr, $monat)
	{
		$sql = "SELECT
			COUNT(id) AS 'anzahl'
			FROM ".$this->get_tablename()."
			WHERE faellig_am LIKE '".$jahr."-".$monat."-%'
		";

		$row = $this->db->get($sql);
		return $row['anzahl'];

	}

	public function update_zahlen($id) 
	{
		$rechnung = $this->get($id);
		$gesamt_netto  = 0;
		$gesamt_mwst   = 0;
		$gesamt_brutto = 0;

		$positionen = $this->rechnung_position->get_all($id);

		foreach($positionen AS $position) {
			$gesamt_netto += $this->rechnung_position->get_gesamt_preis(
				$position['preis'],
				$position['menge'],
				$position
			);
		}

		$gesamt_mwst   = $this->helper->get_mwst($gesamt_netto, $rechnung['mwst_satz']);
		$gesamt_brutto = $this->helper->get_brutto($gesamt_netto, $rechnung['mwst_satz']);

		$sql = "UPDATE ".$this->get_tablename()." SET 
				gesamt_netto  = '".$gesamt_netto."',
				gesamt_mwst   = '".$gesamt_mwst."',
				gesamt_brutto = '".$gesamt_brutto."'
			WHERE id = ".intval($id);
		
		return $this->db->update($sql);

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
		$statuse = $this->get_status();
		
		$row['status_label']     = '<span class="'.$statuse[$row['status']]['class'].'">'.$row['status'].'</span>';
		$row['positionen']       = $this->rechnung_position->get_all($row['rechnung_id']);
		$row['zahlungen']        = $this->rechnung_zahlung->get_all($row['rechnung_id']);
		$row['gesamt_zahlung']   = $this->rechnung_zahlung->get_gesamt_zahlung($row['rechnung_id']);
		$row['anzahl_zahlungen'] = $this->helper->get_size_of_array($row['zahlungen']);
		$row['offene_zahlung']   =  floatval($row['gesamt_brutto']) - $row['gesamt_zahlung'];
		$row['mahnungen']        = $this->mahnung->get_all_by_rechnung_id($row['rechnung_id']);

		$row['faellig_am_class'] = $this->get_faellig_am_class($row);
		$row['gesamt_zahlung_class'] = $this->get_gesamt_zahlung_class($row);

		return $row;
	}

	public function get_faellig_am_class($rechnung)
	{
		$heute = new DateTime(date('Y-m-d'));
		$faellig_am = new DateTime($rechnung['faellig_am']);
		if($heute >= $faellig_am) return 'border-button border-button-danger';
		else return 'border-button border-button-success';

	}

	public function get_gesamt_zahlung_class($rechnung)
	{
		$gesamt_zahlung = floatval($rechnung['gesamt_zahlung']);
		$gesamt_brutto  = floatval($rechnung['gesamt_brutto']);


		if($gesamt_zahlung == 0) return 'border-button border-button-danger';
		else if($gesamt_zahlung < $gesamt_brutto) return 'border-button border-button-warning';
		else return 'border-button border-button-success';

	}

	public function get_min_jahr()
	{
		$sql = "SELECT MIN(faellig_am) AS 'min' FROM ".$this->get_tablename();
		$row = $this->db->get($sql);
		if($row == null) return date('Y');
		else {
			$min = new DateTime($row['min']);
			return $min->format('Y');
		} 
	} 

	public function get_rechnungsausgang_summe($jahr, $monat) 
	{
		$sql = "SELECT 
			SUM(gesamt_brutto) AS 'brutto_summe'
		FROM ".$this->get_tablename()." 
		WHERE faellig_am LIKE '".$jahr."-".$monat."-%'";
	
		$row = $this->db->get($sql);
		return $row['brutto_summe']; 
	}

	public function get_ausstehende_gesamt_rechnungssumme()
	{
		$offen_gesamt = 0;
		$rechnungen = $this->get_all('offen');
		if($rechnungen == null) return 0;

		foreach($rechnungen AS $rechnung) {
			$offen_gesamt += floatval($rechnung['offene_zahlung']);
		}

		return $offen_gesamt;
	}

	public function get_anzahl_offene_rechnungen()
	{
		$sql = "SELECT COUNT(id) AS 'anzahl_offene' FROM rechnung WHERE status = 'offen'";
		$row = $this->db->get($sql);
		if($row == null) $anzahl_offene = 0;
		else $anzahl_offene = $row['anzahl_offene'];
		
		$sql = "SELECT COUNT(id) 'anzahl_alle' FROM rechnung WHERE (status = 'offen' OR status = 'bezahlt')";
		$row = $this->db->get($sql);
		if($row == null) $anzahl_alle = 0;
		else $anzahl_alle = $row['anzahl_alle'];


		return array(
			'alle'  => $anzahl_alle,
			'offen' => $anzahl_offene
		);

	}

	public function get_kunden_statistik($kunde_id)
	{
		$alle_rechnungen   = 0;
		$offene_rechnungen = 0;
		$gesamt_umsatz     = 0;
		$gesamt_einnahmen  = 0;

		$sql = "SELECT COUNT(id) AS 'alle_rechnungen' FROM ".$this->get_tablename()." WHERE status != 'storniert' AND status != 'entwurf' AND rechnung.fk_kunde_id = ".intval($kunde_id);
		$row = $this->db->get($sql);
		if($row != null) $alle_rechnungen = $row['alle_rechnungen'];

		$sql = "SELECT COUNT(id) AS 'offene_rechnungen' FROM ".$this->get_tablename()." WHERE status = 'offen' AND rechnung.fk_kunde_id = ".intval($kunde_id);
		$row = $this->db->get($sql);
		if($row != null) $offene_rechnungen = $row['offene_rechnungen'];

		$sql = "SELECT SUM(gesamt_brutto) AS 'gesamt_umsatz' FROM ".$this->get_tablename()." WHERE status != 'storniert' AND status != 'entwurf' AND rechnung.fk_kunde_id = ".intval($kunde_id);
		$row = $this->db->get($sql);
		if($row != null) $gesamt_umsatz = $row['gesamt_umsatz'];

		$sql = "SELECT SUM(zahlungsbetrag) AS 'gesamt_einnahmen' FROM rechnung_zahlung INNER JOIN rechnung ON rechnung_zahlung.fk_rechnung_id = rechnung.id WHERE rechnung.fk_kunde_id = ".intval($kunde_id);
		$row = $this->db->get($sql);
		if($row != null) $gesamt_einnahmen = $row['gesamt_einnahmen'];

		return array(
			'alle_rechnungen'   => $alle_rechnungen,
			'offene_rechnungen' => $offene_rechnungen,
			'gesamt_umsatz'     => $gesamt_umsatz,
			'gesamt_einnahmen'  => $gesamt_einnahmen
		);


	}

	public function update_status_zu_bezahlt($id)
	{
		$rechnung = $this->get($id);
		if($rechnung['offene_zahlung'] <= 0) {
			if($rechnung['status'] == 'offen') $this->update_status($id, 'bezahlt');
		} else if($rechnung['offene_zahlung'] > 0) { 
			if($rechnung['status'] == 'bezahlt') $this->update_status($id, 'offen');
		}
	}

	public function update_ausgedruckt($id)
	{
		$sql = "UPDATE ".$this->get_tablename()." SET 
				ausgedruckt = '1'
			WHERE ".$this->get_tablename().".id = ".intval($id);
		
		return $this->db->update($sql);
	}

	


	
		
}