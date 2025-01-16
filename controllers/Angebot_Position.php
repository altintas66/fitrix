<?php

class Angebot_Position { 
    
    private $db;
    private $helper;
    private $artikel;
	private $einheit;
	private $artikel_typ;
    private $artikel_preis;
    private $zyklus;
    private $optionale_felder;

    
    private $fields;
    private $joins;
    private $tablename;


    
    public function __construct($db, $helper, $artikel, $einheit, $artikel_typ, $artikel_preis, $zyklus, $optionale_felder) 
    {
        
        $this->db                 = $db;
        $this->helper             = $helper;
        $this->artikel            = $artikel;
		$this->einheit            = $einheit;
		$this->artikel_typ        = $artikel_typ;
        $this->artikel_preis      = $artikel_preis;
        $this->zyklus             = $zyklus;
        $this->optionale_felder   = $optionale_felder;

        $this->set_tablename();
        $this->set_fields($this->get_tablename());
        $this->set_joins($this->get_tablename());

    }
    
    public function set_fields($tablename) 
    {
        $this->fields = "
            ".$tablename.".id                                          AS 'angebot_position_id', 
            ".$tablename.".fk_angebot_id                               AS 'fk_angebot_id', 
            ".$tablename.".fk_artikel_id                               AS 'fk_artikel_id', 
            ".$tablename.".fk_zyklus_id                                AS 'fk_zyklus_id', 
            ".$tablename.".fk_artikel_typ_id                           AS 'fk_artikel_typ_id', 
            ".$tablename.".fk_einheit_id                               AS 'fk_einheit_id', 
            ".$tablename.".angelegt_am                                 AS 'angelegt_am', 
            ".$tablename.".bearbeitet_am                               AS 'bearbeitet_am',
            ".$tablename.".artikel_nummer                              AS 'artikel_nummer', 
			".$tablename.".artikel_name                                AS 'artikel_name', 
            ".$tablename.".beschreibung                                AS 'beschreibung', 
            ".$tablename.".netto_preis                                 AS 'netto_preis', 
            ".$tablename.".menge                                       AS 'menge', 
            ".$tablename.".vertragslaufzeit                            AS 'vertragslaufzeit', 
            ".$tablename.".vertragslaufzeit_monate                     AS 'vertragslaufzeit_monate', 
            ".$tablename.".vertragslaufzeit_kuendigungsfrist           AS 'vertragslaufzeit_kuendigungsfrist', 
            ".$tablename.".einrichtungsgebuehr                         AS 'einrichtungsgebuehr', 
            ".$tablename.".position                                    AS 'position', 
            ".$tablename.".status                                      AS 'status',
			zyklus.id                                                  AS 'zyklus_id',
			zyklus.bezeichnung                                         AS 'zyklus_bezeichnung',
			zyklus.anzahl_monate                                       AS 'zyklus_anzahl_monate',
			artikel_typ.id                                             AS 'artikel_typ_id',
			artikel_typ.bezeichnung                                    AS 'artikel_typ_bezeichnung',
			einheit.id                                                 AS 'einheit_id',
			einheit.bezeichnung                                        AS 'einheit_bezeichnung',
            angebot_position_optionale_felder.fahrzeug_marke           AS 'fahrzeug_marke', 
            angebot_position_optionale_felder.fahrzeug_modell          AS 'fahrzeug_modell', 
            angebot_position_optionale_felder.fahrzeug_kennzeichen     AS 'fahrzeug_kennzeichen', 
            angebot_position_optionale_felder.fahrzeug_fin             AS 'fahrzeug_fin'
            angebot_position_optionale_felder.teppichreinigung_laenge  AS 'teppichreinigung_laenge',
            angebot_position_optionale_felder.teppichreinigung_breite  AS 'teppichreinigung_breite'
        ";
    }

    
    public function set_tablename() 
    {
        $this->tablename = 'angebot_position';
    } 

