<?php

class PLZ_Ort_Suche {
	
	private $db;
	private $helper;
    private $api;
    private $ort;
	
	private $fields;
	private $tablename;
	
	public function __construct($db, $helper, $api, $ort) 
	{
		$this->db     = $db;
		$this->helper = $helper;
        $this->api    = $api;
        $this->ort    = $ort;
		
		$this->set_tablename();
		$this->set_fields();
	}
	
	public function set_fields() 
	{
		$this->fields = "
			".$this->get_tablename().".id                 AS 'plz_ort_suche_id', 
			".$this->get_tablename().".angelegt_am        AS 'angelegt_am',
			".$this->get_tablename().".suchbegriff_plz    AS 'suchbegriff_plz', 
			".$this->get_tablename().".fk_ort_id          AS 'fk_ort_id'
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'plz_ort_suche';
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
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all() 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename(). " 
			ORDER BY ".$this->get_tablename().".angelegt_am DESC";
		return $this->db->get_all($sql);
	}
	
	/**
		Get by id
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get($suchbegriff_plz) 
	{


		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE suchbegriff_plz = '".$suchbegriff_plz."'";
		return $this->db->get($sql);
	}

    /**
		Get by id
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_by_ort_id($ort_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE fk_ort_id = ".intval($ort_id);
		return $this->db->get_all($sql);
	}

	public function get_by_plz($plz, $ort_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".suchbegriff_plz = '".$plz."'
			AND ".$this->get_tablename().".fk_ort_id = '".$ort_id."'";
		
		return $this->db->get($sql);
	}

	
	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($post) 
	{

		
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
			'".date('Y-m-d H:i:s')."', 
			'".$post["suchbegriff_plz"]."', 
            ".$post["fk_ort_id"]."
		)";
     
		
		$result = $this->db->insert($sql);	
		$id = $this->db->get_last_inserted_id();


		return array(
			'id'     => $id,
			'result' => $result
		);
	}
	
    
    public function get_ort_by_api($plz) 
    {

        //Suche in unserer Zwischentabelle, ob wir die Suche bereits in der Datenbank haben
        $suche = $this->get($plz);

        if($suche == NULL) {
            $api_url = $this->api->get_api_url_plz();

            $ort_hinzugefuegt = false;

            $response = $this->api->get_response(
                $api_url.'?postalCode='.$plz
            );  

            $api_ort_name = $response[0]['name'];
            $ort_obj = $this->ort->get_by_name($api_ort_name);

            if($ort_obj == NULL) {
                $ort_insert = $this->ort->insert(array(
                    'ortsname' => $api_ort_name
                ));
                $ort_id = $ort_insert['id'];
            } else {
                $ort_id = $ort_obj['ort_id'];
            }
            
            if($response != NULL) {
                $this->insert(array(
                    'suchbegriff_plz'  => $plz,
                    'fk_ort_id'        => $ort_id
                ));
                $ort_hinzugefuegt = true;
            }
            return array(
                'ort_name'         => $api_ort_name,
                'ort_hinzugefuegt' => $ort_hinzugefuegt
            );
        
        } else {
            $ort_id = $suche['fk_ort_id']; 
            $ort_obj = $this->ort->get($ort_id);  
            
            return array(
                'ort_name'          => $ort_obj['ortsname'],
                'ort_hinzugefuegt'  => false
            );
        }


        
    }   
	
		
}