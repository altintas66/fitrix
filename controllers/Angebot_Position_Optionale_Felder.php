<?php

class Angebot_Position_Optionale_Felder {
	
	private $db;
	private $helper;
	private $aktive_module;
	
	private $fields;
	private $tablename;
	
	public function __construct($db, $helper, $aktive_module) 
	{
		
		$this->db            = $db;
		$this->helper        = $helper;
		$this->aktive_module = $aktive_module;
		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                        AS 'angebot_position_optionale_felder', 
            ".$tablename.".fk_angebot_position_id    AS 'fk_angebot_position_id', 
            ".$tablename.".fahrzeug_marke            AS 'fahrzeug_marke', 
            ".$tablename.".fahrzeug_modell           AS 'fahrzeug_modell', 
            ".$tablename.".fahrzeug_kennzeichen      AS 'fahrzeug_kennzeichen', 
            ".$tablename.".fahrzeug_fin              AS 'fahrzeug_fin',
			".$tablename."teppichreinigung_laenge    AS 'teppichreinigung_laenge',
			".$tablename."teppichreinigung_breite    AS 'teppichreinigung_breite'
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'angebot_position_optionale_felder';
	}

	public function get_fields()
	{
		return $this->fields;
	}
	
	public function get_tablename()
	{
		return $this->tablename;
	}

	public function check_optionale_felder()
	{
		$check = false;

		if(isset($this->aktive_module['lackierer_kfz'])) $check = true;

		return $check;
	}
	
	/**
		Get by id
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get($angebot_position_id) 
	{
	
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".fk_angebot_position_id = ".intval($angebot_position_id);

		return $this->db->get($sql);
	}	

	public function insert_update($post, $id) 
	{
		if($this->check_optionale_felder() == false) return;

		$exist = $this->get($id);

		if($exist == null) $this->insert($post, $id);
		else $this->update($post, $id);

	}
	

	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($post, $angebot_position_id) 
	{

		$values = $this->helper->escape_values($post);
		
        $sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
            ".intval($angebot_position_id).",
			'".$values["fahrzeug_marke"]."',
			'".$values["fahrzeug_modell"]."',
            '".$values["fahrzeug_kennzeichen"]."',
            '".$values["fahrzeug_fin"]."'
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

		$values = $this->helper->escape_values($post, $angebot_position_id);
        
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				fahrzeug_marke           = '".$values['fahrzeug_marke']."',
				fahrzeug_modell          = '".$values['fahrzeug_modell']."',
                fahrzeug_kennzeichen     = '".$values['fahrzeug_kennzeichen']."',
                fahrzeug_fin             = '".$values['fahrzeug_fin']."'
		WHERE fk_angebot_position_id = ".intval($angebot_position_id);

		return $this->db->update($sql);	
	}


		
}