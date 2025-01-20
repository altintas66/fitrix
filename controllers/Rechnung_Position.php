<?php

class Rechnung_Position { 
	
	private $db;
	private $helper;
	private $artikel;
	private $einheit;
	private $zyklus;
	private $artikel_typ;
	private $artikel_preis;
	private $optionale_felder;
	private $einstellungen;
	private $aktive_module;

	
	private $fields;
	private $joins;
	private $tablename;


	
	public function __construct($db, $helper, $artikel, $einheit, $zyklus, $artikel_typ, $artikel_preis, $optionale_felder, $einstellungen, $aktive_module) 
	{
		$this->db                = $db;
		$this->helper            = $helper;
		$this->artikel           = $artikel;
		$this->einheit           = $einheit;
		$this->zyklus            = $zyklus;
		$this->artikel_typ       = $artikel_typ;
		$this->artikel_preis     = $artikel_preis;
		$this->optionale_felder  = $optionale_felder;
		$this->einstellungen     = $einstellungen;
		$this->aktive_module     = $aktive_module;

		
		$this->set_tablename();
		$this->set_fields($this->get_tablename());
		$this->set_joins($this->get_tablename());
		
	}
	
	public function set_fields($tablename) 
	{
		$this->fields = "
			".$tablename.".id                                           AS 'rechnung_position_id', 
			".$tablename.".fk_rechnung_id                               AS 'fk_rechnung_id', 
			".$tablename.".fk_artikel_id                                AS 'fk_artikel_id', 
			".$tablename.".fk_user_id                                   AS 'fk_user_id', 
			".$tablename.".angelegt_am                                  AS 'angelegt_am', 
			".$tablename.".bearbeitet_am                                AS 'bearbeitet_am', 
			".$tablename.".leistungsdatum                               AS 'leistungsdatum', 
			".$tablename.".abrechnungszeitraum_von                      AS 'abrechnungszeitraum_von', 
			".$tablename.".abrechnungszeitraum_bis                      AS 'abrechnungszeitraum_bis', 
			".$tablename.".artikel_nummer                               AS 'artikel_nummer', 
			".$tablename.".artikel_name                                 AS 'artikel_name', 
			".$tablename.".artikel_beschreibung                         AS 'artikel_beschreibung', 
			".$tablename.".artikel_preis                                AS 'artikel_preis', 
			".$tablename.".artikel_menge                                AS 'artikel_menge', 
			".$tablename.".artikel_einheit                              AS 'artikel_einheit', 
			".$tablename.".artikel_artikel_typ                          AS 'artikel_artikel_typ', 
			".$tablename.".artikel_zyklus                               AS 'artikel_zyklus', 
			".$tablename.".gesamt_preis                                 AS 'gesamt_preis', 
			".$tablename.".position                                     AS 'position',
			rechnung_position_optionale_felder.fahrzeug_marke           AS 'fahrzeug_marke', 
			rechnung_position_optionale_felder.fahrzeug_modell          AS 'fahrzeug_modell', 
			rechnung_position_optionale_felder.fahrzeug_kennzeichen     AS 'fahrzeug_kennzeichen', 
			rechnung_position_optionale_felder.fahrzeug_fin             AS 'fahrzeug_fin',
			rechnung_position_optionale_felder.teppichreinigung_laenge  AS 'teppichreinigung_laenge', 
			rechnung_position_optionale_felder.teppichreinigung_breite  AS 'teppichreinigung_breite'
		";
	}

	
	public function set_tablename() 
	{
		$this->tablename = 'rechnung_position';
	}

	public function set_joins($tablename) 
	{
		$this->joins = "
			LEFT JOIN rechnung_position_optionale_felder ON rechnung_position_optionale_felder.fk_rechnung_position_id = ".$tablename.".id
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

		$row = $this->db->get($sql);
		return $this->add_fields($row);
	}	

	public function get_by_rechnung_and_artikelnummer($rechnung_id, $artikel_nummer) 
	{
		$sql = "SELECT 
				".$this->get_fields()."
			FROM ".$this->get_tablename()."
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".fk_rechnung_id = ".intval($rechnung_id)." 
			AND ".$this->get_tablename().".artikel_nummer = ".intval($artikel_nummer) ;

		$row = $this->db->get($sql);
		return $this->add_fields($row);
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
			".$this->get_joins()."
			WHERE ".$this->get_tablename().".id > 0
			AND fk_rechnung_id = ".intval($rechnung_id);
		
		$rows = $this->db->get_all($sql);
		return $this->add_multi_fields($rows);
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
		$gesamt_preis =
	
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
				'".$this->get_gesamt_preis($post['artikel_preis'], $post['artikel_menge'], $post)."',
				99
			)";
	

