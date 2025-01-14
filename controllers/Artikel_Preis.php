<?php

class Artikel_Preis { 
	
	private $db;
	private $helper;
	
	private $fields;
	private $joins;
	private $tablename;


	
	public function __construct($db, $helper) 
	{
		
		$this->db                 = $db;
		$this->helper             = $helper;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		$this->set_joins($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                           AS 'artikel_preis_id', 
			".$tablename.".fk_artikel_id                AS 'fk_artikel_id',
			".$tablename.".fk_zyklus_id                 AS 'fk_zyklus_id', 
			".$tablename.".angelegt_am                  AS 'angelegt_am', 
			".$tablename.".bearbeitet_am                AS 'bearbeitet_am', 
			".$tablename.".preis                        AS 'preis',
			zyklus.bezeichnung                          AS 'zyklus_bezeichnung',
			zyklus.bezeichnung                          AS 'zyklus'
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'artikel_preis';
	}

	public function set_joins($tablename)
	{
		$this->joins = "
			INNER JOIN zyklus ON zyklus.id = ".$tablename.".fk_zyklus_id
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
	
	
	/**
		Get by id
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get($artikel_id, $zyklus_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".fk_artikel_id = ".intval($artikel_id)."
			AND fk_zyklus_id = ".intval($zyklus_id);

		return $this->db->get($sql);
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

	public function get_preis_by_artikel_zyklus($artikel_id, $zyklus_id) {
		$sql = "SELECT preis AS 'preis' FROM ".$this->get_tablename()." WHERE fk_artikel_id = ".intval($artikel_id)."
		AND fk_zyklus_id = ".intval($zyklus_id);
		$row = $this->db->get($sql);
		if($row == null) return 0;
		else return $row['preis'];
	}
	
	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($post) 
	{

		$values   = $this->helper->escape_values($post);
		$date     = $this->helper->get_english_datetime_now();

		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
				NULL, 
				".intval($values['artikel_id']).",
				".intval($values['zyklus_id']).",
				'".$date."',
				'".$date."',
				".$this->helper->format_waehrung_for_db($values['preis'])."
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

	public function delete($id)
	{
		$sql = "DELETE FROM ".$this->get_tablename()." WHERE id = ".intval($id);
		return $this->db->delete($sql);
	}


		
}