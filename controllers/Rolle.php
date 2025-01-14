<?php

class Rolle {
	
	private $db;
	private $helper;
	
	private $fields;
	private $tablename;
	
	public function __construct($db, $helper) 
	{
		
		$this->db     = $db;
		$this->helper = $helper;
		
		$this->set_tablename();
		$this->set_fields();
	}
	
	public function set_fields() 
	{
		$this->fields = "
			".$this->get_tablename().".id          AS 'rolle_id', 
			".$this->get_tablename().".name        AS 'name'
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'rolle';
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
			FROM ".$this->get_tablename();
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
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
			'".$values["name"]."',
			''
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
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				name = '".$values['name']."'
		WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);
		return $this->db->update($sql);	
			
	}

		/**
		update all
		@var: post array
	**/
	
	public function update_all($post) 
	{
		foreach($post['ids'] AS $id) {
			$this->update(array(
				$this->get_tablename().'_id'  => $id,
				'name'                        => $post['name_'.$id]
			));
		}
	}


		
}