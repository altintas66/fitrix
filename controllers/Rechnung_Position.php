<?php

class Rechnung_Position { 
	
	private $db;
	private $helper;
	private $artikel;
	private $einheit;
	private $zyklus;
	private $artikel_typ;
	private $artikel_preis;

	
	private $fields;
	private $tablename;


	
	public function __construct($db, $helper, $artikel, $einheit, $zyklus, $artikel_typ, $artikel_preis) 
	{
		$this->db             = $db;
		$this->helper         = $helper;
		$this->artikel        = $artikel;
		$this->einheit        = $einheit;
		$this->zyklus         = $zyklus;
		$this->artikel_typ    = $artikel_typ;
		$this->artikel_preis  = $artikel_preis;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                            AS 'rechnung_position_id', 
			".$tablename.".fk_artikel_id                 AS 'fk_artikel_id', 
			".$tablename.".fk_user_id                    AS 'fk_user_id', 
			".$tablename.".angelegt_am                   AS 'angelegt_am', 
			".$tablename.".bearbeitet_am                 AS 'bearbeitet_am', 
			".$tablename.".liefer_datum                  AS 'liefer_datum', 
			".$tablename.".abrechnungszeitraum_von       AS 'abrechnungszeitraum_von', 
			".$tablename.".abrechnungszeitraum_bis       AS 'abrechnungszeitraum_bis', 
			".$tablename.".artikel_nummer                AS 'artikel_nummer', 
			".$tablename.".artikel_name                  AS 'artikel_name', 
			".$tablename.".artikel_beschreibung          AS 'artikel_beschreibung', 
			".$tablename.".artikel_preis                 AS 'artikel_preis', 
			".$tablename.".artikel_menge                 AS 'artikel_menge', 
			".$tablename.".artikel_einheit               AS 'artikel_einheit', 
			".$tablename.".artikel_artikel_typ           AS 'artikel_artikel_typ', 
			".$tablename.".artikel_zyklus                AS 'artikel_zyklus', 
			".$tablename.".abrechnungszeitraum           AS 'abrechnungszeitraum', 
			".$tablename.".position                      AS 'position'
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'rechnung_position';
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
		Get by id
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get($id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".id = ".intval($id);

		//$row = $this->format_row($this->db->get($sql));
		$row = $this->db->get($sql);
		return $row;
	}	
	
	/**
		Get all
		@return: MYSQL_ASSOC | NULL
	**/
	 
	public function get_all($rechnung_id) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			WHERE ".$this->get_tablename().".id > 0
			AND fk_rechnung_id = ".intval($rechnung_id);
			
		return $this->db->get_all($sql);
	}

	
	/**
		insert
		@var: post array
		@return: int id
	**/
	
	public function insert($post) 
	{


		$values   = $this->helper->escape_values($post);
		$date     = $this->helper->get_english_datetime_now();
	
		$sql = "INSERT INTO ".$this->get_tablename()." VALUES(
				NULL, 
				".intval($values['rechnung_id']).",
				".intval($values['artikel_id']).",
				".intval($_SESSION['id']).",
				'".$date."',
				'".$date."',
				NULL,
				NULL,
				NULL,
				'".$post['artikel_nummer']."',
				'".$post['artikel_name']."',
				'".$post['artikel_beschreibung']."',
				'".floatval($post['artikel_preis'])."',
				".intval($values['artikel_menge']).",
				'".$post['artikel_einheit']."',
				'".$post['artikel_artikel_typ']."',
				'".$post['artikel_zyklus']."',
				'".$this->get_abrechnungszeitraum($values['artikel_id'])."',
				99
			)";
	

		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();

		if($values['artikel_id'] == null) $this->update_feld_to_null('fk_artikel_id', $id, $values['rechnung_id']);

		$this->update_dates($post, $id);
		$this->generiere_pdf($values['rechnung_id']);
		
