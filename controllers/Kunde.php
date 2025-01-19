<?php

class Kunde { 
	
	private $db;
	private $helper;
	private $mwst;
	private $einstellungen;
	
	private $fields;
	private $joins;
	private $tablename;


	
	public function __construct($db, $helper, $mwst, $einstellungen) 
	{
		
		$this->db            = $db;
		$this->helper        = $helper;
		$this->mwst          = $mwst;
		$this->einstellungen = $einstellungen;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		$this->set_joins($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                                            AS 'kunde_id', 
			".$tablename.".fk_mwst_id                                    AS 'fk_mwst_id', 
			".$tablename.".fk_user_id                                    AS 'fk_user_id', 
			".$tablename.".fk_ort_id                                     AS 'fk_ort_id', 
			".$tablename.".angelegt_am                                   AS 'angelegt_am', 
			".$tablename.".logo                                          AS 'logo', 
			".$tablename.".bearbeitet_am                                 AS 'bearbeitet_am', 
			".$tablename.".firmen_name                                   AS 'firmen_name', 
			".$tablename.".email                                         AS 'email', 
			".$tablename.".email_angebot_rechnung                        AS 'email_angebot_rechnung', 
			".$tablename.".telefon                                       AS 'telefon', 
			".$tablename.".mobil                                         AS 'mobil', 
			".$tablename.".strasse                                       AS 'strasse', 
			".$tablename.".plz                                           AS 'plz', 
			".$tablename.".webseite                                      AS 'webseite',
			".$tablename.".iban                                          AS 'iban',
			".$tablename.".bank                                          AS 'bank',
			".$tablename.".bic                                           AS 'bic',
			".$tablename.".konto_inhaber                                 AS 'konto_inhaber',        
			".$tablename.".geschaeftsfuehrer                             AS 'geschaeftsfuehrer',
			".$tablename.".fax                                           AS 'fax',
			".$tablename.".umsatzsteuer_id                               AS 'umsatzsteuer_id',
			".$tablename.".suchname                                      AS 'suchname',
			".$tablename.".automatisiert_abonnement_rechnungen_senden    AS 'automatisiert_abonnement_rechnungen_senden',
			".$tablename.".mahnung_automatisch_senden_deaktivieren       AS 'mahnung_automatisch_senden_deaktivieren',
			".$tablename.".zammad_organization_id                        AS 'zammad_organization_id',
			".$tablename.".zammad_inklusiv_takt                          AS 'zammad_inklusiv_takt',
			".$tablename.".zammad_takt_individueller_preis               AS 'zammad_takt_individueller_preis',
			".$tablename.".parkwin_system_url                            AS 'parkwin_system_url',
			".$tablename.".quality_hosting_reseller_customer_id          AS 'quality_hosting_reseller_customer_id',
			".$tablename.".status                                        AS 'status',
			ort.ortsname                                                 AS 'ort',
			user.id                                                      AS 'user_id',
			user.username                                                AS 'user_username',
			mwst.steuersatz                                              AS 'mwst_satz',
			mwst.bezeichnung                                             AS 'mwst_bezeichnung'

		";
	}

	public function set_joins($tablename) 
	{
		$this->joins = "
			INNER JOIN mwst ON mwst.id = ".$tablename.".fk_mwst_id
			INNER JOIN user ON user.id = ".$tablename.".fk_user_id
			INNER JOIN ort ON ort.id = ".$tablename.".fk_ort_id
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'kunde';
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

		$row = $this->db->get($sql);
		return $this->add_fields($row);
	}	

	public function get_id_by_reseller_customer_id($reseller_customer_id){
		$sql = "SELECT id
				 FROM ".$this->get_tablename()."
				 WHERE quality_hosting_reseller_customer_id LIKE ".$reseller_customer_id;

		$result = $this->db->get($sql);
		return $result['id'];
	}
	
	/**
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all($status = '', $join_rechnung = false) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins();

		if($join_rechnung == true) $sql .= " INNER JOIN rechnung ON rechnung.fk_kunde_id = kunde.id";

		$sql .= " WHERE ".$this->get_tablename().".id > 0";
			
		if($status != '') $sql .= " AND ".$this->get_tablename().".status = '".$status."'";
		
		$rows = $this->db->get_all($sql);
		return $this->add_multi_fields($rows);
	}

	/**
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_qualityhosting_kunden() 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE quality_hosting_reseller_customer_id != ''";
		
		$rows = $this->db->get_all($sql);
		return $this->add_multi_fields($rows);
	}

	public function get_firmenname_by_qualityhosting_reseller_customer_id($quality_hosting_reseller_customer_id)
	{
		$sql = "SELECT 
				firmen_name AS 'firmen_name'
			FROM ".$this->get_tablename()." 
			WHERE quality_hosting_reseller_customer_id = '".$quality_hosting_reseller_customer_id."'";
		$row = $this->db->get($sql);
		return $row['firmen_name'];
	}

	
	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($post, $files) 
	{

		$values   = $this->helper->escape_values($post);
		$date     = $this->helper->get_english_datetime_now();

	
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
				NULL, 
				".intval($values['mwst_id']).",
				".intval($_SESSION['id']).",
				".intval($values['ort_id']).",
				'".$date."',
				'".$date."',
				'', 
				'".$values["firmen_name"]."', 
				'".$values["email"]."', 
				'".$values["email_angebot_rechnung"]."', 
				'".$values["telefon"]."',
				'".$values["mobil"]."',
				'".$values["strasse"]."',
				'".$values["plz"]."',
				'".$values["webseite"]."',
				'".$values["iban"]."',
				'".$values["bank"]."',
				'".$values["bic"]."',
				'".$values["konto_inhaber"]."',
				'".$values["geschaeftsfuehrer"]."',
				'".$values["fax"]."',
				'".$values["umsatzsteuer_id"]."',
				'".$values["suchname"]."',
				'".$this->helper->get_toggle_value($values["automatisiert_abonnement_rechnungen_senden"])."',
				'".$this->helper->get_toggle_value($values["mahnung_automatisch_senden_deaktivieren"])."',
				'".$values["zammad_organization_id"]."',
				".intval($values["zammad_inklusiv_takt"]).",
				'".$this->helper->format_waehrung_for_db($values['zammad_takt_individueller_preis'])."',
				'".$values["parkwin_system_url"]."',
				'".$values["quality_hosting_reseller_customer_id"]."',
				'aktiv'
			)";
			

		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();

		if($files['logo'] != '') $this->update_logo($values, $files);

		return array(
			'id'     => $id,
			'result' => $result_insert
		);
	}
	
	/**
		update
		@var: post array
	**/
	
	public function update($post, $files) 
	{
		$values  = $this->helper->escape_values($post);
		$date    = $this->helper->get_english_datetime_now();
		
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				bearbeitet_am                                = '".$date."',
				fk_mwst_id                                   = ".intval($values['mwst_id']).",
				fk_ort_id                                    = ".intval($values['ort_id']).",
				firmen_name                                  = '".$values['firmen_name']."',
				email                                        = '".$values['email']."',
				email_angebot_rechnung                       = '".$values['email_angebot_rechnung']."',
				telefon                                      = '".$values['telefon']."',
				mobil                                        = '".$values['mobil']."',
				strasse                                      = '".$values['strasse']."',
				plz                                          = '".$values['plz']."',
				webseite                                     = '".$values['webseite']."',
				iban                                         = '".$values['iban']."',
				bank                                         = '".$values['bank']."',
				bic                                          = '".$values['bic']."',
				konto_inhaber                                = '".$values['konto_inhaber']."',
				geschaeftsfuehrer                            = '".$values['geschaeftsfuehrer']."',
				fax                                          = '".$values['fax']."',
				umsatzsteuer_id                              = '".$values['umsatzsteuer_id']."',
				suchname                                     = '".$values['suchname']."',
				automatisiert_abonnement_rechnungen_senden   = '".$this->helper->get_toggle_value($values['automatisiert_abonnement_rechnungen_senden'])."',
				mahnung_automatisch_senden_deaktivieren      = '".$this->helper->get_toggle_value($values['mahnung_automatisch_senden_deaktivieren'])."',
				zammad_organization_id                       = '".$values['zammad_organization_id']."',
				zammad_inklusiv_takt                         = ".intval($values['zammad_inklusiv_takt']).",
				zammad_takt_individueller_preis              = '".$this->helper->format_waehrung_for_db($values['zammad_takt_individueller_preis'])."',
				parkwin_system_url                           = '".$values['parkwin_system_url']."',
				quality_hosting_reseller_customer_id         = '".$values['quality_hosting_reseller_customer_id']."',
				suchname                                     = '".$values['suchname']."'
		WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);

		$result = $this->db->update($sql);
		if($files['logo'] != '') $this->update_logo($values, $files);
		return $result;
	}

	public function update_logo($post, $files) 
	{
		$result = $this->helper->upload_foto($files, 'logo');
		if($result['result'] == false) return;

		$sql = "UPDATE ".$this->get_tablename()." SET 
					logo = '".$result['dateiname']."' 
				WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);
		return $this->db->update($sql);
	}

	public function get_logo_url($kunde) 
	{
		
		if($kunde['logo'] == '') return $this->einstellungen['kunde_logo'];
		else return $this->helper->get_upload_path($kunde['logo']);
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
		if($row['email_angebot_rechnung'] == '') $row['email_angebot_rechnung'] = $row['email'];
		
		$row['adresse'] = $row['strasse'].' '.$row['plz'].' '.$row['ort'];

		return $row;
	}
		
}