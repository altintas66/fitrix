<?php

class User { 
	
	private $db;
	private $helper;
	
	private $fields;
	private $joins;
	private $tablename;


	private $inhalt;
	private $placeholder;
	private $einstellungen;
	
	public function __construct($db, $helper, $inhalt, $placeholder, $einstellungen) 
	{
	
		
		$this->db             = $db;
		$this->helper         = $helper;
		$this->einstellungen  = $einstellungen;
		$this->inhalt         = $inhalt;
		$this->placeholder    = $placeholder;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		$this->set_joins();
		
	}
	
	public function set_fields($tablename) 
	{

		$this->fields = "
			".$tablename.".id                             AS 'user_id', 
			".$tablename.".fk_rolle_id                    AS 'fk_rolle_id', 
			".$tablename.".angelegt_am                    AS 'angelegt_am', 
			".$tablename.".foto                           AS 'foto', 
			".$tablename.".letzter_login                  AS 'letzter_login', 
			".$tablename.".username                       AS 'username', 
			".$tablename.".geschlecht                     AS 'geschlecht', 
			".$tablename.".vorname                        AS 'vorname', 
			".$tablename.".nachname                       AS 'nachname', 
			".$tablename.".email                          AS 'email', 
			".$tablename.".mobil                          AS 'mobil', 
			".$tablename.".passwort                       AS 'passwort', 
			".$tablename.".bemerkung                      AS 'bemerkung',
			".$tablename.".menue_toggle                   AS 'menue_toggle',
			".$tablename.".theme_mode                     AS 'theme_mode',
			".$tablename.".status                         AS 'status',
			rolle.id                                      AS 'rolle_id',
			rolle.name                                    AS 'rolle'
		";
	}

	public function set_joins() 
	{
		$this->joins = "
			INNER JOIN rolle ON rolle.id = user.fk_rolle_id
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'user';
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

	public function get_letzte_user() 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			ORDER BY letzter_login DESC
			LIMIT 3";
		
		return $this->db->get_all($sql);
	}
	
	/**
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all($status = '') 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins().
			" WHERE ".$this->get_tablename().".id > 0";
			
		if(($status == 'aktiv') || ($status == 'deaktiv')) $sql .= " AND ".$this->get_tablename().".status = '".$status."'";
		
		return $this->db->get_all($sql);
	}

	public function get_all_by_rolle($rolle_id, $status = '') 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".fk_rolle_id = ".intval($rolle_id);
			
		if(($status == 'aktiv') || ($status == 'deaktiv')) $sql .= " WHERE ".$this->get_tablename().".status = '".$status."'";
		
		return $this->db->get_all($sql);
	}
	

	/**
		Get user by login
		@var: String email
		@var: String passwort
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_user_by_login(String $username, String $passwort) 
	{

		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE username = '".$username."' 
			AND passwort = '".$passwort."'";
	
		return $this->db->get($sql);
		
	}	

	/**
		Get by email
		@var: String email
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_by_email($email) 
	{

		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE email = '".$email."'";
		return $this->db->get($sql);

	}

	/**
		Get by username
		@var: String email
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_by_username($username) 
	{

		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE username = '".$username."'";
		return $this->db->get($sql);

	}
	
	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($post, $files) 
	{

		$values   = $this->helper->escape_values($post);
		$passwort = $this->helper->get_random_passwort();
		$date     = $this->helper->get_english_datetime_now();

		$user = $this->get_by_username($values["email"]);
		if($user != NULL) return false;

		$username = $this->get_username($values['vorname'], $values['nachname']);
	
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
				NULL, 
				".intval($values['rolle_id']).",
				'".$date."',
				'".$date."',
				NULL,
				'',
				'".$username."',
				'".$values["geschlecht"]."', 
				'".$values["vorname"]."', 
				'".$values["nachname"]."', 
				'".$values["email"]."', 
				'".$values["mobil"]."', 
				'".$passwort."', 
				'".$values["bemerkung"]."',
				'0',
				'light',
				'aktiv'
			)";
	

		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();
		$values['user_id'] = $id;

		if($files['foto'] != '') $this->update_foto($values, $files);

		
		return array(
			'id'     => $id,
			'result' => $result_insert
		);
	}
 

	/**
		update passswort
		@var: array post
		return true false
	**/

