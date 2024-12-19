<?php 


    class Statistik {

        private $helper; 
        private $rechnung;
        private $rechnung_zahlung;

        public function __construct($helper, $rechnung, $rechnung_zahlung) 
        {
            $this->helper            = $helper;
            $this->rechnung          = $rechnung;
            $this->rechnung_zahlung  = $rechnung_zahlung;
        }


        public function get_gesamt_zahlung_monat()
        {
            $jahr = date('Y');
            $monat = date('m');

            $zahlung = $this->rechnung_zahlung->get_gesamt_zahlung_monat(
                $jahr,
                $monat
            );

            return $zahlung;

        }

        public function get_anzahl_bezahlte_rechnungen()
        {
            $jahr = date('Y');
            $monat = date('m');

            $zahlung = $this->rechnung_zahlung->get_anzahl_bezahlte_rechnungen_monat(
                $jahr,
                $monat
            );

            if($zahlung == null) return 0;

            return $zahlung;

        }

        public function get_anzahl_faellige_rechnungen_monat()
        {
            $jahr = date('Y');
            $monat = date('m');

            $zahlung = $this->rechnung->get_anzahl_faellige_rechnungen_monat(
                $jahr,
                $monat
            );

            return $zahlung; 

        }

        public function get_monats_statistik($jahr) 
        {
            $monate = array(
                '1'   => array('zahlungseigang' => 0, 'rechnungsausgang' => 0, 'monat' => 'Jan'),
                '2'   => array('zahlungseigang' => 0, 'rechnungsausgang' => 0, 'monat' => 'Feb'),
                '3'   => array('zahlungseigang' => 0, 'rechnungsausgang' => 0, 'monat' => 'Mär'),
                '4'   => array('zahlungseigang' => 0, 'rechnungsausgang' => 0, 'monat' => 'Apr'),
                '5'   => array('zahlungseigang' => 0, 'rechnungsausgang' => 0, 'monat' => 'Mai'),
                '6'   => array('zahlungseigang' => 0, 'rechnungsausgang' => 0, 'monat' => 'Jun'),
                '7'   => array('zahlungseigang' => 0, 'rechnungsausgang' => 0, 'monat' => 'Jul'),
                '8'   => array('zahlungseigang' => 0, 'rechnungsausgang' => 0, 'monat' => 'Aug'),
                '9'   => array('zahlungseigang' => 0, 'rechnungsausgang' => 0, 'monat' => 'Sep'),
                '10'  => array('zahlungseigang' => 0, 'rechnungsausgang' => 0, 'monat' => 'Okt'),
                '11'  => array('zahlungseigang' => 0, 'rechnungsausgang' => 0, 'monat' => 'Nov'),
                '12'  => array('zahlungseigang' => 0, 'rechnungsausgang' => 0, 'monat' => 'Dez')
            ); 
            
            for($i= 1; $i<=12; $i++) {
                $zahlungsbetrag_summe  = $this->rechnung_zahlung->get_zahlungsbetrag_summe($jahr, $i);
                $rechnungsausgang_summe = $this->rechnung->get_rechnungsausgang_summe($jahr, $i);
                
                if($zahlungsbetrag_summe != null) $monate[$i]['zahlungseigang']   = $zahlungsbetrag_summe;
                if($rechnungsausgang_summe != null) $monate[$i]['rechnungsausgang'] = $rechnungsausgang_summe;
            }

            return $monate;
        }

        
        


        


        

        

    }