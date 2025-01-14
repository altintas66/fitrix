<?php

class Artikel_Kategorie { 
	
	private $db;
	private $helper;
	
	private $fields;
	private $tablename;


	
	public function __construct($db, $helper) 
	{
		
		$this->db                 = $db;
		$this->helper             = $helper;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                           AS 'artikel_kategorie_id', 
			".$tablename.".fk_artikel_id                AS 'fk_artikel_id',
			".$tablename.".fk_kategorie_id              AS 'fk_kategorie_id'
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'artikel_kategorie';
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

		$row = $this->format_row($this->db->get($sql));
		return $row;
	}	
	
	/**
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all($artikel_id = null) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".id > 0";
        if($artikel_id != null) $sql .= " AND ".$this->get_tablename().".fk_artikel_id = ".intval($artikel_id);
	
		return $this->db->get_all($sql);
	}

	
	/**
		insert
		@var: post array
		@return: int id
	**/

    public function insert_all($kategorien, $artikel_id)
    {
        if($kategorien == null) return;
        if(is_array($kategorien) == false) return;
        if($artikel_id == null) return;
        
        $this->delete($artikel_id);

        foreach($kategorien AS $kategorie_id) {
            $this->insert(array(
                'artikel_id'   => $artikel_id,
                'kategorie_id' => $kategorie_id
            ));
        }
    }
	
	public function insert($post) 
	{

		$values   = $this->helper->escape_values($post);

		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
				NULL, 
				".intval($values['artikel_id']).",
				".intval($values['kategorie_id'])."
			)";
	

		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();
		
		return array(
			'id'     => $id,
			'result' => $result_insert
		);
	}
 

	public function delete($artikel_id) 
    {
        $sql = "DELETE FROM ".$this->get_tablename()." WHERE fk_artikel_id = ".intval($artikel_id);
        return $this->db->delete($sql);
    }

	


		
}