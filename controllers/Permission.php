<?php

class Permission {
	
	private $db;
	private $helper;
	
	private $fields;
	private $tablename;
	
	public function __construct($db, $helper) 
    {
		$this->db     = $db;
		$this->helper = $helper;

        $this->set_tablename();
	}

    public function set_tablename() {
        $this->tablename = 'permission';
    }

    public function get_tablename() {
        return $this->tablename;
    }

    public function check_user_permission($rolle_id, $permission)
    {
        return $this->check_rolle_permission($rolle_id, $permission);
    }

    public function check_user_permission_redirect($permission)
    {
        global $_SESSION, $c_helper;
    
        if(!$this->check_user_permission($_SESSION['rolle_id'], $permission)) {
            $this->redirect('index.php');
        } 
    }

    public function check_user_has_permission($permission) {
        if($this->check_user_permission($_SESSION['rolle_id'], $permission)) return true;
        else return false;
    }

    public function redirect($url) {
        $this->helper->redirect($url, 'Nicht+authorisierter+Zugriff&type=danger');
        die();
    }
    
    public function check_rolle_permission($rolle_id, $permission)
    {
        $sql = "SELECT EXISTS (
            SELECT 1
            FROM ".$this->get_tablename()."
            INNER JOIN permission_rolle_zuweisung ON permission.id = permission_rolle_zuweisung.fk_permission_id
            INNER JOIN rolle ON rolle.id = permission_rolle_zuweisung.fk_rolle_id
            WHERE rolle.id = ".$rolle_id."
            AND permission.permission = '".$permission."'
          ) AS has_permission;";
     
          $result = $this->db->get($sql);
          if($result['has_permission']) return true;
          else return false;
        

    }

    public function get_permissions(){
        $sql = "SELECT 
            id            AS 'id', 
            permission    AS 'permission', 
            label         AS 'label'
        FROM ".$this->get_tablename();
        $result = $this->db->get_all($sql);
        return $result;
    }

    public function set_permission($permission_id, $rolle_id, $value)
    {
        if($value == 'true') {
            $sql = "
                INSERT INTO 
                permission_rolle_zuweisung VALUES (
                    NULL, 
                    ".$rolle_id.", 
                    ".$permission_id."
                )";
            $result = $this->db->insert($sql);
            return $result;

        } else {   
            $sql = "
                DELETE FROM 
                permission_rolle_zuweisung
                WHERE fk_rolle_id = ".$rolle_id." 
                AND fk_permission_id =  ".$permission_id;
            
            $result = $this->db->delete($sql);
            return $result;
        }
    }

  


}
?>
