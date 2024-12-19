<?php 

use Dompdf\Dompdf;

class PDF {

    private $helper;
    private $config;

    private $angebote_pfad;
    private $rechnungen_pfad;
    private $rechnungen_xml_pfad;
    private $abonnements_pfad;
    private $mahnungen_pfad;


    public function __construct($helper, $config)
    {
        $this->helper = $helper;
        $this->config = $config;

        $this->angebote_pfad       = $config['angebote_pfad'];
        $this->rechnungen_pfad     = $config['rechnungen_pfad'];
        $this->rechnungen_xml_pfad = $config['rechnungen_xml_pfad'];
        $this->abonnements_pfad    = $config['abonnements_pfad'];
        $this->mahnungen_pfad      = $config['mahnungen_pfad'];
    }

    public function generiere_angebot_pdf($id) 
    {
        global $c_angebot, $c_helper, $c_html, $c_einstellungen;
        $angebot = $c_angebot->get($id);

        $angebotsnummer = $angebot['angebotsnummer'];

        require_once dirname(__FILE__).'/../php/dompdf/autoload.inc.php';
	
        $dompdf = new Dompdf(
            array(
                'enable_remote'       => true, 
                'isRemoteEnabled'     => true,
                'isPhpEnabled'        => true,
                'enable_html5_parser' => true,
                'isJavascriptEnabled' => true,
                'chroot'              => ''
            )
        );

        $header_left  = $angebot['agentur_firmen_name'].' - '.$angebot['agentur_strasse'].' '.$angebot['agentur_plz'].' '.$angebot['agentur_ort'];
        $header_right = $angebot['agentur_webseite'];
        
        include dirname(__FILE__).'/../includes/templates/pdf/angebot.php';
 
        //Vorschau
        //echo $html; exit();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->getOptions()->set('defaultFont', 'helvetica');
        
        
        $dompdf->render();
        
        $canvas = $dompdf->get_canvas();
        $footer = $canvas->open_object();
        
        $w = $canvas->get_width();
        $h = $canvas->get_height();
        $font = $dompdf->getOptions()->getDefaultFont();
        
        $grau = array(0.85, 0.85, 0.85);
        $dunkelgrau = array(0.5, 0.5, 0.5);

        $footer_eins  = $angebot['agentur_firmen_name'].' - '.$angebot['agentur_strasse'].' '.$angebot['agentur_plz'].' '.$angebot['agentur_ort'].' - '.$angebot['agentur_telefon'].' - '.$angebot['agentur_email'];
        $footer_zwei  = 'Umsatzsteuer-ID: '.$angebot['agentur_umsatzsteuer_id'].' / IBAN: '.$angebot['agentur_iban'].' / Bank: '.$angebot['agentur_bank'];
        
        $canvas->page_text($w-80, $h-22, 'Seite {PAGE_NUM} von {PAGE_COUNT}', $font, 7, $dunkelgrau);
        $canvas->page_text($w-560, $h-36, $footer_eins, $font, 8, $dunkelgrau);
        $canvas->page_text($w-560, $h-26, $footer_zwei, $font, 8, $dunkelgrau);

        $canvas->close_object();
        $canvas->add_object($footer, "all");
        

        $dateiname = $angebotsnummer.'.pdf';
    
       
        $result = file_put_contents($this->angebote_pfad.$dateiname, $dompdf->output());
     
        return $dateiname;
        
    }

