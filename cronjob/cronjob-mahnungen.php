<?php 

    include dirname(__FILE__).'/../init.php';
    $start_time = microtime(true);


    class Cronjob_Mahnungen {

        private $helper;
        private $rechnung;
        private $mahnung;
        private $einstellungen;

        private $heute;

        public function __construct($helper, $rechnung, $mahnung, $einstellungen) 
        {

            $this->helper                       = $helper;
            $this->rechnung                     = $rechnung;
            $this->mahnung                      = $mahnung;
            $this->einstellungen                = $einstellungen->get_all();
            $this->heute                        = new DateTime(date('Y-m-d'));

        }

        public function mahnungen_fuer_rechnungen()
        {

            $rechnungen = $this->rechnung->get_all('offen');
           
            foreach($rechnungen AS $rechnung) {

                //Überprüfen, ob es bereits eine Zahlungserinnerung gibt. Wenn nicht, keine Mahnung senden
                if($rechnung['rechnung_zahlungserinnerung_id'] == null) continue;
                $faellig_am = new DateTime($rechnung['faellig_am']);
             
                if($faellig_am > $this->heute) continue;
                if($rechnung['zahlungen'] == null) continue; //Wenn es keine Zahlungen gibt
                if($rechnung['mahnungen'] != null) continue; //Wenn es bereits eine Mahnung gibt, dann keine senden
              
               $sollte_zahlen_am = $faellig_am->modify('+'.intval($this->einstellungen['mahnungen_senden_nach_x_tagen']).' day');
               
               if($this->heute >= $sollte_zahlen_am) {
                    $this->mahnung->insert(array(
                        'rechnung_id' => $rechnung['rechnung_id']
                    ));
               }

            }

        }

    }

    $cronjob_mahnungen = new Cronjob_Mahnungen(
        $c_helper,
        $c_rechnung,
        $c_mahnung,
        $c_einstellungen
    );

    $cronjob_mahnungen->mahnungen_fuer_rechnungen();