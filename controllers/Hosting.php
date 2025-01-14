<?php

class Hosting {
	
	private $db;
	private $helper;
	
	private $fields;
	private $joins;
	private $tablename;
	
	public function __construct($db, $helper) 
	{
		
		$this->db     = $db;
		$this->helper = $helper;
		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		$this->set_joins($this->get_tablename());
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                         AS 'hosting_id', 
            ".$tablename.".fk_server_id               AS 'fk_server_id', 
            ".$tablename.".fk_kunde_id                AS 'fk_kunde_id', 
            ".$tablename.".fk_artikel_webhosting_id   AS 'fk_artikel_webhosting_id', 
            ".$tablename.".angelegt_am                AS 'angelegt_am', 
            ".$tablename.".bearbeitet_am              AS 'bearbeitet_am', 
            ".$tablename.".name                       AS 'name', 
			".$tablename.".url                        AS 'url', 
			".$tablename.".traffic_mb_monatlich       AS 'traffic_mb_monatlich', 
            ".$tablename.".status                     AS 'status',
			server.name                               AS 'server_name',
			kunde.firmen_name                         AS 'kunde_firmen_name',
			artikel.artikel_name                      AS 'artikel_name'
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'hosting';
	}
	
	public function set_joins($tablename) 
	{
		$this->joins = "
			INNER JOIN server ON server.id = ".$tablename.".fk_server_id
			INNER JOIN kunde ON kunde.id = ".$tablename.".fk_kunde_id
			INNER JOIN artikel ON artikel.id = ".$tablename.".fk_artikel_webhosting_id 
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

	public function get($id) 
	{
	
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".id = ".intval($id);

		return $this->db->get($sql);
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
			FROM ".$this->get_tablename()."
			".$this->get_joins();
		return $this->db->get_all($sql);
	}

	public function get_all_by_server_id($server_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".fk_server_id = ".intval($server_id);

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
            ".intval($values['server_id']).",
            ".intval($values['kunde_id']).",
            ".intval($values['artikel_webhosting_id']).",
            '".$date."',
            '".$date."',
			'".$values["name"]."',
			'".$values["url"]."',
			".intval($values["traffic_mb_monatlich"]).",
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
                bearbeitet_am             = '".$date."',
                fk_server_id              = ".intval($values['server_id']).",
                fk_kunde_id               = ".intval($values['kunde_id']).",
                fk_artikel_webhosting_id  = ".intval($values['artikel_webhosting_id']).",
				name                      = '".$values['name']."',
				url                       = '".$values['url']."',
				traffic_mb_monatlich      = ".intval($values['traffic_mb_monatlich'])."
		WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);

		return $this->db->update($sql);	
	}


		
}