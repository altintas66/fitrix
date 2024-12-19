<?php

class Abonnement_Vertrag { 
    
    private $db;
    private $helper;
    private $artikel_preis;

    
    private $fields;
    private $joins;
    private $tablename;


    
    public function __construct($db, $helper, $artikel_preis) 
    {
        
        $this->db                 = $db;
        $this->helper             = $helper;
        $this->artikel_preis      = $artikel_preis;

        $this->set_tablename();
        $this->set_fields($this->get_tablename());
        $this->set_joins($this->get_tablename());
         
    }
    
    public function set_fields($tablename)  
    {
        $this->fields = "
            	".$tablename.".id                              AS 'abonnement_vertrag_id',
                ".$tablename.".fk_abonnement_id                AS 'fk_abonnement_id',
                ".$tablename.".fk_artikel_id                   AS 'fk_artikel_id',
                ".$tablename.".fk_zyklus_id                    AS 'fk_zyklus_id',
                ".$tablename.".fk_artikel_typ_id               AS 'fk_artikel_typ_id',
                ".$tablename.".fk_einheit_id                   AS 'fk_einheit_id',
                 ".$tablename.".fk_zahlungsart_id              AS 'fk_zahlungsart_id',
                ".$tablename.".angelegt_am                     AS 'angelegt_am',
                ".$tablename.".bearbeitet_am                   AS 'bearbeitet_am',
                ".$tablename.".vertragsnummer                  AS 'vertragsnummer',
                ".$tablename.".artikel_nummer                  AS 'artikel_nummer',
                ".$tablename.".artikel_name                    AS 'artikel_name',
                ".$tablename.".artikel_beschreibung            AS 'artikel_beschreibung',
                ".$tablename.".artikel_menge                   AS 'artikel_menge',
                ".$tablename.".artikel_preis                   AS 'artikel_preis',
                ".$tablename.".start                           AS 'start',
                ".$tablename.".ende                            AS 'ende',
                ".$tablename.".naechste_faelligkeit            AS 'naechste_faelligkeit',
                ".$tablename.".position                        AS 'position',
                ".$tablename.".status                          AS 'status', 
			    zyklus.id                                      AS 'zyklus_id',
			    zyklus.bezeichnung                             AS 'zyklus_bezeichnung',
			    zyklus.anzahl_monate                           AS 'zyklus_anzahl_monate',
			    artikel_typ.id                                 AS 'artikel_typ_id',
			    artikel_typ.bezeichnung                        AS 'artikel_typ_bezeichnung',
			    einheit.id                                     AS 'einheit_id',
			    einheit.bezeichnung                            AS 'einheit_bezeichnung',
                zahlungsart.bezeichnung                        AS 'zahlungsart_bezeichnung'
        ";
    }

     
    public function set_tablename() 
    {
        $this->tablename = 'abonnement_vertrag';
    }
    
	public function set_joins($tablename) 
	{
		$this->joins = "
			INNER JOIN zyklus ON zyklus.id = ".$tablename.".fk_zyklus_id
			INNER JOIN artikel_typ ON artikel_typ.id = ".$tablename.".fk_artikel_typ_id
			INNER JOIN einheit ON einheit.id = ".$tablename.".fk_einheit_id
            INNER JOIN zahlungsart ON zahlungsart.id = ".$tablename.".fk_zahlungsart_id
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
        return $row;
    }   
    
    /**
        Get all
        @return: MYSQL_ASSOC | NULL
    **/
    
    public function get_all($abonnement_id = null, $status = '') 
    {
        $sql = "SELECT 
                ".$this->get_fields()."
            FROM ".$this->get_tablename()."
			".$this->get_joins()."
            WHERE ".$this->get_tablename().".id > 0";
        if($abonnement_id != null) $sql .= " AND ".$this->get_tablename().".fk_abonnement_id = ".intval($abonnement_id);
        
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
        global $c_abonnement;

        $values          = $this->helper->escape_values($post);
        $date            = $this->helper->get_english_datetime_now();
        $artikel_preis   = $this->helper->format_waehrung_for_db($values["artikel_preis"]);

        $sql = "INSERT INTO ".$this->get_tablename()." VALUES(
            NULL, 
           ".intval($values['abonnement_id']).",
           NULL,
           ".intval($values['zyklus_id']).",
           ".intval($values['artikel_typ_id']).",
           ".intval($values['einheit_id']).",
           ".intval($values['zahlungsart_id']).",
           '".$date."',
           '".$date."',
           '',
           '".$values['artikel_nummer']."',
           '".$values['artikel_name']."',
           '".$values['artikel_beschreibung']."',
           ".intval($values['artikel_menge']).",
           ".$artikel_preis.",
           '".$this->helper->english_date_no_time($values['start'])."',
           '".$this->helper->english_date_no_time($values['ende'])."',
           NULL,
			99,
            'aktiv'
        )";

    
        $result_insert = $this->db->insert($sql);
        $id = $this->db->get_last_inserted_id();