	public function set_joins($tablename) //joins fehlen noch
	{
		$this->joins = "
			LEFT JOIN zyklus ON zyklus.id = ".$tablename.".fk_zyklus_id
			LEFT JOIN artikel_typ ON artikel_typ.id = ".$tablename.".fk_artikel_typ_id
			LEFT JOIN einheit ON einheit.id = ".$tablename.".fk_einheit_id
            LEFT JOIN angebot_position_optionale_felder ON angebot_position_optionale_felder.fk_angebot_position_id = ".$tablename.".id 
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
            'sichtbar'      => array('label' => 'Sichtbar', 'class' => 'btn btn-warning'),
            'ausgeblendet'  => array('label' => 'Ausgeblendet', 'class' => 'btn btn-danger'),
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

        $row = $this->db->get($sql);
        return $row;
    }   
    
    /**
        Get all
        @return: MYSQL_ASSOC | NULL
    **/
    
    public function get_all($angebot_id, $status = '') 
    {
        $sql = "SELECT 
                ".$this->get_fields()."
            FROM ".$this->get_tablename()."
			".$this->get_joins()."
            WHERE ".$this->get_tablename().".id > 0
            AND ".$this->get_tablename().".fk_angebot_id = ".intval($angebot_id);
            
        
        if($status != '') $sql .= " AND ".$this->get_tablename().".status = '".$status."'";

        $sql .= " ORDER BY ".$this->get_tablename().".position ASC";
        
        $rows = $this->db->get_all($sql);

        return $rows;
    }

    
    /**
        insert
        @var: post array
        @return: int id
    **/
    
    public function insert($post) 
    {
        
        global $c_angebot;
        $values          = $this->helper->escape_values($post);
        $date            = $this->helper->get_english_datetime_now();
        $netto_preis     = floatval($values["netto_preis"]);

        $sql = "INSERT INTO ".$this->get_tablename()." VALUES(
            NULL, 
            ".intval($values["angebot_id"]).",
            ".intval($values["artikel_id"]).",
            ".intval($values['zyklus_id']).",
            ".intval($values['artikel_typ_id']).",
            ".intval($values['einheit_id']).",
            '".$date."',
            '".$date."',
            '".$values["artikel_nummer"]."',
			'".$values["artikel_name"]."',
            '".$values["beschreibung"]."',
            '".$netto_preis."',
            ".intval($values["menge"]).",
			'".$this->helper->get_toggle_value($values["vertragslaufzeit"])."',
			".intval($values["vertragslaufzeit_monate"]).",
			".intval($values["vertragslaufzeit_kuendigungsfrist"]).",
			'".floatval($values['einrichtungsgebuehr'])."',
			99,
            'sichtbar'
        )";

    
        $result_insert = $this->db->insert($sql);
        $id = $this->db->get_last_inserted_id();

        if($values["artikel_id"] == null) $this->update_artikel_id_to_null($id);

		$this->insert_update_optionale_felder($post, $id);
        $c_angebot->generiere_pdf($values["angebot_id"]);
        
