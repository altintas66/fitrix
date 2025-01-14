<?php 

class Datei {
    
    private $db;
    private $helper;
    private $datei_zuweisung;
    
    private $fields;
    private $tablename;

    public function __construct($db, $helper, $datei_zuweisung) 
    {
        $this->db              = $db;
        $this->helper          = $helper;
        $this->datei_zuweisung = $datei_zuweisung;
        
        $this->set_tablename();
        $this->set_fields();
    }

    public function set_fields() 
    {
        
        $this->fields = "
            id              AS 'datei_id', 
            pfad            AS 'pfad', 
            dateiname       AS 'dateiname', 
            description     AS 'description', 
        ";
    }

    public function set_tablename() 
	{
		$this->tablename = 'datei';
	}

    public function get_fields()
	{
		return $this->fields;
	}
	
	public function get_tablename()
	{
		return $this->tablename;
	}

    public function insert($typ, $pfad, $dateiname, $id) 
    {
        
        $sql = "
            INSERT INTO 
            ".$this->get_tablename()." VALUES (
                NULL,
                '".$pfad."', 
                '".$dateiname."', 
                ''
            )
        ";

        $result = $this->db->insert($sql);
        
        $datei_id = $this->db->get_last_inserted_id();
         
        $this->datei_zuweisung->insert(
            $typ, 
            $id, 
            $datei_id
        );
        
        return $datei_id;
    }

    public function get($id) 
    {
        $sql = "SELECT 
            pfad, 
            dateiname 
            FROM ".$this->get_tablename()." 
            WHERE id = ".intval($id);

		return $this->db->get($sql);
    }

    public function delete($id) 
    {
       
        $datei = $this->get($id);
		if($datei != NULL) {
		    $file_path = $datei['pfad'].$datei['dateiname'];
		    if (file_exists($file_path)) unlink($file_path);
		}

        $this->datei_zuweisung->delete($id);
	  
		$sql = "DELETE FROM ".$this->get_tablename()." WHERE id = $id";
		$result = $this->db->delete($sql);
		
        if ($result) return 'success';
		else return 'error';
	}

    public function update_description($id, $description)
    {
		$sql = "UPDATE ".$this->get_tablename()." SET 
            description = '".$description."' 
            WHERE id = ".$id;
		
        return $this->db->update($sql);
	}


}