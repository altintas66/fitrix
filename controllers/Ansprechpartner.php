<?php

class Ansprechpartner { 
	
	private $db;
	private $helper;
	private $kunde;
	
	private $fields;
	private $joins;
	private $tablename;


	
	public function __construct($db, $helper, $kunde) 
	{
		
		$this->db                 = $db;
		$this->helper             = $helper;
		$this->kunde              = $kunde;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		$this->set_joins($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                           AS 'ansprechpartner_id', 
			".$tablename.".fk_kunde_id                  AS 'fk_kunde_id', 
			".$tablename.".fk_user_id                   AS 'fk_user_id', 
			".$tablename.".angelegt_am                  AS 'angelegt_am', 
			".$tablename.".bearbeitet_am                AS 'bearbeitet_am', 
			".$tablename.".anrede                       AS 'anrede', 
			".$tablename.".vorname                      AS 'vorname', 
			".$tablename.".nachname                     AS 'nachname', 
			".$tablename.".email                        AS 'email', 
			".$tablename.".mobilnummer                  AS 'mobilnummer', 
			".$tablename.".whatsapp                     AS 'whatsapp', 
			".$tablename.".bemerkung                    AS 'bemerkung', 
			".$tablename.".status                       AS 'status'
		";
	}

	public function set_joins($tablename) 
	{
		$this->joins = "
			INNER JOIN kunde ON kunde.id = ".$tablename.".fk_kunde_id
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'ansprechpartner';
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

	public function get_anreden() 
	{
		return array(
			'Herr' => 'Herr',
			'Frau' => 'Frau'
		);
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
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all($kunde_id, $status = '') 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".id > 0
			AND ".$this->get_tablename().".fk_kunde_id = ".intval($kunde_id);
			
		if($status != '') $sql .= " AND ".$this->get_tablename().".status = '".$status."'";
		
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
			".intval($values['kunde_id']).",
			".intval($_SESSION['id']).",
			'".$date."',
			'".$date."',
			'".$values["anrede"]."', 
			'".$values["vorname"]."', 
			'".$values["nachname"]."',
			'".$values["email"]."',
			'".$values["mobilnummer"]."',
			'".$this->helper->get_toggle_value($values["whatsapp"])."', 
			'".$values["bemerkung"]."',
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
				bearbeitet_am         = '".$date."',
				anrede                = '".$values['anrede']."',
				vorname               = '".$values['vorname']."',
				nachname              = '".$values['nachname']."',
				email                 = '".$values['email']."',
				mobilnummer           = '".$values['mobilnummer']."',
				whatsapp              = '".$this->helper->get_toggle_value($post['whatsapp'])."',
				bemerkung             = '".$values['bemerkung']."'
		WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);

		$result = $this->db->update($sql);

	
		return $result;
	}

	


		
}