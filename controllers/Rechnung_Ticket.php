<?php

class Rechnung_Ticket { 
	
	private $db;
	private $helper;
	
	private $fields;
	private $tablename;


	
	public function __construct($db, $helper) 
	{
		$this->db             = $db;
		$this->helper         = $helper;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                    AS 'rechnung_ticket_id', 
			".$tablename.".fk_rechnung_id        AS 'fk_rechnung_id', 
			".$tablename.".ticketnummer          AS 'ticketnummer', 
			".$tablename.".takt                  AS 'takt', 
			".$tablename.".erstellt_am           AS 'erstellt_am'
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'rechnung_ticket';
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
	 
	public function get_all($rechnung_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".id > 0
			AND fk_rechnung_id = ".intval($rechnung_id);
			
		return $this->db->get_all($sql);
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
				".intval($values['rechnung_id']).",
				'".$values['ticketnummer']."',
				".intval($values['takt']).",
				'".$date."'
			)";
	

		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();
		
		return array(
			'id'     => $id,
			'result' => $result_insert
		);
	}


		
}