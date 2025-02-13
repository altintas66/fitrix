<?php

class Zahlungsart { 
	
	private $db;
	private $helper;
	
	private $fields;
	private $tablename;


	
	public function __construct($db, $helper) 
	{
		
		$this->db                  = $db;
		$this->helper              = $helper;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                          AS 'zahlungsart_id', 
			".$tablename.".angelegt_am                 AS 'angelegt_am', 
			".$tablename.".bearbeitet_am               AS 'bearbeitet_am', 
			".$tablename.".bezeichnung                 AS 'bezeichnung',
            ".$tablename.".status                      AS 'status'
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'zahlungsart';
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
		Get by id
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_by_bezeichnung($bezeichnung) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".bezeichnung = '".$bezeichnung."'";

		$row = $this->db->get($sql);
		return $row;
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
	
	public function insert($post) 
	{
		$entry = $this->get_by_bezeichnung($values["bezeichnung"]);
		if($entry != null) return false;
		
		$values   = $this->helper->escape_values($post);
		$date     = $this->helper->get_english_datetime_now();

	
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
			'".$date."',
			'".$date."',
			'".$values["bezeichnung"]."',
            'aktiv'
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
				bearbeitet_am             = '".$date."',
				bezeichnung               = '".$values['bezeichnung']."'
		WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);

		$result = $this->db->update($sql);
		return $result;
	}

	


		
}