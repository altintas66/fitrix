<?php

class Angebot { 
	
	private $db;
	private $helper;
	private $kunde;
	private $angebot_position;
	private $pdf;
	private $einstellungen;

	
	private $fields;
	private $joins;
	private $tablename;


	
	public function __construct($db, $helper, $kunde, $angebot_position, $pdf, $einstellungen) 
	{
		
		$this->db                 = $db;
		$this->helper             = $helper;
		$this->kunde              = $kunde;
		$this->angebot_position   = $angebot_position;
		$this->pdf                = $pdf;
		$this->einstellungen      = $einstellungen;

		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		$this->set_joins($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                                  AS 'angebot_id', 
			".$tablename.".fk_user_id                          AS 'fk_user_id', 
			".$tablename.".fk_kunde_id                         AS 'fk_kunde_id', 
			".$tablename.".angelegt_am                         AS 'angelegt_am', 
			".$tablename.".bearbeitet_am                       AS 'bearbeitet_am',
			".$tablename.".angebotsdatum                       AS 'angebotsdatum', 
			".$tablename.".faellig_am                          AS 'faellig_am', 
			".$tablename.".angebotsnummer                      AS 'angebotsnummer', 
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
			".$tablename.".netto_betrag                        AS 'netto_betrag', 
			".$tablename.".brutto_betrag                       AS 'brutto_betrag', 
			".$tablename.".mwst_satz                           AS 'mwst_satz', 
			".$tablename.".bedingungen                         AS 'bedingungen', 
			".$tablename.".zusatz_text                         AS 'zusatz_text',
			".$tablename.".gesendet                            AS 'gesendet',
			".$tablename.".gesendet_am                         AS 'gesendet_am',
			".$tablename.".dateiname                           AS 'dateiname',
			".$tablename.".status                              AS 'status',
			user.id                                            AS 'user_id',
			user.username                                      AS 'user_username',
			kunde.id                                           AS 'kunde_id',
			kunde.firmen_name                                  AS 'kunde_firmen_name',
			kunde.suchname                                     AS 'kunde_suchname'
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'angebot';
	}

	public function set_joins($tablename) 
	{
		$this->joins = "
			INNER JOIN user ON user.id = ".$tablename.".fk_user_id
			INNER JOIN kunde ON kunde.id = ".$tablename.".fk_kunde_id
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
			'offen'      => array('label' => 'Offen', 'class' => 'btn btn-warning btn-status'),
			'entwurf'    => array('label' => 'Entwurf', 'class' => 'btn btn-secondary btn-status'),
			'storniert'  => array('label' => 'Storniert', 'class' => 'btn btn-danger btn-status'),
			'akzeptiert'  => array('label' => 'Akzeptiert', 'class' => 'btn btn-green btn-status'),
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
		
		$values          = $this->helper->escape_values($post);
		$date            = $this->helper->get_english_datetime_now();
		$einstellungen   = $this->einstellungen->get_all();
		$kunde           = $this->kunde->get($post['kunde_id']);
		$angebotsnummer  = $this->get_angebotsnummer();
		$zusatz_text     = '';
		$brutto_betrag   = 0;
		$netto_betrag    = 0;


		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
			".intval($_SESSION["id"]).",
			".intval($values["kunde_id"]).",
			'".$date."',
			'".$date."',
			'".$this->helper->english_date_no_time($values['angebotsdatum'])."',
			'".$this->helper->english_date_no_time($values['faellig_am'])."',
			'".$angebotsnummer."',
			'".$einstellungen["firmen_name"]."',
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
			".intval($kunde["mwst_satz"]).",
			".floatval($netto_betrag).",
			".floatval($brutto_betrag).",
			'".$einstellungen["angebot_bedingungen"]."',
			'".$zusatz_text."',
			'0',
			NULL,
			'',
			'offen'
		)";
  
	
		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();

		$this->generiere_pdf($id);

		
		return array(
			'id'     => $id,
			'result' => $result_insert
		); 
	}

	/**
		Generiere PDF Datei
		return String rechnungsnummer
	**/

	public function generiere_pdf($id) 
	{
		$dateiname = $this->pdf->generiere_angebot_pdf(
			$id
		);
		
		$this->update_dateiname($id, $dateiname);
	}

	public function get_angebotsnummer()
	{
		global $einstellungen;
		$sql = "SELECT MAX(id) AS 'max_id' FROM ".$this->get_tablename();
		$row = $this->db->get($sql);
		
		if($row == null) $id = '1';
		else if($row['max_id'] == null) $id = '1';
		else $id = $row['max_id'];

		$angebot_nummer = $einstellungen['angebot_angebotsnummer_praefix'].'-'.date('Y-m-d').'-'.$id;
		return $angebot_nummer;
	}

	/**
		update
		@var: post array
	**/
	
	public function update($post) 
	{
		$values  = $this->helper->escape_values($post);
		$date    = $this->helper->get_english_datetime_now();
		$angebot = $this->get($post['angebot_id']);

		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				bearbeitet_am                      = '".$date."',
				fk_kunde_id                        = ".intval($values['kunde_id']).",
				status                             = '".$values['status']."',
				angebotsdatum                      = '".$this->helper->english_date_no_time($post['angebotsdatum'])."',
				faellig_am                         = '".$this->helper->english_date_no_time($post['faellig_am'])."',
				bedingungen                        = '".$values['bedingungen']."',
				zusatz_text                        = '".$values['zusatz_text']."'
			WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);
		
		$result = $this->db->update($sql);

		$this->generiere_pdf($values['angebot_id']);
		if($angebot['fk_kunde_id'] != $values['kunde_id']) $this->update_kunde($post);

		return $result;
	}

	public function update_kunde($post)
	{
		$kunde   = $this->kunde->get($post['kunde_id']);
		
		$sql = "UPDATE ".$this->get_tablename()." SET 
				kunde_firmen_name             = '".$kunde["firmen_name"]."',
				kunde_strasse                 = '".$kunde["strasse"]."',
				kunde_plz                     = '".$kunde["plz"]."',
				kunde_ort                     = '".$kunde["ort"]."',
				kunde_umsatzsteuer_id         = '".$kunde["umsatzsteuer_id"]."',
				kunde_geschaeftsfuehrer       = '".$kunde["geschaeftsfuehrer"]."',
				kunde_telefon                 = '".$kunde["telefon"]."',
				kunde_email                   = '".$kunde["email"]."',
				kunde_email_angebot_rechnung  = '".$kunde["email_angebot_rechnung"]."',
				kunde_webseite                = '".$kunde["webseite"]."',
				kunde_konto_inhaber           = '".$kunde["konto_inhaber"]."',
				kunde_bank                    = '".$kunde["bank"]."',
				kunde_iban                    = '".$kunde["iban"]."',
				kunde_bic                     = '".$kunde["bic"]."'
			WHERE ".$this->get_tablename().".id = ".itnval($post['angebot_id']);

		$result = $this->db->update($sql);
		$this->generiere_pdf($post['angebot_id']);
		return $result;

	}

	public function update_dateiname($id, $dateiname)
	{
		$sql = "UPDATE ".$this->get_tablename()." 
			SET dateiname = '".$dateiname."' 
			WHERE ".$this->get_tablename().".id = ".intval($id);
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
		
		$row['status_label'] = '<span class="'.$statuse[$row['status']]['class'].'">'.$row['status'].'</span>';
		$row['positionen']   = $this->angebot_position->get_all($row['angebot_id']);
		return $row;
	}

	

		
} 