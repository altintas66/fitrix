<?php

class Artikel { 
	
	private $db;
	private $helper;
	private $artikel_preis;
	private $artikel_kategorie;
	private $einstellungen;
	
	private $fields;
	private $joins;
	private $tablename;


	
	public function __construct($db, $helper, $artikel_preis, $artikel_kategorie, $einstellungen) 
	{
		
		$this->db                 = $db;
		$this->helper             = $helper;
		$this->artikel_preis      = $artikel_preis;
		$this->artikel_kategorie  = $artikel_kategorie;
		$this->einstellungen      = $einstellungen;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		$this->set_joins($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                                  AS 'artikel_id', 
			".$tablename.".fk_user_id                          AS 'fk_user_id', 
			".$tablename.".fk_artikel_typ_id                   AS 'fk_artikel_typ_id', 
			".$tablename.".fk_einheit_id                       AS 'fk_einheit_id', 
			".$tablename.".fk_zyklus_id                        AS 'fk_zyklus_id', 
			".$tablename.".angelegt_am                         AS 'angelegt_am', 
			".$tablename.".bearbeitet_am                       AS 'bearbeitet_am', 
			".$tablename.".foto                                AS 'foto', 
			".$tablename.".artikel_nummer                      AS 'artikel_nummer', 
			".$tablename.".quality_hosting_product_id          AS 'quality_hosting_product_id', 
			".$tablename.".artikel_name                        AS 'artikel_name', 
			".$tablename.".einkaufspreis                       AS 'einkaufspreis', 
			".$tablename.".vertragslaufzeit                    AS 'vertragslaufzeit', 
			".$tablename.".vertragslaufzeit_monate             AS 'vertragslaufzeit_monate', 
			".$tablename.".vertragslaufzeit_kuendigungsfrist   AS 'vertragslaufzeit_kuendigungsfrist', 
			".$tablename.".einrichtungsgebuehr                 AS 'einrichtungsgebuehr', 
			".$tablename.".artikel_beschreibung                AS 'artikel_beschreibung', 
			".$tablename.".artikel_beschreibung_angebot        AS 'artikel_beschreibung_angebot', 
			".$tablename.".preis                               AS 'preis', 
			".$tablename.".status                              AS 'status',
			user.id                                            AS 'user_id',
			user.username                                      AS 'user_username',
			artikel_typ.bezeichnung                            AS 'artikel_typ',
            einheit.bezeichnung                                AS 'einheit',
			zyklus.bezeichnung                                 AS 'zyklus'
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'artikel';
	}

	public function set_joins($tablename) 
	{
		$this->joins = "
			INNER JOIN user ON user.id = ".$tablename.".fk_user_id
			INNER JOIN artikel_typ ON artikel_typ.id = ".$tablename.".fk_artikel_typ_id
            INNER JOIN einheit ON einheit.id = ".$tablename.".fk_einheit_id
			INNER JOIN zyklus ON zyklus.id = ".$tablename.".fk_zyklus_id
			LEFT JOIN artikel_kategorie ON artikel_kategorie.fk_artikel_id = ".$tablename.".id
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

	public function get_status()
	{
		return array(
			'aktiv'      => array('label' => 'Aktiv', 'class' => 'btn btn-green'),
			'deaktiv'    => array('label' => 'Deaktiv', 'class' => 'btn btn-danger')
		);
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

		$row = $this->add_fields($this->db->get($sql));
		return $row;
	}	

	/**
		Get by artikel nummer
		@var: string artikel_nummer
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_by_artikel_nummer($artikel_nummer) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE artikel_nummer = ".intval($artikel_nummer);

		$row = $this->add_fields($this->db->get($sql));
		return $row;
	}
	
	/**
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	
	public function get_all($status = '', $kategorie_id = null) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".id > 0";
			
		if($status != '') $sql .= " AND ".$this->get_tablename().".status = '".$status."'";
		if($kategorie_id != null) $sql .= " AND artikel_kategorie.fk_kategorie_id = ".intval($kategorie_id);
		
		$rows = $this->db->get_all($sql);

		return $this->add_multi_fields($rows);
	}

	
	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($post, $files) 
	{
		
		$exist = $this->get_by_artikel_nummer($post["artikel_nummer"]);
		if($exist != null) return array('result' => false, 'message' => 'Artikelnummer bereits vergeben');
		
		$values   = $this->helper->escape_values($post);
		$date     = $this->helper->get_english_datetime_now();

		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
			NULL, 
			".intval($_SESSION["id"]).",
			".intval($values["artikel_typ_id"]).",
			".intval($values["einheit_id"]).",
			".intval($values["zyklus_id"]).",
			'".$date."',
			'".$date."',
			'',
			'".$values["artikel_nummer"]."',
			'".$values["quality_hosting_product_id"]."',
			'".$values["artikel_name"]."',
			'".$this->helper->format_waehrung_for_db($values["einkaufspreis"])."',
			'".$this->helper->get_toggle_value($values["vertragslaufzeit"])."',
			".intval($values["vertragslaufzeit_monate"]).",
			".intval($values["vertragslaufzeit_kuendigungsfrist"]).",
			'".$this->helper->format_waehrung_for_db($values["einrichtungsgebuehr"])."',
			'".$values["artikel_beschreibung"]."',
			'".$values["artikel_beschreibung_angebot"]."',
			'".$this->helper->format_waehrung_for_db($values["preis"])."',
			'aktiv'
		)";
		
	
		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();

	
		$this->artikel_kategorie->insert_all($post['kategorien'], $id);

		if($files['foto'] != '') $this->update_foto($values, $files);
		
		return array(
			'id'     => $id,
			'result' => $result_insert
		);
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

 

	/**
		update
		@var: post array
	**/
	
	public function update($post, $files) 
	{
		$values  = $this->helper->escape_values($post);
		$date    = $this->helper->get_english_datetime_now();
		
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				bearbeitet_am                      = '".$date."',
				fk_artikel_typ_id                  = ".intval($values['artikel_typ_id']).",
				fk_einheit_id                      = ".intval($values['einheit_id']).",
				fk_zyklus_id                       = ".intval($values['zyklus_id']).",
				artikel_name                       = '".$values['artikel_name']."',
				quality_hosting_product_id         = '".$values['quality_hosting_product_id']."',
				einkaufspreis                      = ".$this->helper->format_waehrung_for_db($values['einkaufspreis']).",
				vertragslaufzeit                   = '".$this->helper->get_toggle_value($values['vertragslaufzeit'])."',
				vertragslaufzeit_monate            = ".intval($values['vertragslaufzeit_monate']).",
				vertragslaufzeit_kuendigungsfrist  = ".intval($values['vertragslaufzeit_kuendigungsfrist']).",
				einrichtungsgebuehr                = ".$this->helper->format_waehrung_for_db($values['einrichtungsgebuehr']).",
				artikel_beschreibung               = '".$values['artikel_beschreibung']."',
				artikel_beschreibung_angebot       = '".$values['artikel_beschreibung_angebot']."',
				preis                              = ".$this->helper->format_waehrung_for_db($values['preis'])."
		WHERE ".$this->get_tablename().".id = ".intval($values['artikel_id']);


		$result = $this->db->update($sql);
		
		$this->artikel_kategorie->insert_all($post['kategorien'], $values['artikel_id']);

		if($files['foto'] != '') $this->update_foto($values, $files);

		return $result;
	}

	public function get_foto_url($artikel) 
	{

		if($artikel['foto'] == '') return $this->einstellungen['artikel_foto'];
		else return $this->helper->get_upload_path($artikel['foto']);
	}
	
	public function add_multi_fields($rows)
	{
		if($rows == null) return null;
		if(is_array($rows) == false) return null;
		$result = array();

		foreach($rows AS $row) {
			$row = $this->add_fields($row);
			array_push($result, $row);
		}

		return $result;

	}

	public function add_fields($row)
	{
		if($row == null) return null;
	
		$row['kategorien'] = $this->artikel_kategorie->get_all($row['artikel_id']);
		$row['kategorie_ids'] = array();
		$row['preise']        = $this->artikel_preis->get_all($row['artikel_id']); 

		if(is_array($row['kategorien'])) {
			foreach($row['kategorien'] AS $kategorie) {
				array_push($row['kategorie_ids'], $kategorie['fk_kategorie_id']);
			}
		}

		return $row;
	}

	public function get_neue_artikel_nummer()
	{
		$sql = "SELECT MAX(artikel_nummer) AS 'max_artikel_nummer' FROM ".$this->get_tablename();
		$row = $this->db->get($sql);

		$max = intval($row['max_artikel_nummer']);
		$max++;

		return $max;

	}

	public function get_artikel_zyklen($artikel_id) 
	{
		global $c_html;
		$artikel = $this->get($artikel_id);
		$standard_zyklus = $artikel['fk_zyklus_id'];
		$values = array();
		$values[$standard_zyklus] = $artikel['zyklus'].' ('.$c_html->waehrung($artikel['preis']).')';

		if($artikel['preise'] != null) {
			foreach($artikel['preise'] AS $preis) {
				if($standard_zyklus == $preis['fk_zyklus_id']) continue;
				$values[$preis['fk_zyklus_id']] = $preis['zyklus'].' ('.$c_html->waehrung($preis['preis']).')';
			}
		}

		return $values;
	}


		
}