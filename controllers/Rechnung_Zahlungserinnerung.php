<?php

class Rechnung_Zahlungserinnerung { 
	
	private $db;
	private $helper;
	private $email;
	
	private $fields;
	private $tablename;


	
	public function __construct($db, $helper, $email) 
	{
		$this->db             = $db;
		$this->helper         = $helper;
		$this->email          = $email;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                    AS 'rechnung_zahlung_id', 
			".$tablename.".fk_rechnung_id        AS 'fk_rechnung_id', 
			".$tablename.".gesendet_am           AS 'gesendet_am'
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'rechnung_zahlungserinnerung';
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

	public function get($rechnung_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".fk_rechnung_id = ".intval($rechnung_id);

		$row = $this->db->get($sql);
		return $row;
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
				'".$date."'
			)";
	

		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();

		$this->email->zahlungserinnerung_senden($values['rechnung_id']);
		
		return array(
			'id'     => $id,
			'result' => $result_insert
		);
	}




		
}