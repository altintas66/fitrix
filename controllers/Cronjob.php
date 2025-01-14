<?php

class Cronjob {
	
	private $db;
	private $helper;
	
	private $fields;
	private $tablename;
	
	public function __construct($db, $helper) 
	{

		$this->db     = $db;
		$this->helper = $helper;
		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
	}
	
	public function set_fields($tablename) 
	{

		$this->fields = "
			".$tablename.".id                 AS 'cronjob_id', 
			".$tablename.".ausgefuehrt_am     AS 'ausgefuehrt_am',
			".$tablename.".url                AS 'url',
			".$tablename.".ausfuehrungszeit   AS 'ausfuehrungszeit',
			".$tablename.".anmerkungen        AS 'anmerkungen',
			".$tablename.".json               AS 'json'
		";
		
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'cronjob';
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

	public function get_all() 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename().
			" ORDER BY ausgefuehrt_am DESC
			LIMIT 1000";

		return $this->db->get_all($sql);
	}
	
	public function insert($post) 
	{
		
		$values = $this->helper->escape_values($post);
		$date = $this->helper->get_english_datetime_now();

		$json = '';
		if(is_array($post['json'])) $json = json_encode($post['json']);

		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
			'".$date."',
			'".$values['url']."',
			'".$values['ausfuehrungszeit']."',
			'".$values['anmerkungen']."',
			'".$json."'
		)";

		$result = $this->db->insert($sql);	
		$id = $this->db->get_last_inserted_id();

		return array(
			'id'     => $id,
			'result' => $result
		);
		
	}

	public function get_cronjob_jobs()
	{
		$sql = "SELECT name AS 'name' FROM cronjob_jobs WHERE status = 'aktiv'";
		$rows = $this->db->get_all($sql);

		$results = array();

		foreach($rows AS $row) {
			array_push($results, $row['name']);
		}
		
		return $results;
	}
	


	
		
}