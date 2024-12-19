<?php 

    include dirname(__FILE__).'/../init.php';
    $start_time = microtime(true);

    
    class Cronjob_Abonnements {

        private $helper;
        private $abonnement;
        private $abonnement_vertrag;
        private $rechnung;
        private $email;

        CONST PARKWIN_API_ARTIKEL_NUMMER = '10136';
        CONST ZAMMAD_API_ARTIKEL_NUMMER = '10135';

 
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

            $has_parkwin = false;
            $has_zammad = false;
            $erstellte_rechnungen = 0;

            foreach($this->abonnements AS $abonnement) {

                //Nur aktive Verträge nehmen
                $vertraege = $this->abonnement_vertrag->get_all($abonnement['abonnement_id'], 'aktiv');

                $abzurechnende_vertraege = array();

                if(!is_array($vertraege)) continue; 

                foreach($vertraege AS $vertrag) {

                    $start = new DateTime($vertrag['start']);
                
                    //Wenn Start in Zukunft ist, dann ignorieren
                    if($start > $this->heute) continue;

                  
                    if($this->ubepruefe_ob_vertrag_rechnung_faellig($vertrag) == false) continue;

                    if($vertrag['artikel_nummer'] == self::PARKWIN_API_ARTIKEL_NUMMER) $has_parkwin = true;
                    if($vertrag['artikel_nummer'] == self::ZAMMAD_API_ARTIKEL_NUMMER) $has_zammad = true;

                    array_push(
                        $abzurechnende_vertraege,
                        $vertrag
                    );

                }

                var_dump($vertrag['artikel_nummer']);
                echo "<br><br>";
                
                if((sizeof($abzurechnende_vertraege) == 0) && ($has_parkwin == false) && ($has_zammad == false)) continue;


                $rechnung = $this->abonnement->erstelle_rechnung_aus_vertraegen(
                    $abonnement, 
                    $abzurechnende_vertraege,
                    $has_parkwin,
                    $has_zammad,
                    self::PARKWIN_API_ARTIKEL_NUMMER,
                    self::ZAMMAD_API_ARTIKEL_NUMMER
                );
                
                $erstellte_rechnungen++;
                    
            }

            return $erstellte_rechnungen;

        }


        /*
            Hier wird überprüft, ob der Vertrag für eine nächste Rechnung fällig ist. 
            Entscheidend ist dabei das Fälligkeitsdatum und der Zyklus. 
            Beispiel: Heute ist der 15.11.2024 
            Wenn Fälligkeit größer oder gleich das Datum, dann muss Rechnung erstellt werden 
            Gibt false zurück, wenn nicht fällig
            Gibt true zurück, wenn fällig
        */

        public function ubepruefe_ob_vertrag_rechnung_faellig($vertrag)
        {
            if($vertrag['naechste_faelligkeit'] == null) return true;
            
            $naechste_faelligkeit = new DateTime($vertrag['naechste_faelligkeit']);

            if($naechste_faelligkeit <= $this->heute) return true;
            else return false;
        }

  
        

        

    }

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