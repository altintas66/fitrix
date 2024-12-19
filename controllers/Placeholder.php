<?php 

class Placeholder {

    private $db;
    private $helper;
    private $einstellungen;
    
    private $fields;
    private $tablename; 


    public function __construct($c_db, $helper, $einstellungen) 
    {
        $this->db            = $c_db;
        $this->helper        = $helper;
        $this->einstellungen = $einstellungen;

        $this->set_tablename();
        $this->set_fields();
    }

    public function set_fields() 
    {
        $this->fields = "
            ".$this->get_tablename().".id            AS 'placeholder_id', 
            ".$this->get_tablename().".name          AS 'name', 
            ".$this->get_tablename().".beschreibung  AS 'beschreibung',
            ".$this->get_tablename().".placeholder   AS 'placeholder'
        ";
    }

    public function set_tablename() 
    {
        $this->tablename = 'placeholder';
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

    
    public function get_placeholders_html($placeholders) {
        global $c_html;
        $html = '<div class=" mt-20 mb-20">';

        foreach($placeholders AS $place) {
            $html .= $c_html->get_badge($place['placeholder']);
        }
        $html .= '</div>';

        return $html;
        
    }

    public function replace_placeholder_inhalt($inhalt_id, $text, Array $objekte) 
    {

        global $c_inhalt_placeholder;
        $placeholders = $c_inhalt_placeholder->get_all($inhalt_id);
        
        return $this->replace_placeholders($placeholders, $text, $objekte);

    }

    public function replace_placeholders($placeholders, $text, $objekte) 
    {
        foreach($placeholders AS $placeholder) {
            $text = str_replace(
                $placeholder['placeholder'], 
                $this->replace_placeholder($placeholder['placeholder'], $objekte), 
                $text
            );
        }

        return $text;
    }


    public function replace_placeholder($placeholder, $objects) {

        global $c_url, $c_html;


        if($placeholder == '##kunde_firmen_name##' && array_key_exists('angebot', $objects)) return $objects['angebot']['kunde_firmen_name'];
        else if($placeholder == '##kunde_firmen_name##' && array_key_exists('abonnement', $objects)) return $objects['abonnement']['kunde_firmen_name'];
        else if($placeholder == '##kunde_firmen_name##' && array_key_exists('rechnung', $objects)) return $objects['rechnung']['kunde_firmen_name'];
        else if($placeholder == '##angebot_id##') return $objects['angebot']['angebotsnummer'];
        else if($placeholder == '##rechnung_id##') return $objects['rechnung']['rechnungsnummer'];
        else if($placeholder == '##rechnung_gesamtbetrag##') return $c_html->waehrung($objects['rechnung']['gesamt_brutto']);
        else if($placeholder == '##abonnement_id##') return $objects['abonnement']['abonnementnummer'];
        else if($placeholder == '##faellig_am_datum##') return $this->helper->german_date_no_time($objects['rechnung']['faellig_am']);
        else if($placeholder == '##mahnung_betrag##') return $c_html->waehrung($einstellungen['mahnung_betrag']);
        else if($placeholder == '##rechnung_tage_der_faelligkeit##') return '';
        
        
    }

    
    
    
    
    
    
    


}