	public function update_passwort($id, $passwort) 
	{
		
		$sql = "UPDATE ".$this->get_tablename()." SET 
			passwort = '".$passwort."' 
			WHERE ".$this->get_tablename().".id = ".intval($id);

		return $this->db->update($sql);
	}
	
	/**
		update letzter login
		@var: int id
	**/
	
	public function update_letzter_login(int $id) 
	{
		$now = date("Y-m-d H:i:s");
		$sql = "UPDATE ".$this->get_tablename()." SET letzter_login = '$now' WHERE id = ".intval($id);
		return $this->db->update($sql);
	}	
	
	/**
		update
		@var: post array
	**/
	
	public function update($post, $files) 
	{
		$values = $this->helper->escape_values($post);
		
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				fk_rolle_id              = ".intval($values['rolle_id']).",
				username                 = '".$this->get_username($values['vorname'], $values['nachname'])."',
				geschlecht               = '".$values['geschlecht']."',
				vorname                  = '".$values['vorname']."',
				nachname                 = '".$values['nachname']."',
				email                    = '".$values['email']."',
				mobil                    = '".$values['mobil']."',
				bemerkung                = '".$values['bemerkung']."'
		WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);
		
		if($files['foto'] != '') $this->update_foto($values, $files);
	
		return $this->db->update($sql);
	}

	public function update_foto($post, $files) 
	{
		$result = $this->helper->upload_foto($files, 'foto');
		if($result['result'] == false) return;

		$sql = "UPDATE ".$this->get_tablename()." SET 
					foto = '".$result['dateiname']."' 
				WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);
		return $this->db->update($sql);
	}

	public function update_menue_toggle($value) 
	{
		session_start();
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				menue_toggle           = '".$value."'
		WHERE id = ".intval($_SESSION['id']);
		return $this->db->update($sql);
	}

	public function update_dark_mode($value) 
	{
		session_start();
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
			dark_mode           = '".$value."'
		WHERE id = ".intval($_SESSION['id']);
		$_SESSION['dark_mode'] = $value;
		return $this->db->update($sql);
	}


	public function neues_passwort_generieren($id) 
	{
		$neues_passwort = $this->helper->get_random_passwort(10);
		
		$sql = "UPDATE ".$this->get_tablename()." SET 
					passwort = '".$neues_passwort."' 
				WHERE ".$this->get_tablename().".id = ".intval($id);
		
		return array(
			'result'         => $this->db->update($sql), 
			'neues_passwort' => $neues_passwort
		);
	}
 

	public function format_row($row) 
	{
		if($row == NULL) return $row;
		if((isset($row['vorname'])) && ($row['nachname'])) {
			$row['name']          = $row['vorname'].' '.$row['nachname'];
		}
		return $row;
	}

	public function get_username($vorname, $nachname) 
	{
		$username = strtolower($vorname.'.'.$nachname);
		$ersetzen = array(
			'ä' => 'ae', 
			'Ä' => 'ae', 
			'ü' => 'ue', 
			'Ü' => 'ue', 
			'ö' => 'oe', 
			'Ö' => 'oe', 
			'ß' => 'ss'
		);
		
		foreach($ersetzen AS $key => $value) {
			$username   = str_replace($key, $value, $username);
		}

		return $username;
	}
	
	public function passwort_zusenden($user)
	{
		global $c_email;

		$result = $this->neues_passwort_generieren($user['user_id']);

		$inhalt_vorlage = $this->inhalt->get_by_metakey('email_passwort_zuruecksetzen_inhalt');
		
		$inhalt = $this->placeholder->replace_placeholders_email_benachrichtigung_passwort_zusenden(
			$inhalt_vorlage['metavalue'],
			$user,
			$result['neues_passwort']
		);


		$c_email->neues_passwort_zusenden($inhalt, $user);
		return true;
	}

	public function get_foto_url($user) 
	{

		if($user['foto'] == '') {
			if($user['geschlecht'] == 'Weiblich') return $this->einstellungen['user_avatar_weiblich'];
			else return $this->einstellungen['user_avatar_maennlich'];
		} else {
			return $this->helper->get_upload_path($user['foto']);
		}

	}

	public function update_theme_mode($id, $theme_mode) 
	{
		$sql = "UPDATE ".$this->get_tablename()." SET theme_mode = '".$theme_mode."' WHERE id = ".intval($id);
		return $this->db->update($sql);
	}

		
}