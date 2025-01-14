<?php 

    class Quality_Hosting_CSV_Rechnung {

        private $db;
        private $helper;
        private $kunde;

        private $fields;
        private $tablename;

        public function __construct($db, $helper, $kunde) 
        {
            
            $this->db                 = $db;
            $this->helper             = $helper;
            $this->kunde              = $kunde;

            
            $this->set_tablename();
            $this->set_fields($this->get_tablename());
            
        }

        public function set_fields($tablename) 
        {
            $this->fields = "
                ".$tablename.".id                           AS 'qualityhosting_csv_rechnung_id', 
                ".$tablename.".erstellt_am                  AS 'erstellt_am', 
                ".$tablename.".dateiname                    AS 'dateiname'
            ";
        }


        
        public function set_tablename() 
        {
            $this->tablename = 'qualityhosting_csv_rechnung';
        }
        
        public function get_fields()
        {
            return $this->fields;
        }
        
        public function get_tablename()
        {
            return $this->tablename;
        }



        public function insert($dateiname)
        {
            $date = $this->helper->get_english_datetime_now();

            $sql = "INSERT INTO ".$this->get_tablename()." VALUES(
                NULL, 
                '".$date."',
                '".$dateiname."'
            )";

            $result_insert = $this->db->insert($sql);
            $id = $this->db->get_last_inserted_id();
    
            return array(
                'id'     => $id,
                'result' => $result_insert
            );

  
        }

        

        public function validate_header($header)
        {
            if(str_contains($header, 'LineItemText')) return false;
            else return true;
        }

        

        public function get_rechnungsvorlagen($kunden, $dateiname)
        {
            
            $datei = file_get_contents(dirname(__FILE__).'/../upload/'.$dateiname);
            if(($datei == false) || ($datei == null)) {
                return array(
                    'result'   => false,
                    'message'  => 'Datei konnte nicht geöffnet werden'
                );
            }

            $reseller_customer_ids = array();
         

            foreach($kunden AS $kunde) {
                $reseller_customer_ids[$kunde['quality_hosting_reseller_customer_id']] = array();
            }

            $csv_content_rows = $this->get_csv_content_rows($datei);
            if($csv_content_rows == false) {
                return array(
                    'result'   => false,
                    'message'  => 'Positionen konnten nicht gelesen werden'
                );
            }

            $result = $this->insert($dateiname);

            if($this->validate_header($csv_content_rows[0]) == false) {
                return array(
                    'result'  => false,
                    'message' => 'Die Spalte LineItemText muss entfernt werden!'
                );
            }
           
            $rechnungsvorlagen = $this->get_csv_positionen($reseller_customer_ids, $csv_content_rows);

            

            return array(
                'result'            => true,
                'rechnungsvorlagen' => $rechnungsvorlagen,
                'dateiname'         => $dateiname
            );
        }

        public function get_csv_content_rows($datei)
        {
            
            $rows = preg_split('/\r\n|\n|\r/', $datei);

            if( (is_array($rows) == false) || ($rows == null) || ($rows == false) ) {
                return false;
            }

            return $rows;
        }

        public function get_csv_positionen($reseller_customer_ids, $rows)
        {
            
            $counter = 0;
          
            foreach ($rows as $row) {
                $counter++;
                if($counter == 1) continue;
                if (!empty($row)) {
                    $columns = str_getcsv($row, ';');
                    $eintraege = $this->get_csv_position($columns);
                    if($eintraege == null) continue;
                    if(isset($reseller_customer_ids[$eintraege['reseller_customer_id']])) {
                        array_push(
                            $reseller_customer_ids[$eintraege['reseller_customer_id']], 
                            $eintraege
                        );
                    }
                }
            }

            return $reseller_customer_ids;

        }

        public function get_csv_position($row)
        {

            $anzahl               = $row[10];
            $preis                = $row[11];
            $total                = $row[12];
            $artikelname          = $row[23];
            $reseller_customer_id = $row[28];
    
            return array(
                'reseller_customer_id' => $reseller_customer_id,
                'artikelname'          => $artikelname,
                'anzahl'               => $anzahl,
                'preis'                => $preis,
                'total'                => $total
            );
        }

    }