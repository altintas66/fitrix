<?php

class Erinnerung {
	
	private $db;
	private $helper;
	private $url;

	private $fields;
	private $tablename;
	
	public function __construct($db, $helper, $url) 
	{
		$this->db     = $db;
		$this->helper = $helper;
		$this->url    = $url;
		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
	}

	
	public function set_fields($tablename) 
	{

		$this->fields = "
			".$tablename.".id                          AS 'erinnerung_id', 
			".$tablename.".fk_user_id                  AS 'fk_user_id', 
            ".$tablename.".datum                       AS 'datum', 
			".$tablename.".erstellt_am                 AS 'erstellt_am', 
			".$tablename.".text                        AS 'text'
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'erinnerung';
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
			WHERE ".$this->get_tablename().".id= ".intval($id);
		$row = $this->db->get($sql);

		return $row;
	}


	/**
		Get by Eintrag ID
		@var: int eintrag_id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_all($typ = null) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".id >  0";

        if($typ != null) $sql .= " AND typ = '".$typ."'";

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
        $heute  = $this->helper->get_english_datetime_now();
		$values = $this->helper->escape_values($post);
		$datum  = $this->helper->english_date_no_time($values['datum']);
		
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
			NULL,
			'".$datum."',
			'".$heute."',
			'".$values["text"]."'
		)";

		$result = $this->db->insert($sql);	
		$id = $this->db->get_last_inserted_id();
		if(isset($post['fk_user_id'])) $this->update_user_id($id, $post['fk_user_id']);

		return array(
			'id'     => $id,
			'result' => $result
		);
	}

	public function update_user_id($id, $user_id)
	{
		$sql = "UPDATE ".$this->get_tablename()." SET fk_user_id = ".intval($user_id)." WHERE id = ".intval($id);
		return $this->db->update($sql);
	}
	
	public function get_verlinkung($id, $typ)
	{
		if($typ == 'angebot') return '<a class="a_link" href="'.$this->url->get_angebot_bearbeiten($id).'">Angebot</a>';
	}

	public function delete($id)
    {
        $sql = "DELETE FROM ".$this->get_tablename()." WHERE id = ".intval($id);
        $result = $this->db->delete($sql);

        return $result;
	}
		
}