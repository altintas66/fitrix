<?php 

    include dirname(__FILE__).'/../init.php';
    $start_time = microtime(true);


    class Cronjob_Zahlungserinnerungen {

        private $helper;
        private $rechnung;
        private $rechnung_zahlungserinnerung;
        private $einstellungen;

        private $heute;

        public function __construct($helper, $rechnung, $rechnung_zahlungserinnerung, $einstellungen) 
        {

            $this->helper                       = $helper;
            $this->rechnung                     = $rechnung;
            $this->rechnung_zahlungserinnerung  = $rechnung_zahlungserinnerung;
            $this->einstellungen                = $einstellungen->get_all();
            $this->heute                        = new DateTime(date('Y-m-d'));

        }

        public function zahlungserinnerungen_fuer_rechnungen()
        {

            $rechnungen = $this->rechnung->get_all('offen');
           
            foreach($rechnungen AS $rechnung) {

                //Überprüfen, ob es bereits eine Zahlungserinnerung gibt
                if($rechnung['rechnung_zahlungserinnerung_id'] != null) continue;
                $faellig_am = new DateTime($rechnung['faellig_am']);
             
                if($faellig_am > $this->heute) continue;
              
               $sollte_zahlen_am = $faellig_am->modify('+'.intval($this->einstellungen['zahlungserinnerung_senden_nach_x_tagen']).' day');
               if($this->heute >= $sollte_zahlen_am) {
                    $this->rechnung_zahlungserinnerung->insert(array(
                        'rechnung_id' => $rechnung['rechnung_id']
                    ));
               }

            }

        }

    }

    $cronjob_zahlungserinnerungen = new Cronjob_Zahlungserinnerungen(
        $c_helper,
        $c_rechnung,
        $c_rechnung_zahlungserinnerung,
        $c_einstellungen
    );

    $cronjob_zahlungserinnerungen->zahlungserinnerungen_fuer_rechnungen();