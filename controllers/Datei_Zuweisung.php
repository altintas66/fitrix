<?php 

class Datei_Zuweisung {
    
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
            id              AS 'datei_zuweisung_id', 
            fk_eintrag_id   AS 'fk_eintrag_id', 
            fk_datei_id     AS 'fk_datei_id', 
            typ             AS 'typ', 
        ";
    }

    public function set_tablename() 
	{
		$this->tablename = 'datei_zuweisung';
	}

    public function get_fields()
	{
		return $this->fields;
	}
	
	public function get_tablename()
	{
		return $this->tablename;
	}

    public function insert($typ, $eintrag_id, $datei_id) 
    {
        $sql = "
            INSERT INTO ".$this->get_tablename()." VALUES (
                NULL,
                ".$eintrag_id.",
                ".$datei_id.",
                '".$typ."'
            )
        ";
     

        return $this->db->insert($sql);
    }

    public function delete($id) 
    {
        $sql = "DELETE FROM ".$this->get_tablename()." 
        WHERE fk_datei_id = ".intval($id);
		return $this->db->delete($sql);
    }

    public function get_all($typ, $eintrag_id) 
    {
        global $c_datei;
        $sql = "
            SELECT 
                ".$c_datei->get_tablename().".pfad, 
                ".$c_datei->get_tablename().".dateiname, 
                ".$c_datei->get_tablename().".id, 
                ".$c_datei->get_tablename().".description
            FROM ".$c_datei->get_tablename()." 
            INNER JOIN datei_zuweisung ON ".$c_datei->get_tablename().".id = fk_datei_id
            WHERE fk_eintrag_id = ".intval($eintrag_id).
            " AND typ = '".$typ."'";
      
        return $this->db->get_all($sql);
    }
    

    


}