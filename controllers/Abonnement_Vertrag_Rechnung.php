<?php

class Abonnement_Vertrag_Rechnung { 
	
	private $db;
	private $helper;
	private $abonnement_vertrag_rechnung_position;
	
	private $fields;
	private $tablename;


	
	public function __construct($db, $helper, $abonnement_vertrag_rechnung_position) 
	{
		
		$this->db                                   = $db;
		$this->helper                               = $helper;
		$this->abonnement_vertrag_rechnung_position = $abonnement_vertrag_rechnung_position;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());

		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                           			AS 'abonnement_vertrag_rechnung_id', 
			".$tablename.".fk_abonnement_id             			AS 'fk_abonnement_id', 
			".$tablename.".fk_rechnung_id               			AS 'fk_rechnung_id', 
			".$tablename.".angelegt_am                  			AS 'angelegt_am'
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'abonnement_vertrag_rechnung';
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
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all($abonnement_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".id > 0
			AND ".$this->get_tablename().".fk_abonnement_id = ".intval($abonnement_id)."
			ORDER BY ".$this->get_tablename().".angelegt_am DESC";
			
		return $this->db->get_all($sql);
	}

	
	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($abonnement_id, $vertraege, $rechnung_id) 
	{

		$date = $this->helper->get_english_datetime_now();

		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
				NULL, 
				".intval($abonnement_id).",
				".intval($rechnung_id).",
				'".$date."'
			)";
	
		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();

		$this->abonnement_vertrag_rechnung_position->insert_all(
			$id,
			$vertraege
		);
		
		return array(
			'id'     => $id,
			'result' => $result_insert
		);
	}
 


	


		
}