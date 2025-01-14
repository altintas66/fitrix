<?php 

    

    
    class Cronjob_Abonnements {

        private $helper;
        private $abonnement;
        private $abonnement_vertrag;
        private $rechnung;
        private $email;
 
        private $abonnements;
        private $heute;

        public function __construct($helper, $abonnement, $abonnement_vertrag, $rechnung, $email) 
        {

            $this->helper             = $helper;
            $this->abonnement         = $abonnement;
            $this->abonnement_vertrag = $abonnement_vertrag;
            $this->rechnung           = $rechnung;
            $this->email              = $email;

            $this->abonnements = $this->abonnement->get_all('aktiv');
            $this->heute       = new DateTime(date('Y-m-d'));


        }

        public function erstelle_abo_rechnungen()
        {
            if($this->abonnements == null) exit();
            if(!is_array($this->abonnements)) exit();

            $erstellte_rechnungen = 0;

            foreach($this->abonnements AS $abonnement) {
                

                $rechnung = $this->abonnement->erstelle_rechnung_aus_vertraegen(
                    $abonnement['abonnement_id'],
                );
                
                $erstellte_rechnungen++;
                    
            }

            return $erstellte_rechnungen;

        }


    }

    $start_time = microtime(true);

    $cronjob_abonnements = new Cronjob_Abonnements(
        $c_helper,
        $c_abonnement,
        $c_abonnement_vertrag,
        $c_rechnung,
        $c_email
    );

    $erstellte_rechnungen = $cronjob_abonnements->erstelle_abo_rechnungen();

    $datum = new DateTime();

    $end_time = microtime(true);
    $execution_time = $end_time - $start_time;
    $ausgefuehrt_am = date('d.m.Y H:i:s');

    echo $ausgefuehrt_am."<br>";
    echo "Skript-Ausführungszeit: ". $execution_time ." Sekunden";

    $info = array(
        'Erstelle Rechnungen' => $erstellte_rechnungen
    );

    $c_cronjob->insert(array(
        'url'                => $_SERVER['PHP_SELF'],
        'ausfuehrungszeit'   => $execution_time,
        'anmerkungen'        => 'Abonnement Rechnungserstellung für '.$datum->format('d.m.Y'),
        'json'               => $info
    ));