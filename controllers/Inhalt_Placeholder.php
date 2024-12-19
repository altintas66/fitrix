<?php 


class Inhalt_Placeholder {

    private $db;
    private $helper;
    
    private $fields;
    private $joins;
    private $tablename; 


    public function __construct($c_db, $helper) 
    {
        $this->db     = $c_db;
        $this->helper = $helper;

        $this->set_tablename();
        $this->set_fields();
        $this->set_joins(); 
    }

    public function set_fields() 
    {
        global $c_placeholder;

        $this->fields = "
            ".$this->get_tablename().".fk_inhalt_id           AS 'fk_inhalt_id', 
            ".$this->get_tablename().".fk_placeholder_id      AS 'fk_placeholder_id',
            ".$c_placeholder->get_tablename().".placeholder   AS 'placeholder'
        ";
    }

    public function set_tablename() 
	{
		$this->tablename = 'inhalt_placeholder';
	}

    public function set_joins() 
	{
		
		global $c_placeholder;
		
		$this->joins = "
            INNER JOIN ".$c_placeholder->get_tablename()." ON ".$c_placeholder->get_tablename().".id = fk_placeholder_id";
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
		Get all
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_all($inhalt_id) 
	{
	
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
            ".$this->get_joins()."
            WHERE fk_inhalt_id = ".intval($inhalt_id);
		
        return $this->db->get_all($sql);
	}

}