        $this->update_vertragsnummer($id);        

        if(($post['naechste_faelligkeit'] == null) || ($post['naechste_faelligkeit'] == '')) $this->set_field_to_null($id, 'naechste_faelligkeit');
        if(($post['ende'] == null) || ($post['ende'] == '')) $this->set_field_to_null($id, 'ende');

        $c_abonnement->generiere_pdf($values["abonnement_id"]);

        return array(
            'id'     => $id,
            'result' => $result_insert
        );
    }
   

    /**
        update
        @var: post array
    **/
    
    public function update($post) 
    {
        global $c_abonnement;

        $values  = $this->helper->escape_values($post);
        $date    = $this->helper->get_english_datetime_now();
        $artikel_preis   = $this->helper->format_waehrung_for_db($values["artikel_preis"]);
        
		$sql = "UPDATE ".$this->get_tablename()." SET 
            fk_einheit_id               = '".$values['einheit_id']."',
            fk_artikel_typ_id           = '".$values['artikel_typ_id']."',
            fk_zyklus_id                = '".$values['zyklus_id']."',
            fk_zahlungsart_id           = '".$values['zahlungsart_id']."',
            bearbeitet_am               = '".$date."',
            artikel_name                = '".$values['artikel_name']."',
            artikel_beschreibung        = '".$values['artikel_beschreibung']."',
            artikel_menge               = ".intval($values['artikel_menge']).",
            artikel_preis               = '".$artikel_preis."',
            start                       = '".$this->helper->english_date_no_time($values['start'])."',
            ende                        = '".$this->helper->english_date_no_time($values['ende'])."'
        WHERE ".$this->get_tablename().".id = ".intval($values['abonnement_vertrag_id']); 
        
        $result = $this->db->update($sql);

        if(($post['ende'] == null) || ($post['ende'] == '')) {
            $this->set_field_to_null($values['abonnement_vertrag_id'], 'ende');
        }
        
        if(isset($post['artikel_id']) && ($post['artikel_id'] != null)) {
            $this->update_feld($values['abonnement_vertrag_id'], 'fk_artikel_id', $post['artikel_id']);
        }

        $c_abonnement->generiere_pdf($values["abonnement_id"]);

        return array(
            'result' => $result
        );
    }
    
    public function delete($abonnement_id, $id)
    {
        global $c_abonnement;
        $sql = "DELETE FROM ".$this->get_tablename()." WHERE id = ".intval($id);
        $result = $this->db->delete($sql);
        $c_abonnement->generiere_pdf($abonnement_id);
        return $result;
    }

    public function update_vertragsnummer($id)
    {
        $vertragsnummer = $this->get_vertragsnummer($id);
        $sql = "UPDATE ".$this->get_tablename()." 
            SET vertragsnummer = '".$vertragsnummer."'
        WHERE id = ".intval($id);
        return $this->db->update($sql);
    }

    public function get_vertragsnummer($id)
    {
        return $id;
    }

    public function set_field_to_null($id, $field)
    {
        $sql = "UPDATE ".$this->get_tablename()." 
            SET ".$field." = NULL
        WHERE id = ".intval($id);
        return $this->db->update($sql);
    }

    public function insert_vertrag_produkt($post)
    {
        global $c_artikel, $c_html;

        $artikel      = $c_artikel->get($post['artikel_id']);
        $zyklus_id    = $artikel['fk_zyklus_id'];
        $preis        = $c_html->waehrung($artikel['preis']);

        if( (isset($post['zyklus_id'])) && ($post['zyklus_id'] != $artikel['fk_zyklus_id']) ) {
            $zyklus_id = $post['zyklus_id'];
            $preis     = $this->artikel_preis->get_preis_by_artikel_zyklus($post['artikel_id'], $post['zyklus_id']);
        }

        return $this->insert(array(
            'abonnement_id'                 => $post['abonnement_id'],
            'artikel_id'                    => $artikel['artikel_id'],
            'zyklus_id'                     => $artikel['fk_zyklus_id'],
            'artikel_typ_id'                => $artikel['fk_einheit_id'],
            'einheit_id'                    => $artikel['fk_artikel_typ_id'],
            'zahlungsart_id'                => $post['zahlungsart_id'],
            'artikel_nummer'                => $artikel['artikel_nummer'],
            'artikel_name'                  => $artikel['artikel_name'],
            'artikel_beschreibung'          => $artikel['artikel_beschreibung'],
            'artikel_menge'                 => $post['artikel_menge'],
            'artikel_preis'                 => $preis,
            'start'                         => $post['start'],
            'ende'                          => $post['ende']
        ));

    }

    public function insert_vertrag_individuelle_position($post)
    {
  
        return $this->insert(array(
            'abonnement_id'                 => $post['abonnement_id'],
            'zyklus_id'                     => $post['zyklus_id'],
            'artikel_typ_id'                => $post['artikel_typ_id'],
            'einheit_id'                    => $post['einheit_id'],
            'artikel_nummer'                => $post['artikel_nummer'],
            'artikel_name'                  => $post['artikel_name'],
            'artikel_beschreibung'          => $post['artikel_beschreibung'],
            'artikel_menge'                 => $post['artikel_menge'],
            'artikel_preis'                 => $post['artikel_preis'],
            'start'                         => $post['start'],
            'ende'                          => $post['ende'],
            'zahlungsart_id'                => $post['zahlungsart_id']
        ));
    }

    public function zyklus_hochzaehlen($vertrag) 
    {
        $zyklus = $vertrag['zyklus_anzahl_monate'];


        if($vertrag['naechste_faelligkeit'] == null) $naechste_faelligkeit = new DateTime($vertrag['start']);
        else $naechste_faelligkeit = new DateTime($vertrag['naechste_faelligkeit']);
        
        $naechste_faelligkeit->modify('+'.$zyklus.' month');

        $sql = "UPDATE ".$this->get_tablename()." SET naechste_faelligkeit = '".$naechste_faelligkeit->format('Y-m-d')."' WHERE id = ".intval($vertrag['abonnement_vertrag_id']);
   
        return $this->db->update($sql);

    }

    public function update_feld($id, $feld, $value) 
    { 
        $sql = "UPDATE ".$this->get_tablename()." SET ".$feld." = '".$value."' WHERE id = ".intval($id);
        return $this->db->update($sql);
    }

    public function get_artikel()
    {
        $sql = "SELECT 
            fk_artikel_id        AS 'artikel_id', 
            COUNT(fk_artikel_id) AS 'anzahl'
        FROM ".$this->get_tablename()." 
        GROUP BY fk_artikel_id
        ORDER BY anzahl DESC";
        
        return $this->db->get_all($sql);
    }

    public function get_naechste_faelligkeit($vertrag)
    {
        if($vertrag['naechste_faelligkeit'] == null) {
            //Wenn noch null ist, dann wird das Startdatum zurück gegeben, es sei denn, dieser ist in der Vergangeheit, also wird es ja spätestens morgen verrechnet
            $heute = new DateTime();
            if($vertrag['start'] < $heute) {
                $morgen = $heute->modify('+1 day');
                return $morgen->format('d.m.Y');
            }
            return $this->helper->german_date_no_time($vertrag['start'], false);
        }

        return $this->helper->german_date_no_time($vertrag['naechste_faelligkeit'], false);
    }

    public function get_monats_umsatz($vertrag)
    {
        $preis                = floatval($vertrag['artikel_preis']);
        $zyklus_anzahl_monate = intval($vertrag['zyklus_anzahl_monate']);

        if($zyklus_anzahl_monate == 1) return $preis;
        else return $preis / $zyklus_anzahl_monate;
    }
        
}