    public function generiere_rechnung_pdf($id) 
    {
       
        global $c_rechnung, $c_helper, $c_html, $c_einstellungen, $c_rechnung_position, $c_xml;
        $rechnung = $c_rechnung->get($id);
        $rechnung_positionen = $c_rechnung_position->get_all($id);
        
     

        $rechnungsnummer = $rechnung['rechnungsnummer'];

        require_once dirname(__FILE__).'/../php/dompdf/autoload.inc.php';
	
        $dompdf = new Dompdf(
            array(
                'enable_remote'       => true,
                'isRemoteEnabled'     => true,
                'isPhpEnabled'        => true,
                'enable_html5_parser' => true,
                'isJavascriptEnabled' => true,
                'chroot'              => ''
            )
        );

        $header_left  = $rechnung['agentur_firmen_name'].' - '.$rechnung['agentur_strasse'].' '.$rechnung['agentur_plz'].' '.$rechnung['agentur_ort'];
        $header_right = $rechnung['agentur_webseite'];
        
        include dirname(__FILE__).'/../includes/templates/pdf/rechnung.php';
 
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->getOptions()->set('defaultFont', 'helvetica');
        
        
        $dompdf->render();
        
        $canvas = $dompdf->get_canvas();
        $footer = $canvas->open_object();
        
        $w = $canvas->get_width();
        $h = $canvas->get_height();
        $font = $dompdf->getOptions()->getDefaultFont();
        
        $grau = array(0.85, 0.85, 0.85);
        $dunkelgrau = array(0.5, 0.5, 0.5);

        $footer_eins  = $rechnung['agentur_firmen_name'].' - '.$rechnung['agentur_strasse'].' '.$rechnung['agentur_plz'].' '.$rechnung['agentur_ort'].' - '.$rechnung['agentur_telefon'].' - '.$rechnung['agentur_email'];
        $footer_zwei  = 'Umsatzsteuer-ID: '.$rechnung['agentur_umsatzsteuer_id'].' / IBAN: '.$rechnung['agentur_iban'].' / Bank: '.$rechnung['agentur_bank'];
        
        $canvas->page_text($w-80, $h-22, 'Seite {PAGE_NUM} von {PAGE_COUNT}', $font, 7, $dunkelgrau);
        $canvas->page_text($w-560, $h-36, $footer_eins, $font, 8, $dunkelgrau);
        $canvas->page_text($w-560, $h-26, $footer_zwei, $font, 8, $dunkelgrau);

        $canvas->close_object();
        $canvas->add_object($footer, "all");
        

        $dateiname = $rechnungsnummer.'.pdf';    
        $dateiname_xml = $rechnungsnummer.'.xml';    
       
        $result = file_put_contents($this->rechnungen_pfad.$dateiname, $dompdf->output());
       
        $xml = $c_xml->generateEInvoiceXML($rechnung, $rechnung_positionen);
        
        $result_xml = file_put_contents($this->rechnungen_xml_pfad.$dateiname_xml, $xml);


        return array(
			'dateiname'            => $dateiname,
			'dateiname_e_rechnung' => $dateiname_xml
		);
    }


    public function generiere_abonnement_pdf($id) 
    {
        global $c_abonnement, $c_helper, $c_html, $c_einstellungen;
        $abonnement = $c_abonnement->get($id);

        $abonnementnummer = $abonnement['abonnementnummer'];

        require_once dirname(__FILE__).'/../php/dompdf/autoload.inc.php';
	
        $dompdf = new Dompdf(
            array(
                'enable_remote'       => true, 
                'isRemoteEnabled'     => true,
                'isPhpEnabled'        => true,
                'enable_html5_parser' => true,
                'isJavascriptEnabled' => true,
                'chroot'              => ''
            )
        );

        $header_left  = $abonnement['agentur_firmen_name'].' - '.$abonnement['agentur_strasse'].' '.$abonnement['agentur_plz'].' '.$abonnement['agentur_ort'];
        $header_right = $abonnement['agentur_webseite'];
        
        include dirname(__FILE__).'/../includes/templates/pdf/abonnement.php';
 
        //Vorschau
        //echo $html; exit();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->getOptions()->set('defaultFont', 'helvetica');
        
        
        $dompdf->render();
        
        $canvas = $dompdf->get_canvas();
        $footer = $canvas->open_object();
        
        $w = $canvas->get_width();
        $h = $canvas->get_height();
        $font = $dompdf->getOptions()->getDefaultFont();
        
        $grau = array(0.85, 0.85, 0.85);
        $dunkelgrau = array(0.5, 0.5, 0.5);

        $footer_eins  = $abonnement['agentur_firmen_name'].' - '.$abonnement['agentur_strasse'].' '.$abonnement['agentur_plz'].' '.$abonnement['agentur_ort'].' - '.$abonnement['agentur_telefon'].' - '.$abonnement['agentur_email'];
        $footer_zwei  = 'Umsatzsteuer-ID: '.$abonnement['agentur_umsatzsteuer_id'].' / IBAN: '.$abonnement['agentur_iban'].' / Bank: '.$abonnement['agentur_bank'];
        
        $canvas->page_text($w-80, $h-22, 'Seite {PAGE_NUM} von {PAGE_COUNT}', $font, 7, $dunkelgrau);
        $canvas->page_text($w-560, $h-36, $footer_eins, $font, 8, $dunkelgrau);
        $canvas->page_text($w-560, $h-26, $footer_zwei, $font, 8, $dunkelgrau);

        $canvas->close_object();
        $canvas->add_object($footer, "all");
        

        $dateiname = $abonnementnummer.'.pdf';
    
       
        $result = file_put_contents($this->abonnements_pfad.$dateiname, $dompdf->output());
        
        return $dateiname;
        
    }

