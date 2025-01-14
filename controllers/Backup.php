<?php

class Backup {
	
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
			".$tablename.".id                        AS 'backup_id', 
			".$tablename.".fk_user_id                AS 'fk_user_id', 
			".$tablename.".erstellt_am               AS 'erstellt_am', 
			".$tablename.".dateiname                 AS 'dateiname'

		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'backup';
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
		Get all
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_all() 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename().
			" ORDER BY erstellt_am DESC";

		return $this->db->get_all($sql);
	}

	
	/**
		insert
		@var: post array
		@return: array(int id & result (true | false))
	**/
	
	public function insert($dateiname) 
	{

        $datum   = $this->helper->get_english_datetime_now();
		session_start();
		
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
            ".intval($_SESSION['id']).",
			'".$datum."',
			'".$dateiname."'
		)";

		$result = $this->db->insert($sql);	
		$id = $this->db->get_last_inserted_id();

		return array(
			'id'     => $id,
			'result' => $result
		);
	}
	


	/**
		Delete $id
		@var: post array
		@return: true | false
	**/

	public function delete($id) 
	{
		$sql =" DELETE FROM ".$this->get_tablename()."  
		WHERE ".$this->get_tablename().".id = ".intval($id);

		$this->delete_file($id);

		$result = $this->db->delete($sql);

		return $result;
	}

	public function delete_file($id)
	{
		$backup = $this->get($id);
		$dateipfad = dirname(__FILE__). '/../backup/' .$backup['dateiname'];
		
		unlink($dateipfad);
	}

    public function create_backup() 
    {
		global $db_con;
		
		// Backup file path
		$dateiname = 'backup_' . date('d.m.Y_H:i:s') . '.sql';
		$backupFile = dirname(__FILE__). '/../backup/' .$dateiname;
		
		// Command to execute mysqldump
		$command = "mysqldump --user=".$db_con['user']." --password=".$db_con['passwort']." --host=".$db_con['host']." ".$db_con['database']." > $backupFile";
		
		// Execute the command
		exec($command, $output, $result);
		
		// Check if the command was successful
		if ($result === 0) {
			$this->insert($dateiname);
			return $backupFile;
		} else {
			return false;
		}

    }


		
}