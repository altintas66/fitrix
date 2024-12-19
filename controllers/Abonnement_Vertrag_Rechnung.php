<?php

class Abonnement_Vertrag_Rechnung { 
	
	private $db;
	private $helper;
	
	private $fields;
	private $tablename;


	
	public function __construct($db, $helper) 
	{
		
		$this->db                 = $db;
		$this->helper             = $helper;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                           AS 'abonnement_vertrag_rechnung_id', 
			".$tablename.".fk_artikel_id                AS 'fk_abonnement_vertrag_id',
			".$tablename.".fk_zyklus_id                 AS 'fk_rechnung_id', 
			".$tablename.".angelegt_am                  AS 'angelegt_am'
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

		$row = $this->format_row($this->db->get($sql));
		return $row;
	}	
	
	/**
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all($artikel_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".id > 0
			AND ".$this->get_tablename().".fk_artikel_id = ".intval($artikel_id);
			
		return $this->db->get_all($sql);
	}

	
	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($abonnement_vertrag_id, $rechnung_id) 
	{

		$date     = $this->helper->get_english_datetime_now();

		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
				NULL, 
				".intval($abonnement_vertrag_id).",
				".intval($rechnung_id).",
				'".$date."'
			)";
	
		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();

		
		return array(
			'id'     => $id,
			'result' => $result_insert
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
				bearbeitet_am      = '".$date."',
				fk_zyklus_id       = ".intval($values['zyklus_id']).",
				preis              = ".floatval($values['preis'])."
		WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);

		$result = $this->db->update($sql);
		return $result;
	}

	


		
}