        return array(
            'id'     => $id,
            'result' => $result_insert
        );
    }

    public function insert_position($post)
    {
        $values    = $this->helper->escape_values($post); 
        $artikel   = $this->artikel->get($values['artikel_id']);
        $preis     = $artikel['preis'];
        $zyklus_id = $artikel['fk_zyklus_id'];

        if( (isset($post['zyklus_id'])) && ($post['zyklus_id'] != $artikel['fk_zyklus_id']) ) {
            $zyklus_id = $post['zyklus_id'];
            $preis     = $this->artikel_preis->get_preis_by_artikel_zyklus($post['artikel_id'], $post['zyklus_id']);
        }


        $result = $this->insert(array(
            'angebot_id'                         => $values['angebot_id'],
			'artikel_id'                         => $values['artikel_id'],
            'zyklus_id'                          => $zyklus_id,
            'artikel_typ_id'                     => $artikel['fk_einheit_id'],
            'einheit_id'                         => $artikel['fk_artikel_typ_id'],
			'artikel_nummer'                     => $artikel['artikel_nummer'],
			'artikel_name'                       => $artikel['artikel_name'],
			'beschreibung'                       => $artikel['artikel_beschreibung_angebot'],
			'netto_preis'                        => $preis,
			'menge'                              => $values['menge'],
			'vertragslaufzeit'                   => $artikel['vertragslaufzeit'],
			'vertragslaufzeit_kuendigungsfrist'  => $artikel['vertragslaufzeit_kuendigungsfrist'],
			'vertragslaufzeit_monate'            => $artikel['vertragslaufzeit_monate'],
			'einrichtungsgebuehr'                => $artikel['einrichtungsgebuehr'],
            'fahrzeug_marke'                     => $values['fahrzeug_marke'],
			'fahrzeug_modell'                    => $values['fahrzeug_modell'],
			'fahrzeug_kennzeichen'               => $values['fahrzeug_kennzeichen'],
			'fahrzeug_fin'                       => $values['fahrzeug_fin']
        ));

        return $result;
    }

    public function insert_individuelle_position($post)
    {
        $values               = $this->helper->escape_values($post);
		$einheit              = $this->einheit->get($values['einheit_id']);
		$artikel_typ          = $this->artikel_typ->get($values['artikel_typ_id']);
        $zyklus               = $this->zyklus->get($values['zyklus_id']);
        $netto_preis          = $this->helper->format_waehrung_for_db($values['netto_preis']);
        $einrichtungsgebuehr  = $this->helper->format_waehrung_for_db($values['einrichtungsgebuehr']);

		$result = $this->insert(array(
			'angebot_id'                         => $values['angebot_id'],
			'artikel_id'                         => null,
            'zyklus_id'                          => $post['zyklus_id'],
            'artikel_typ_id'                     => $post['artikel_typ_id'],
            'einheit_id'                         => $post['einheit_id'],
			'artikel_nummer'                     => '',
			'artikel_name'                       => $values['artikel_name'],
			'beschreibung'                       => $values['beschreibung'],
			'netto_preis'                        => $netto_preis,
			'menge'                              => $values['menge'],
			'einheit'                            => $einheit['bezeichnung'],
			'artikel_typ'                        => $artikel_typ['bezeichnung'],
            'zyklus'                             => $zyklus['bezeichnung'],
			'vertragslaufzeit'                   => '0',
			'vertragslaufzeit_kuendigungsfrist'  => 0,
			'vertragslaufzeit_monate'            => 0,
			'einrichtungsgebuehr'                => $einrichtungsgebuehr
		));

		return $result;

    }

	public function update_artikel_id_to_null($id)
    {
        $sql = "UPDATE ".$this->get_tablename()." SET fk_artikel_id = NULL WHERE ".$this->get_tablename().".id = ".intval($id);
        return $this->db->update($sql);
    }

    /**
        update
        @var: post array
    **/
    
    public function update($post) 
    {
        global $c_angebot;
        $values  = $this->helper->escape_values($post);
        $date    = $this->helper->get_english_datetime_now();
        $id      = $post['angebot_position_id'];
        
		$sql = "UPDATE ".$this->get_tablename()." SET 
            fk_einheit_id        = '".$values['einheit_id']."',
            fk_artikel_typ_id    = '".$values['artikel_typ_id']."',
            fk_zyklus_id         = '".$values['zyklus_id']."',
            bearbeitet_am        = '".$date."',
            artikel_name         = '".$values['artikel_name']."',
            beschreibung         = '".$values['beschreibung']."',
            netto_preis          = '".$this->helper->format_waehrung_for_db($values["netto_preis"])."',
            menge                = ".intval($values['menge']).",
            einrichtungsgebuehr  = '".$this->helper->format_waehrung_for_db($values["einrichtungsgebuehr"])."'
        WHERE ".$this->get_tablename().".id = ".intval($post['angebot_position_id']); 
        
        $result = $this->db->update($sql);

        $this->insert_update_optionale_felder($post, $id);
        $c_angebot->generiere_pdf($post["angebot_id"]);

        return $result;
    }
    
    public function delete($angebot_id, $id)
    {
        global $c_angebot;
        $sql = "DELETE FROM ".$this->get_tablename()." WHERE id = ".intval($id)." AND fk_angebot_id = ".intval($angebot_id);
        $result = $this->db->delete($sql);

        $c_angebot->generiere_pdf($angebot_id);

        return $result; 
    }

    public function insert_update_optionale_felder($post, $id)
	{
		$this->optionale_felder->insert_update($post, $id);
	}

        
}