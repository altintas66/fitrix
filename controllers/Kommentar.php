<?php

class Kommentar {
	
	private $db;
	private $helper;
    private $user;
	
	private $fields;
	private $tablename;
	private $joins;
	
	public function __construct($db, $helper, $user) 
	{
		
		$this->db     = $db;
		$this->helper = $helper;
        $this->user   = $user;
		
		$this->set_tablename();
		$this->set_fields();
		$this->set_joins();

	}

	
	public function set_fields() 
	{
	
		$this->fields = "
			".$this->get_tablename().".id                        AS 'kommentar_id', 
			".$this->get_tablename().".fk_beitrag_id             AS 'fk_beitrag_id', 
			".$this->get_tablename().".fk_user_id                AS 'fk_user_id', 
			".$this->get_tablename().".erstellt_am               AS 'erstellt_am', 
			".$this->get_tablename().".bearbeitet_am             AS 'bearbeitet_am',
			".$this->get_tablename().".text                      AS 'text',
			".$this->user->get_tablename().".id                  AS 'user_id', 
			".$this->user->get_tablename().".fk_rolle_id         AS 'user_fk_rolle_id', 
			".$this->user->get_tablename().".foto                AS 'user_foto', 
			".$this->user->get_tablename().".username            AS 'user_username', 
			".$this->user->get_tablename().".vorname             AS 'user_vorname', 
			".$this->user->get_tablename().".nachname            AS 'user_nachname', 
			".$this->user->get_tablename().".email               AS 'user_email', 
			".$this->user->get_tablename().".mobil               AS 'user_mobil'
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'kommentar';
	}

	public function set_joins() 
	{
		$this->joins = "
			LEFT JOIN ".$this->user->get_tablename()." ON fk_".$this->user->get_tablename()."_id = ".$this->user->get_tablename().".id";
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
			WHERE ".$this->get_tablename().".id= ".intval($id);
	
		return $this->db->get($sql);
	}

	/**
		Get by Beitrag ID
		@var: int beitrag_id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_by_beitrag_id($beitrag_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE fk_beitrag_id = ".intval($beitrag_id);
	
		return $this->db->get_all($sql);
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
		
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
			".intval($values["beitrag_id"]).",
            ".intval($values["mitarbeiter_id"]).",
			'".date('Y-m-d H:i:s')."',
			NULL,
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
		WHERE ".$this->get_tablename().".id = ".intval($post['kommentar_id']);
		
		$result = $this->db->delete($sql);
		return $result;
	}



	/**
		Überprüft, ob ein gewisser Kommentar einer USER ID zugehört
		@var: int kommentar_id
		@var: int user_id
		@return: true | false
	**/

	public function check_if_kommentar_assigned_to_user($kommentar_id, $user_id) 
	{
		$kommentar = $this->get($kommentar_id);
		if($kommentar['fk_mitarbeiter_id'] != $user_id) return false;
		return true;
	}

}