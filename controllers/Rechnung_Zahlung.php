<?php

class Rechnung_Zahlung { 
	
	private $db;
	private $helper;
	private $zahlungsart;
	
	private $fields;
	private $tablename;


	
	public function __construct($db, $helper, $zahlungsart) 
	{
		$this->db             = $db;
		$this->helper         = $helper;
		$this->zahlungsart    = $zahlungsart;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                    AS 'rechnung_zahlung_id', 
			".$tablename.".fk_rechnung_id        AS 'fk_rechnung_id', 
			".$tablename.".fk_user_id            AS 'fk_user_id', 
			".$tablename.".erstellt_am           AS 'erstellt_am', 
			".$tablename.".zahlungsdatum         AS 'zahlungsdatum', 
			".$tablename.".zahlungsart           AS 'zahlungsart', 
			".$tablename.".zahlungsbetrag        AS 'zahlungsbetrag'
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'rechnung_zahlung';
	}
	
	public function get_fields()
	{
		return $this->fields;
	}
	
	public function get_tablename()
	{
		return $this->tablename;
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
			WHERE ".$this->get_tablename().".id = ".intval($id);

		$row = $this->db->get($sql);
		return $row;
	}	
	
	/**
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	 
	public function get_all($rechnung_id = null, $zeitraum = null) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".id > 0";
		
		if($rechnung_id != null) $sql .= " AND fk_rechnung_id = ".intval($rechnung_id);

		if(is_array($zeitraum)) {
			$von = $this->helper->english_date_no_time($zeitraum['von']);
			$bis = $this->helper->english_date_no_time($zeitraum['bis']);
			$sql .= " AND ".$this->get_tablename().".zahlungsdatum BETWEEN '".$von."' AND '".$bis."'";
		}

			
		return $this->db->get_all($sql);
	}

	
	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($post) 
	{
		global $c_rechnung;
		$values   = $this->helper->escape_values($post);
		$date     = $this->helper->get_english_datetime_now();
	
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
				NULL, 
				".intval($values['rechnung_id']).",
				".intval($_SESSION['id']).",
				'".$date."',
				'".$this->helper->english_date_no_time($post['zahlungsdatum'])."',
				'".$values['zahlungsart']."',
				'".$this->helper->format_waehrung_for_db($post['zahlungsbetrag'])."'
			)";
	

		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();

		$c_rechnung->update_status_zu_bezahlt($values['rechnung_id']);
		
		return array(
			'id'     => $id,
			'result' => $result_insert
		);
	}

	public function delete($rechnung_id, $id)
    {
		global $c_rechnung;
        $sql = "DELETE FROM ".$this->get_tablename()." WHERE id = ".intval($id)." AND fk_rechnung_id = ".intval($rechnung_id);
        $result = $this->db->delete($sql);
		$c_rechnung->update_status_zu_bezahlt($rechnung_id);
        return $result;
    }

	public function get_gesamt_zahlung($rechnung_id)
	{
		$zahlungen = $this->get_all($rechnung_id);
		if($zahlungen == null) return 0;

		$gesamt = 0;

		foreach($zahlungen AS $zahlung) {
			$gesamt += floatval($zahlung['zahlungsbetrag']);
		}	

		return $gesamt;
	}

	public function get_gesamt_zahlung_monat($jahr, $monat)
	{
		$sql = "SELECT
			SUM(zahlungsbetrag) AS 'gesamtkosten'
			FROM ".$this->get_tablename()."
			WHERE zahlungsdatum LIKE '".$jahr."-".$monat."-%'
		";

		$row = $this->db->get($sql);
		return $row['gesamtkosten'];

	}

	public function get_anzahl_bezahlte_rechnungen_monat($jahr, $monat)
	{
		$sql = "SELECT
			COUNT(id) AS 'anzahl'
			FROM ".$this->get_tablename()."
			WHERE zahlungsdatum LIKE '".$jahr."-".$monat."-%'
			GROUP BY id
		";

		$row = $this->db->get($sql);
		return $row['anzahl'];

	}

	public function get_zahlungsbetrag_summe($jahr, $monat) 
	{
		$sql = "SELECT 
		SUM(zahlungsbetrag) AS 'zahlungsbetrag_summe'
		FROM rechnung_zahlung 
		WHERE zahlungsdatum LIKE '".$jahr."-".$monat."-%'";
		$row = $this->db->get($sql);
		if($row == null) return 0;
		return $row['zahlungsbetrag_summe']; 
	}





		
}