		return array(
			'id'     => $id,
			'result' => $result_insert
		);
	}

	
	public function update_dates($post, $rechnung_id) 
	{
		$dates = array('liefer_datum', 'abrechnungszeitraum_von', 'abrechnungszeitraum_bis');
		foreach($dates AS $date) {
			if((isset($post[$date])) && ($post[$date] != '')) $this->update_feld($date, $post[$date], $this->helper->get_english_date_no_time($post[$date]));
		}
	}

	public function update_feld($feld_name, $feld_value, $rechnung_position_id, $rechnung_id)
	{
		$sql = "UPDATE ".$this->get_tablename()." SET ".$feld_name." = '".$feld_value."' WHERE ".$this->get_tablename().".id = ".intval($rechnung_id);
		$result = $this->db->update($sql);
		$this->generiere_pdf($rechnung_id);

		return $result;
	}

	public function update_feld_to_null($feld_name, $rechnung_position_id, $rechnung_id)
	{
		$sql = "UPDATE ".$this->get_tablename()." SET ".$feld_name." = NULL WHERE ".$this->get_tablename().".id = ".intval($rechnung_id);
		$result = $this->db->update($sql);
		$this->generiere_pdf($rechnung_id);

		return $return;
	}
	
	/**
		update
		@var: post array
	**/
	
	public function update($post) 
	{
		$values  = $this->helper->escape_values($post);
		$date    = $this->helper->get_english_datetime_now();
		$preis	 = $this->helper->format_waehrung_for_db($values["artikel_preis"]);
		
		$sql ="
			UPDATE ".$this->get_tablename()." SET 
				bearbeitet_am          = '".$date."',
				artikel_name           = '".$values['artikel_name']."',
				artikel_preis          = ".$preis.",
				artikel_menge          = ".intval($values['artikel_menge']).",
            	artikel_beschreibung   = '".$values['beschreibung']."',
				artikel_artikel_typ    = '".$values['artikel_artikel_typ']."',
				artikel_einheit        = '".$values['artikel_einheit']."',
				artikel_zyklus         = '".$values['artikel_zyklus']."'
		WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);
		$result = $this->db->update($sql);

		
		$this->update_dates($values, $values['rechnung_id']);
		$this->generiere_pdf($values['rechnung_id']);
	
		return $result;
	}

	public function insert_artikel_position($post)
	{
		global $c_html;

		$artikel   = $this->artikel->get($post['artikel_id']);
		$preis     = $c_html->waehrung($artikel['preis']);
		$zyklus_id = $artikel['fk_zyklus_id'];

		if( (isset($post['zyklus_id'])) && ($post['zyklus_id'] != $artikel['fk_zyklus_id']) ) {
            $zyklus_id = $post['zyklus_id'];
            $preis     = $this->artikel_preis->get_preis_by_artikel_zyklus($post['artikel_id'], $post['zyklus_id']);
        }

		$artikel_zyklus = $this->zyklus->get_bezeichnung($zyklus_id);

		$result = $this->insert(
			array(
				'rechnung_id'          => $post['rechnung_id'],
				'artikel_id'           => $post['artikel_id'],
				'artikel_nummer'       => $artikel['artikel_nummer'],
				'artikel_name'         => $artikel['artikel_name'],
				'artikel_beschreibung' => $artikel['artikel_beschreibung'],
				'artikel_preis'        => $preis,
				'artikel_menge'        => $post['menge'],
				'artikel_einheit'      => $artikel['einheit'],
				'artikel_artikel_typ'  => $artikel['artikel_typ'],
				'artikel_zyklus'       => $artikel_zyklus
			)
		);

		return $result;

	}

	public function insert_individuelle_position($post)
	{
		
		if(isset($post['zyklus_id'])) {
			$zyklus         = $this->zyklus->get($post['zyklus_id']);
			$artikel_zyklus =  $zyklus['bezeichnung'];
		} else $artikel_zyklus = $post['artikel_zyklus'];
		
		if(isset($post['einheit_id'])) { 
			$einheit         = $this->einheit->get($post['einheit_id']);
			$artikel_einheit = $einheit['bezeichnung'];
		} else $artikel_einheit = $post['artikel_einheit'];
		
		if(isset($post['artikel_typ_id'])) { 
			$artikel_typ     = $this->artikel_typ->get($post['artikel_typ_id']);
			$artikel_artikel_typ = $artikel_typ['bezeichnung'];
		} else $artikel_artikel_typ = $post['artikel_artikel_typ'];

		
		$result = $this->insert(
			array(
				'rechnung_id'          => $post['rechnung_id'],
				'artikel_id'           => null,
				'artikel_nummer'       => $post['artikel_nummer'],
				'artikel_name'         => $post['artikel_name'],
				'artikel_beschreibung' => $post['artikel_beschreibung'],
				'artikel_preis'        => $this->helper->format_waehrung_for_db($post['artikel_preis']),
				'artikel_menge'        => $post['artikel_menge'],
				'artikel_einheit'      => $artikel_einheit,
				'artikel_artikel_typ'  => $artikel_artikel_typ,
				'artikel_zyklus'       => $artikel_zyklus,
			)
		);

		return $result;

	}


	public function delete($rechnung_id, $id)
    {
        
        $sql = "DELETE FROM ".$this->get_tablename()." WHERE id = ".intval($id)." AND fk_rechnung_id = ".intval($rechnung_id);
        $result = $this->db->delete($sql);
		$this->generiere_pdf($rechnung_id);
        return $result;
    }

	public function generiere_pdf($rechnung_id)
	{
		global $c_rechnung;
		$c_rechnung->generiere_pdf($rechnung_id);
	}

	public function get_abrechnungszeitraum($artikel_id)
	{
		return '';
	}
}