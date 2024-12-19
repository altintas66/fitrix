<?php

class Mahnung { 
	
	private $db;
	private $helper;
    private $email;
	private $einstellungen;
	
	private $fields;
	private $tablename;


	
	public function __construct($db, $helper, $email, $einstellungen) 
	{
		
		$this->db               = $db;
		$this->helper           = $helper;
        $this->email            = $email;
		$this->einstellungen    = $einstellungen;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                          AS 'mahnung_id', 
			".$tablename.".fk_rechnung_id              AS 'fk_rechnung_id', 
			".$tablename.".gesendet_am                 AS 'gesendet_am', 
            ".$tablename.".begliechen_am               AS 'begliechen_am',
            ".$tablename.".status                      AS 'status'
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'mahnung';
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
		Get all by rechnung id
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all_by_rechnung_id($rechnung_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".id > 0
			AND fk_rechnung_id = ".intval($rechnung_id);
			
		return $this->db->get_all($sql);
	}
	
	/**
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all() 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".id > 0";
			
		return $this->db->get_all($sql);
	}
	
	
	
	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($rechnung_id, $rechnung_betrag) 
	{
		global $c_einstellungen;
		
		$date            = $this->helper->get_english_datetime_now();
		$einstellungen   = $c_einstellungen->get_all();
		$mahnbetrag      = floatval($rechnung_betrag)+ floatval($einstellungen["mahngebuehr"]);
	
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
            ".intval($rechnung_id).",
			'".$date."',
            ".floatval($mahnbetrag).",
            NULL,
            NULL,
            'offen'
		)";

		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();

		// $this->email->mahnung_senden($values['rechnung_id'], $id);

		return array(
			'id'     => $id,
			'result' => $result_insert
		);
	}
	


	
	/**
		Generiere PDF Datei
		return String abonnementnummer
	**/

	public function generiere_pdf($id) 
	{
		global $c_pdf;
		$dateiname = $c_pdf->generiere_mahnung_pdf(
			$id
		);
		return $this->update_dateiname($id, $dateiname['dateiname']);
	}


	public function update_dateiname($id, $dateiname)
	{
		$sql = "UPDATE ".$this->get_tablename()." 
			SET dateiname = '".$dateiname."' 
			WHERE ".$this->get_tablename().".id = ".intval($id);
		return $this->db->update($sql);
	}

}