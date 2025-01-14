<?php

class Email_Log {
	
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
			".$tablename.".id                          AS 'beitrag_id', 
			".$tablename.".fk_user_id                  AS 'fk_user_id', 
            ".$tablename.".fk_eintrag_id               AS 'fk_eintrag_id', 
			".$tablename.".erstellt_am                 AS 'erstellt_am', 
			".$tablename.".empfaenger                  AS 'empfaenger',
			".$tablename.".betreff                     AS 'betreff',
			".$tablename.".text                        AS 'text', 
			".$tablename.".smtp_response               AS 'smtp_response',
            ".$tablename.".eintrag_typ                 AS 'eintrag_typ',
			user.id                                    AS 'user_id',
			user.username                              AS 'user_username'
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'email_log';
	}

	public function set_joins($tablename) 
	{
		$this->joins = "
			LEFT JOIN user ON user.id = ".$tablename.".fk_user_id
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

	public function get_all($typ = '', $eintrag_id = null) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".id >  0";

        if($typ != '') $sql .= " AND eintrag_typ = '".$typ."'";
		if($eintrag_id != null) $sql .= " AND fk_eintrag_id = ".intval($eintrag_id);
		$sql .= " ORDER BY erstellt_am DESC";

		$rows = $this->db->get_all($sql);
		return $rows;
	}

	
	/**
		insert
		@var: post array
		@return: array(int id & result (true | false))
	**/
	
	public function insert($post) 
	{
        $date = $this->helper->get_english_datetime_now();
		$values = $this->helper->escape_values($post);
		session_start();
		
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
            ".intval($_SESSION['id']).",
            ".intval($values["eintrag_id"]).",
			'".$date."',
			'".$values["empfaenger"]."',
			'".$values["betreff"]."',
			'".$values["text"]."',
            ".intval($values["smtp_response"]).",
            '".$values["eintrag_typ"]."'
		)";

		$result = $this->db->insert($sql);	
		$id = $this->db->get_last_inserted_id();

		if(!isset($_SESSION['id'])) $this->set_fk_user_id_to_null($id);

		return array(
			'id'     => $id,
			'result' => $result
		);
	}

	public function set_fk_user_id_to_null($id)
	{
		$sql = "UPDATE ".$this->get_tablename()." SET fk_user_id = NULL WHERE id = ".intval($id);
		return $this->db->update($sql);
	}
	

		
}