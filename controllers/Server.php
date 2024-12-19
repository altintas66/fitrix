<?php

class Server {
	
	private $db;
	private $helper;
	private $hosting;
	
	private $fields;
	private $tablename;
	
	public function __construct($db, $helper, $hosting) 
	{
		
		$this->db      = $db;
		$this->helper  = $helper;
		$this->hosting = $hosting;
		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id               AS 'server_id', 
            ".$tablename.".angelegt_am      AS 'angelegt_am', 
            ".$tablename.".bearbeitet_am    AS 'bearbeitet_am', 
            ".$tablename.".name             AS 'name', 
			".$tablename.".cpu              AS 'cpu', 
			".$tablename.".arbeitsspeicher  AS 'arbeitsspeicher', 
			".$tablename.".speicherplatz    AS 'speicherplatz', 
			".$tablename.".preis            AS 'preis', 
            ".$tablename.".ip_adresse       AS 'ip_adresse', 
            ".$tablename.".plesk_url        AS 'plesk_url', 
            ".$tablename.".plesk_user       AS 'plesk_user', 
			".$tablename.".plesk_passwort   AS 'plesk_passwort',
            ".$tablename.".bemerkung        AS 'bemerkung',
			".$tablename.".position         AS 'position',
            ".$tablename.".status           AS 'status'
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'server';
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
		return $this->add_fields($row);
	}	
	
	/**
		Get all
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all($status = '') 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename();

		$sql .= " ORDER BY ".$this->get_tablename().".position ASC";

		$rows =  $this->db->get_all($sql);
		return $this->add_multi_fields($rows);
	}

	public function get_server_names(){
		$sql = "SELECT name FROM ".$this->get_tablename();

		return $this->db->get_all($sql);
	}

		/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($post) 
	{

		$values = $this->helper->escape_values($post);
        $date = $this->helper->get_english_datetime_now();
		
        $sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
            '".$date."',
            '".$date."',
			'".$values["name"]."',
			'".$values["cpu"]."',
			'".$values["arbeitsspeicher"]."',
			'".$values["speicherplatz"]."',
			'".$this->helper->format_waehrung_for_db($values["preis"])."',
            '".$values["ip_adresse"]."',
            '".$values["plesk_url"]."',
            '".$values["plesk_user"]."',
            '".$values["plesk_passwort"]."',
            '".$values["bemerkung"]."',
			99,
            'aktiv'
		)";

		return array(
			'id'     => $this->db->get_last_inserted_id(), 
			'result' => $this->db->insert($sql)
		);
	}


	/**
		update
		@var: post array
	**/
	
	public function update($post) 
	{
		
		$values = $this->helper->escape_values($post);
		$date = $this->helper->get_english_datetime_now();
		
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				bearbeitet_am   = '".$date."',
				name            = '".$values['name']."',
				cpu             = '".$values['cpu']."',
				arbeitsspeicher = '".$values['arbeitsspeicher']."',
				speicherplatz   = '".$values['speicherplatz']."',
				preis           = '".$this->helper->format_waehrung_for_db($values["preis"])."',
				ip_adresse      = '".$values['ip_adresse']."',
				plesk_url       = '".$values['plesk_url']."',
				plesk_user      = '".$values['plesk_user']."',
				plesk_passwort  = '".$values['plesk_passwort']."',
				bemerkung = '".$values['bemerkung']."'
		WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);
		return $this->db->update($sql);	
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
		$hostings = $this->hosting->get_all_by_server_id($row['server_id']);
		
		$row['anzahl_hostings'] = $this->helper->get_size_of_array($hostings);
		return $row;
	}



		
}