    public function generiere_mahnung_pdf($id) 
    {
       
        global $c_rechnung, $c_helper, $c_html, $c_einstellungen, $c_mahnung;
        $mahnung = $c_mahnung->get($id);
        $rechnung = $c_rechnung->get($mahnung['fk_rechnung_id']);
        $einstellungen = $c_einstellungen->get_all();
       
       

        $rechnungsnummer = $rechnung['rechnungsnummer'];

        require_once dirname(__FILE__).'/../php/dompdf/autoload.inc.php';
	
        $dompdf = new Dompdf(
            array(
                'enable_remote'       => true,
                'isRemoteEnabled'     => true,
                'isPhpEnabled'        => true,
                'enable_html5_parser' => true,
                'isJavascriptEnabled' => true,
                'chroot'              => ''
            )
        );

        $header_left  = $rechnung['agentur_firmen_name'].' - '.$rechnung['agentur_strasse'].' '.$rechnung['agentur_plz'].' '.$rechnung['agentur_ort'];
        $header_right = $rechnung['agentur_webseite'];
        
        include dirname(__FILE__).'/../includes/templates/pdf/mahnung.php';
 
          //Vorschau
        //echo $html; exit();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->getOptions()->set('defaultFont', 'helvetica');
        
        
        $dompdf->render();
        
        $canvas = $dompdf->get_canvas();
        $footer = $canvas->open_object();
        
        $w = $canvas->get_width();
        $h = $canvas->get_height();
        $font = $dompdf->getOptions()->getDefaultFont();
        
        $grau = array(0.85, 0.85, 0.85);
        $dunkelgrau = array(0.5, 0.5, 0.5);

        $footer_eins  = $rechnung['agentur_firmen_name'].' - '.$rechnung['agentur_strasse'].' '.$rechnung['agentur_plz'].' '.$rechnung['agentur_ort'].' - '.$rechnung['agentur_telefon'].' - '.$rechnung['agentur_email'];
        $footer_zwei  = 'Umsatzsteuer-ID: '.$rechnung['agentur_umsatzsteuer_id'].' / IBAN: '.$rechnung['agentur_iban'].' / Bank: '.$rechnung['agentur_bank'];
        
        $canvas->page_text($w-80, $h-22, 'Seite {PAGE_NUM} von {PAGE_COUNT}', $font, 7, $dunkelgrau);
        $canvas->page_text($w-560, $h-36, $footer_eins, $font, 8, $dunkelgrau);
        $canvas->page_text($w-560, $h-26, $footer_zwei, $font, 8, $dunkelgrau);

        $canvas->close_object();
        $canvas->add_object($footer, "all");
         

        $dateiname = 'MA-'.$rechnungsnummer.'.pdf';    
         
       
        $result = file_put_contents($this->mahnungen_pfad.$dateiname, $dompdf->output());
       
        

        return array(
			'dateiname'            => $dateiname
		);
    }



    public function get_abonnement_pdf_url($dateiname) 
    {
        return $this->config['abonnements_pfad_url'].$dateiname;
    }

    public function get_abonnement_pdf_pfad($dateiname) 
    {
        return $this->config['abonnements_pfad'].$dateiname;
    }

    public function get_angebot_pdf_url($dateiname) 
    {
        return $this->config['angebote_pfad_url'].$dateiname;
    }

    public function get_angebot_pdf_pfad($dateiname) 
    {
        return $this->config['angebote_pfad'].$dateiname;
    }

    public function get_mahnung_pdf_pfad($dateiname) 
    {
        return $this->config['mahnungen_pfad'].$dateiname;
    }


    public function get_rechnung_pdf_url($dateiname) 
    {
        return $this->config['rechnungen_pfad_url'].$dateiname;
    }

    public function get_rechnung_pdf_pfad($dateiname) 
    {
        return $this->config['rechnungen_pfad'].$dateiname;
    }
    public function get_rechnungen_xml_pfad($dateiname) 
    {
        return $this->config['rechnungen_xml_pfad'].$dateiname;
    }
    


}