<?php

class Modul {
	
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
			".$tablename.".id             AS 'modul_id', 
            ".$tablename.".name           AS 'name', 
            ".$tablename.".bezeichnung    AS 'bezeichnung', 
            ".$tablename.".status         AS 'status' 
           
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'modul';
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
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all($status = '') 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename();
		$rows =  $this->db->get_all($sql);
        $result = array();

        foreach($rows AS $row) {
            $result[$row['name']] = $row;
        }

        return $result;
	}



		
}