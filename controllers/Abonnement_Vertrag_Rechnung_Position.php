<?php

class Abonnement_Vertrag_Rechnung_Position { 
	
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
		$this->set_joins($this->get_tablename());

		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                                    AS 'abonnement_vertrag_rechnung_position_id', 
			".$tablename.".fk_abonnement_vertrag_rechnung_id     AS 'fk_abonnement_vertrag_rechnung_id', 
			".$tablename.".fk_abonnement_vertrag_id              AS 'fk_abonnement_vertrag_id',
			abonnement_vertrag_rechnung.id                       AS 'abonnement_vertrag_rechnung_id',
			abonnement_vertrag_rechnung.angelegt_am              AS 'abonnement_vertrag_rechnung_angelegt_am'
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'abonnement_vertrag_rechnung_position';
	}
	
	public function set_joins($tablename) 
	{
		$this->joins = "
			INNER JOIN abonnement_vertrag_rechnung ON abonnement_vertrag_rechnung.id = ".$tablename.".fk_abonnement_vertrag_rechnung_id
		";
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
			WHERE ".$this->get_tablename().".id = ".intval($id);

		$row = $this->format_row($this->db->get($sql));
		return $row;
	}	
	
	/**
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all($abonnement_vertrag_rechnung_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".id > 0
			AND ".$this->get_tablename().".fk_abonnement_vertrag_rechnung_id = ".intval($abonnement_vertrag_rechnung_id);
			
		return $this->db->get_all($sql);
	}

	public function get_letzte_rechnung($abonnement_vertrag_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".id > 0
			AND ".$this->get_tablename().".fk_abonnement_vertrag_id = ".intval($abonnement_vertrag_id)."
			ORDER BY abonnement_vertrag_rechnung.angelegt_am DESC LIMIT 1";

		return $this->db->get($sql);
	}

    public function insert_all($abonnement_vertrag_rechnung_id, $vertraege)
    {
        if(is_array($vertraege) == false) return;
        if($vertraege == null) return;

        foreach($vertraege AS $vertrag) {
            $this->insert($abonnement_vertrag_rechnung_id, $vertrag['abonnement_vertrag_id']);
        }
    }

	
	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($abonnement_vertrag_rechnung_id, $abonnement_vertrag_id) 
	{

		$date = $this->helper->get_english_datetime_now();

		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
				NULL, 
				".intval($abonnement_vertrag_rechnung_id).",
				".intval($abonnement_vertrag_id)."
			)";
	
		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();
		
		return array(
			'id'     => $id,
			'result' => $result_insert
		);
	}
 

	

		
}