		$result_insert = $this->db->insert($sql);
		$id = $this->db->get_last_inserted_id();

		if(($values['artikel_id'] == null) || (intval($values['artikel_id']) == 0)) {
			$this->update_feld_to_null('fk_artikel_id', $id, $values['rechnung_id']);
		}

		$this->update_dates($post, $id, $values['rechnung_id']);
		$this->insert_update_optionale_felder($post, $id);
		$this->generiere_pdf($values['rechnung_id']);
		
		return array(
			'id'     => $id,
			'result' => $result_insert
		);
	}

	
	public function update_dates($post, $id, $rechnung_id) 
	{
		$dates = array('leistungsdatum', 'abrechnungszeitraum_von', 'abrechnungszeitraum_bis');
		foreach($dates AS $date) {
			if((isset($post[$date])) && ($post[$date] != '')) {
				$this->update_feld(
					$date, 
					$this->helper->english_date_no_time($post[$date]),
					$id,
					$rechnung_id
				);
			}
		}
	}

	public function update_feld($feld_name, $feld_value, $rechnung_position_id, $rechnung_id)
	{
		$sql = "UPDATE ".$this->get_tablename()." SET ".$feld_name." = '".$feld_value."' WHERE ".$this->get_tablename().".id = ".intval($rechnung_position_id);
		$result = $this->db->update($sql);
		$this->generiere_pdf($rechnung_id);

		return $result;
	}

	public function update_feld_to_null($feld_name, $rechnung_position_id, $rechnung_id)
	{
		$sql = "UPDATE ".$this->get_tablename()." SET ".$feld_name." = NULL WHERE ".$this->get_tablename().".id = ".intval($rechnung_id);
		$result = $this->db->update($sql);
		$this->generiere_pdf($rechnung_id);

		return $result;
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
				artikel_zyklus         = '".$values['artikel_zyklus']."',
				gesamt_preis           = ".$this->get_gesamt_preis($preis, $values['artikel_menge'], $post)."
		WHERE ".$this->get_tablename().".id = ".intval($post[$this->get_tablename().'_id']);
		$result = $this->db->update($sql);

		$id = $post[$this->get_tablename().'_id'];
		
		$this->update_dates($values, $id, $values['rechnung_id']);
		$this->insert_update_optionale_felder($post, $id);
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
				'rechnung_id'              => $post['rechnung_id'],
				'artikel_id'               => $post['artikel_id'],
				'artikel_nummer'           => $artikel['artikel_nummer'],
				'artikel_name'             => $artikel['artikel_name'],
				'artikel_beschreibung'     => $artikel['artikel_beschreibung'],
				'artikel_preis'            => $preis,
				'artikel_menge'            => $post['menge'],
				'artikel_einheit'          => $artikel['einheit'],
				'artikel_artikel_typ'      => $artikel['artikel_typ'],
				'artikel_zyklus'           => $artikel_zyklus,
				'fahrzeug_marke'           => $post['fahrzeug_marke'],
				'fahrzeug_modell'          => $post['fahrzeug_modell'],
				'fahrzeug_kennzeichen'     => $post['fahrzeug_kennzeichen'],
				'fahrzeug_fin'             => $post['fahrzeug_fin'],
				'leistungsdatum'           => $post['leistungsdatum'],
				'teppichreinigung_laenge'  => $post['teppichreinigung_laenge'],
				'teppichreinigung_breite'  => $post['teppichreinigung_breite']
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

		if(isset($post['artikel_nummer'])) {
			$artikel_nummer = $post['artikel_nummer'];
		}else $artikel_nummer = null;

		if(isset($post['abrechnungszeitraum_von'])) {
			$abrechnungszeitraum_von = $post['abrechnungszeitraum_von'];
		}else $abrechnungszeitraum_von = null;

		if(isset($post['leistungsdatum'])) {
			$leistungsdatum = $post['leistungsdatum'];
		}else $leistungsdatum = null;

		if(isset($post['abrechnungszeitraum_bis'])) {
			$abrechnungszeitraum_bis = $post['abrechnungszeitraum_bis'];
		}else $abrechnungszeitraum_bis = null;

		if(isset($post['artikel_id'])) {
			$artikel_id = $post['artikel_id'];
		}else $artikel_id = null;

		
		$result = $this->insert(
			array(
				'rechnung_id'              => $post['rechnung_id'],
				'artikel_id'               => $artikel_id,
				'artikel_nummer'           => $artikel_nummer,
				'artikel_name'             => $post['artikel_name'],
				'artikel_beschreibung'     => $post['artikel_beschreibung'],
				'artikel_preis'            => $this->helper->format_waehrung_for_db($post['artikel_preis']),
				'artikel_menge'            => $post['artikel_menge'],
				'artikel_einheit'          => $artikel_einheit,
				'artikel_artikel_typ'      => $artikel_artikel_typ,
				'artikel_zyklus'           => $artikel_zyklus,
				'abrechnungszeitraum_von'  => $abrechnungszeitraum_von,
				'abrechnungszeitraum_bis'  => $abrechnungszeitraum_bis,
				'leistungsdatum'           => $leistungsdatum,
				'fahrzeug_marke'           => $post['fahrzeug_marke'],
				'fahrzeug_modell'          => $post['fahrzeug_modell'],
				'fahrzeug_kennzeichen'     => $post['fahrzeug_kennzeichen'],
				'fahrzeug_fin'             => $post['fahrzeug_fin'],
				'teppichreinigung_laenge'  => $post['teppichreinigung_laenge'],
				'teppichreinigung_breite'  => $post['teppichreinigung_breite']
			)
		);

		return $result;

	}


	public function delete($rechnung_id, $id)
    {
        
        $sql = "DELETE FROM ".$this->get_tablename()." WHERE id = ".intval($id)." AND fk_rechnung_id = ".intval($rechnung_id);
        $result = $this->db->delete($sql);
		$this->optionale_felder->delete($id);
		$this->generiere_pdf($rechnung_id);
        return $result;
    }

	public function generiere_pdf($rechnung_id)
	{
		global $c_rechnung;
		$c_rechnung->generiere_pdf($rechnung_id);
	}


	public function berechne_preis_aus_einkaufspreis($einkaufspreis)
	{
		$einkaufspreis = $this->helper->format_waehrung_for_db($einkaufspreis);
		$verkaufspreis = $einkaufspreis;

		if($einkaufspreis >= 24){
			$verkaufspreis += $einkaufspreis * 0.20;
		} else if ($einkaufspreis >= 20){
			$verkaufspreis += $einkaufspreis * 0.25;
		} else if ($einkaufspreis >= 16){
			$verkaufspreis += $einkaufspreis * 0.30;
		} else if ($einkaufspreis >= 12){
			$verkaufspreis += $einkaufspreis * 0.40;
		} else if ($einkaufspreis >= 10){
			$verkaufspreis += $einkaufspreis * 0.50;
		} else if ($einkaufspreis >= 8){
			$verkaufspreis += $einkaufspreis * 0.60;
		} else if ($einkaufspreis >= 6){
			$verkaufspreis += $einkaufspreis * 0.70;
		} else if ($einkaufspreis >= 4){
			$verkaufspreis += $einkaufspreis * 0.80;
		} else if ($einkaufspreis >= 2){
			$verkaufspreis += $einkaufspreis * 0.90;
		} else if ($einkaufspreis >= 0){
			$verkaufspreis += $einkaufspreis * 1.00;
		}
		return $this->helper->waehrung($verkaufspreis);
	}

	public function get_abrechnungszeitraum_beschreibung($position)
	{



		if($this->einstellungen['rechnung_datum_nach_leistungsdatum'] == '1') {
			return $this->helper->german_date_no_time($position['leistungsdatum']);
		}

		if(($position['abrechnungszeitraum_von'] == null) && ($position['abrechnungszeitraum_bis'] == null)) return '';

		$html = '<br>';
		$abrechnungszeitraum_von = new DateTime($position['abrechnungszeitraum_von']);
		$abrechnungszeitraum_bis = new DateTime($position['abrechnungszeitraum_bis']);

		if($position['artikel_zyklus'] == 'Monatlich') {
			
			$html .= $this->helper->get_monat_label(intval($abrechnungszeitraum_von->format('m')));
			$html .= ' '.$abrechnungszeitraum_von->format('Y');
			return $html;
		} else {
			$html .= $abrechnungszeitraum_von->format('d.m.Y').' - '.$abrechnungszeitraum_bis->format('d.m.Y');
			return $html;
		}

	}

	public function insert_update_optionale_felder($post, $id)
	{
		$this->optionale_felder->insert_update($post, $id);
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
		
		$row['leistungsdatum_german'] = $this->helper->german_date_no_time($row['leistungsdatum']);
		$row['abrechnungszeitrum_von'] = $this->helper->german_date_no_time($row['abrechnungszeitrum_von']);
		$row['abrechnungszeitrum_bis'] = $this->helper->german_date_no_time($row['abrechnungszeitrum_bis']);

		return $row;
	}

	public function get_gesamt_preis($preis, $menge, $post) 
	{
		return $this->helper->get_gesamt_preis_position($preis, $menge, $post, $this->aktive_module);
	}

	

}