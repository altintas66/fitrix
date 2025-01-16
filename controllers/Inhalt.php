<?php

class Inhalt {
	
	private $db;
	private $helper;
	
	private $fields;
	private $metakeys;
	private $tablename; 
	
	public function __construct($db, $helper) 
	{
		
		$this->db     = $db;
		$this->helper = $helper;
		
		$this->set_tablename();
		$this->set_fields();
		$this->set_metakeys();
		
	}
	
	public function set_fields() 
	{
		$this->fields = "
			".$this->get_tablename().".id           AS 'inhalt_id', 
			".$this->get_tablename().".metakey      AS 'metakey', 
			".$this->get_tablename().".metavalue    AS 'metavalue',
			".$this->get_tablename().".bezeichnung  AS 'bezeichnung',
			".$this->get_tablename().".betreff      AS 'betreff',
			".$this->get_tablename().".bemerkung    AS 'bemerkung'
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'inhalt';
	}

	public function set_metakeys() 
	{
		$rows = $this->get_all();
		$metakeys = array();
		foreach($rows AS $row) {
			array_push($metakeys, $row['metakey']);
		}
		$this->metakeys = $metakeys;
	}
	
	public function get_fields()
	{
		return $this->fields;
	}

	public function get_metakeys()
	{
		return $this->metakeys;
	}
	
	public function get_tablename()
	{
		return $this->tablename;
	}	
	
	/**
		Update Cache
	**/
	
	private function update_cache() 
	{
		global $c_cache;
		//$c_cache->set_inhalte();
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
			FROM ".$this->get_tablename();
		return $this->db->get_all($sql);
	}
	 
	/**
		Get by metakey
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_by_metakey($metakey) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE metakey = '".$metakey."'";
		return $this->db->get($sql);
	}	

	
	/**
		update
		@var: post array
	**/
	
	public function update($metakey, $metavalue) 
	{
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				metavalue = '".$metavalue."'
		WHERE metakey = '".$metakey."'";
	

		$result = $this->db->update($sql);	


		return $result;
	}

	/**
		update
		@var: post array
	**/
	
	public function update_all($inhalte) 
	{
		foreach($this->get_metakeys() AS $metakey) {
			$this->update($metakey, $_POST[$metakey]);
		}
		return true;
	}

	public function textarea_value_to_html($text) 
	{
		$text   = str_replace("\\r\\n", '<br>', $text);
		$text   = str_replace("\r\n", '<br>', $text);

		return $text;
	}

	public function textarea_value_to_whatsapp_format($text) 
	{
		
		$text   = str_replace("\\r", '\\n', $text);
		$text   = str_replace("\r", '\n', $text);

		return $text;
	}

	
		
}
