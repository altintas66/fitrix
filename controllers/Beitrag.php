<?php

class Beitrag {
	
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
		$this->set_joins();

	
	}

	
	public function set_fields($tablename) 
	{
		global $c_user;
		$user_table = $c_user->get_tablename();
		$this->fields = "
			".$tablename.".id                           AS 'beitrag_id', 
			".$tablename.".fk_eintrag_id                AS 'fk_eintrag_id', 
			".$tablename.".fk_user_id                   AS 'fk_user_id', 
			".$tablename.".erstellt_am                  AS 'erstellt_am', 
			".$tablename.".bearbeitet_am                AS 'bearbeitet_am',
			".$tablename.".typ                          AS 'typ',
			".$tablename.".text                         AS 'text',
			".$user_table.".id                          AS 'user_id', 
			".$user_table.".username                    AS 'user_username', 
			".$user_table.".foto                        AS 'user_foto', 
			".$user_table.".geschlecht                  AS 'user_geschlecht', 
			".$user_table.".vorname                     AS 'user_vorname', 
			".$user_table.".nachname                    AS 'user_nachname', 
			".$user_table.".email                       AS 'user_email', 
			".$user_table.".mobil                       AS 'user_mobil',
			beitrag_user_markierung.fk_user_id          AS 'beitrag_user_markierung_user_id'

		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'beitrag';
	}
	
	public function set_joins() 
	{
		global $c_user;
		$user_table = $c_user->get_tablename();
		$this->joins = "
		LEFT JOIN ".$c_user->get_tablename()." ON fk_".$c_user->get_tablename()."_id = ".$c_user->get_tablename().".id
		LEFT JOIN beitrag_user_markierung ON beitrag.id = beitrag_user_markierung.fk_beitrag_id
		";
	}
	
	public function get_fields()
	{
		return $this->fields;
	}
	
	public function get_joins()
	{
		return $this->joins;
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
			WHERE ".$this->get_tablename().".id= ".intval($id);
		$row = $this->db->get($sql);
		return $this->add_row($row);
	}

	/**
		Get by Eintrag ID
		@var: int eintrag_id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_by_eintrag_id($eintrag_id, $typ) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE fk_eintrag_id = ".intval($eintrag_id).
            " AND typ = '".$typ."'";

		$rows = $this->db->get_all($sql);
		return $this->add_rows($rows);
	}

	
	/**
		insert
		@var: post array
		@return: array(int id & result (true | false))
	**/
	
	public function insert($post) 
	{
		global $c_helper;
		$values = $this->helper->escape_values($post);
		session_start();
		
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
			".intval($values["fk_eintrag_id"]).",
            ".intval($_SESSION['id']).",
			'".date('Y-m-d H:i:s')."',
			NULL,
			'".$values["typ"]."',
			'".$values["text"]."'
		)";

		$result = $this->db->insert($sql);	
		$id = $this->db->get_last_inserted_id();

		return array(
			'id'     => $id,
			'result' => $result
		);
	}
	
	/**
		update
		@var: post array
		@return: true | false
	**/
	
	public function update($post) 
	{

		global $c_helper;
		$values = $this->helper->escape_values($post);
		
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				bearbeitet_am   = '".date('Y-m-d H:i:s')."',
				text            = '".$values['text']."'
		WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);
		
		$result = $this->db->update($sql);
		return $result;
	}

	/**
		Delete
		@var: post array
		@return: true | false
	**/

	public function delete($post) 
	{
		
		$sql ="
			DELETE FROM ".$this->get_tablename()."  
		WHERE ".$this->get_tablename().".id = ".intval($post['beitrag_id']);
		
		$result = $this->db->delete($sql);
		return $result;
	}

	/**
		Überprüft, ob ein gewisser Beitrag einer USER ID zugehört
		@var: int beitrag_id
		@var: int user_id
		@return: true | false
	**/

	public function check_if_beitrag_assigned_to_user($beitrag_id, $user_id) 
	{
		$beitrag = $this->get($beitrag_id);
		if($beitrag['fk_user_id'] != $user_id) return false;
		return true;
	}

	public function add_rows($buff) {
		if($buff == NULL) return NULL;
		$beitraege = array();

		foreach($buff AS $b) {
			array_push($beitraege, $this->add_row($b));
		}
		return $beitraege;
	}

	public function add_row($beitrag) 
	{
		if($beitrag == NULL) return NULL;
		global $c_kommentar;
		$beitrag['kommentare'] = $c_kommentar->get_by_beitrag_id($beitrag['beitrag_id']);
		return $beitrag;
	}


		
}