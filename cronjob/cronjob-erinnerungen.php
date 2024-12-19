<?php 

    include dirname(__FILE__).'/../init.php';
    $start_time = microtime(true);


    class Cronjob_Erinnerung {

        private $helper;
        private $angebot;
        private $erinnerung;
        private $einstellungen;

        private $heute;

        public function __construct($helper, $angebot, $erinnerung, $einstellungen) 
        {

            $this->helper             = $helper;
            $this->angebot            = $angebot;
            $this->erinnerung         = $erinnerung;
            $this->einstellungen      = $einstellungen->get_all();
            $this->heute              = new DateTime(date('Y-m-d'));

        }

        public function erinnerungen_fuer_angebote()
        {
            $angebote = $this->angebot->get_all('offen');

            if($angebote == null) return;

           
            foreach($angebote AS $angebot) {

                $bearbeitet_am = new DateTime($angebot['bearbeitet_am']);
                $erinnern_in   = intval($this->einstellungen['angebot_erinnerin_in_tagen']);

                if($bearbeitet_am <= $this->heute) continue;
                if($bearbeitet_am->modify('+'.$erinnern_in.' day') < $this->heute) continue;

                //Überprüfe, ob es dazu bereits ein Eintrag gibt, und auf ignorieren gestellt ist
                $eintrag = $this->erinnerung->get_by_eintrag($angebot['angebot_id'], 'angebot');

              
                
                if($eintrag != null) {
                    if($eintrag['ignorieren_bis'] != null) {
                        $ignorieren_bis = new DateTime($eintrag['ignorieren_bis']);
                        if($this->heute < $ignorieren_bis) continue;
                    }
                }

                $this->erinnerung->insert(array(
                    'eintrag_id' => $angebot['angebot_id'],
                    'user_id'    => $angebot['user_id'],
                    'typ'        => 'angebot',
                    'text'       => 'Angebot wurde seit '.$erinnern_in.' Tagen nicht mehr aktualisiert!'
                ));

            }

        }

    }

    $cronjob_erinnerung = new Cronjob_Erinnerung(
        $c_helper,
        $c_angebot,
        $c_erinnerung,
        $c_einstellungen
    );

    $cronjob_erinnerung->erinnerungen_fuer_angebote();