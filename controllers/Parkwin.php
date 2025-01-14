<?php 

    class Parkwin 
    {

        private $helper;

        public function __construct($helper)
        {
            $this->helper = $helper;
        }

        public function berechne_kosten($menge) {

            $preis = 0;
            $artikel_beschreibung = $menge.' Buchungen ';

            if($menge >= 1500) {
                $preis = 750.00;
                $artikel_beschreibung .= '(Kostenairbarg 750€)';
                $menge = 1;
            } else if($menge >= 1000) {
                $preis = 0.50;
                $artikel_beschreibung .= '(0,50 € pro Buchung)';
            } else if($menge >= 500) {
                $preis = 0.60;
                $artikel_beschreibung .= '(0,60 € pro Buchung)';
            } else if($menge >= 250) {
                $preis = 0.70;
                $artikel_beschreibung .= '(0,70 € pro Buchung)';
            } else if($menge >= 150) {
                $preis = 0.90;
                $artikel_beschreibung .= '(0,90 € pro Buchung)';
            } else if($menge > 0) {
                $preis = 150;
                $artikel_beschreibung .= '(Mindestpreis 150€)';
                $menge = 1;
            }

            return array(
                'preis'                 => $preis,
                'artikel_beschreibung'  => $artikel_beschreibung,
                'menge'                 => $menge
            ); 

        }

    }
