<?php 


class Database 
{ 
	
	private $link;

	public function __construct($link)
	{
		$this->link = $link;

	}
	
	/**
		Datensatz in die Datenbank einfügen und den Wert des Primärschlüssels zurück geben
		@var: sql string
	**/
	
	public function insert($sql) 
	{
		global $c_email;
		$query = mysqli_query($this->link, $sql);
		if(mysqli_affected_rows($this->link) != 1) {
			$c_email->administrator_email('Fehler in SQL Insert. SQL Query: '.$sql);
			return false;
		}
		$id = mysqli_insert_id($this->link);
		return $id;
	}
	
	/**
		Datensatz in der Datenbank updaten. Gibt true oder false zurück, je nachdem ob der Update erfolgreich war
		@var: sql string
	**/
	
	public function update($sql) 
	{ 
		global $c_email;
		$query = mysqli_query($this->link, $sql);
		if($query == false) {
			$c_email->administrator_email('Fehler in SQL Update. SQL Query: '.$sql);
			return false;
		}
		return $query;
	}
	
	/**
		Datensatz in der Datenbank löschen. Gibt true oder false zurück, je nachdem ob die Löschung erfolgreich war
		@var: sql string
	**/
	
	public function delete($sql) 
	{ 
		$query = mysqli_query($this->link, $sql);
		return $query;
	}
	
	/**
		Ein Datensatz in der Datenbank erhalten
		@var: sql string
	**/
	
	public function get($sql) 
	{ 
		$query = mysqli_query($this->link, $sql);
		if($query == false) return NULL;
		return mysqli_fetch_assoc($query);
	}
	
	/**
		Alle Datensätze in der Datenbank erhalten
		@var: sql string
	**/
	
	public function get_all($sql) 
	{ 
		$query = mysqli_query($this->link, $sql);		
		if($query == false) return NULL;
		
		if(mysqli_num_rows($query) > 0) {
			$rows = array();
			while($row = mysqli_fetch_assoc($query)) {
				array_push($rows, $row);
			}
			return $rows;
		} else {
			return NULL;
		}
	}
	
	/**
		Alle Datensätze in der Datenbank erhalten, jedoch als Key Value Wert speichern
		@var: sql string
	**/
	
	public function get_all_by_key($sql, $key, $value) 
	{ 
		$query = mysqli_query($this->link, $sql);		
		if($query == false) return NULL;
		
		if(mysqli_num_rows($query) > 0) {
			$rows = array();
			while($row = mysqli_fetch_assoc($query)) {
				$rows[$row[$key]] = $row[$value];
			}
			return $rows;
		} else {
			return NULL;
		}
	}
	
	/**
		Escaping
		@var: array $post
	**/
	
	public function escape_values($post) 
	{
		if(!is_array($post)) return false;
        $escaped = array();
		foreach($post AS $key => $value) $escaped[$key] = $this->escape($value);
		return $escaped;
	}
	
	/**
		Escaping
		@var: string $value
	**/
	
	public function escape($value) 
	{ 
		if(is_array($value)) return $value;
		return addslashes(mysqli_real_escape_string($this->link, $value));
	}

    public function get_last_inserted_id() {
        return mysqli_insert_id($this->link);
    }
	

}