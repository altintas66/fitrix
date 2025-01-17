<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Email {

	
	private $helper;
	private $email_log;

	
	
	public function __construct($helper, $email_log) 
	{
		$this->helper      = $helper;
		$this->email_log   = $email_log;
	} 
 
	public function get_mail_connection() 
	{
		require_once dirname(__FILE__).'/../php/PHPMailer/src/Exception.php';
		require_once dirname(__FILE__).'/../php/PHPMailer/src/PHPMailer.php';
		require_once dirname(__FILE__).'/../php/PHPMailer/src/SMTP.php';

		global $einstellungen;

		$phpMailer = new PHPMailer(); 
		//$phpMailer->SMTPDebug = 2;
        $phpMailer->isSMTP();
        $phpMailer->Host = $einstellungen['smtp_server'];
        $phpMailer->SMTPAuth = true;
        $phpMailer->Username = $einstellungen['smtp_email'];
        $phpMailer->Password = $einstellungen['smtp_passwort'];  
        $phpMailer->SMTPSecure = "tls";
        $phpMailer->Port = 587;
		$phpMailer->CharSet = "UTF-8";
        $phpMailer->isHTML(true);
		$phpMailer->setFrom($einstellungen['smtp_email'], $einstellungen['firmen_name']);

		return $phpMailer;
	}
	
		
	public function email_senden($empfaenger_email, $betreff, $inhalt, $bcc = false, $attachments = NULL) 
	{
		global $config, $einstellungen;

		if(isset($config['email_test_modus']) && ($config['email_test_modus'] == true)) $empfaenger_email = 'altintas@inoya.de';

		$phpMailer = $this->get_mail_connection();
		$phpMailer->addAddress($empfaenger_email);
        $phpMailer->Subject = $betreff;
        $phpMailer->Body = $inhalt;


		if ($bcc != false) {
			//$phpMailer->addBCC($bcc);
		}

		

		if(($attachments != NULL) && (is_array($attachments))) {
			foreach($attachments AS $attachment) {
				$phpMailer->AddAttachment($attachment['path']);
			}
		}

		if(!$phpMailer->send()) $result = 0;
		else $result =  1;

		return $result;

	}

	public function replace_rn_with_br($text) 
	{
		$text = str_replace("\\r\\n", '<br>', $text);
		return $text;
	}
	
	public function add_row($label, $value) 
	{
		$html = '<tr style="padding: .75rem; vertical-align: top; border-top: 1px solid #dee2e6;">';
			$html .= '<td style="width:35%">'.$label.'</td>';
			$html .= '<td style="width:75%">'.$value.'</td>';
		$html .= '</tr>';
		return $html;		
	}
	
	

	public function administrator_email($nachricht) 
	{
		global $einstellungen, $config;
		$empfaenger_email = 'altintas@inoya.de';

		$betreff = 'Datenbank Fehler '.$einstellungen['firmen_name'];
		$inhalt = '<p>'.$nachricht.'</p>';

		$smtp_response = $this->email_senden(
			$empfaenger_email, 
			$betreff, 
			$inhalt,
			false
		);

		$this->email_log->insert(array(
			'eintrag_id'    => NULL,
			'empfaenger'    => $empfaenger_email,
			'betreff'       => $betreff,
			'text'          => $inhalt,
			'smtp_response' => $smtp_response,
			'eintrag_typ'   => 'datenbank_fehler'
		));

		return $smtp_response;
	}

	public function angebot_senden($angebot_id) {
		
		global $c_angebot, $c_inhalt, $c_pdf, $c_placeholder;
		
		$angebot = $c_angebot->get($angebot_id);
		$inhalt  = $c_inhalt->get_by_metakey('email_angebot_inhalt');

		if(($angebot['kunde_email'] == '') && ($angebot['kunde_email_angebot_rechnung'] == '')) {
			return array(
				'result'  => false,
				'message' => 'E-Mail Adresse des Kunden ist leer. Versand nicht möglich'
			);
		}

		if($angebot['kunde_email_angebot_rechnung'] != '') $empfaenger_email = $angebot['kunde_email_angebot_rechnung'];
		else $empfaenger_email = $angebot['kunde_email'];

		$attachments = array();
		array_push($attachments, array(
			'path' => $c_pdf->get_angebot_pdf_pfad($angebot['dateiname'])
		));

		$email_inhalt = $c_placeholder->replace_placeholder_inhalt(
			$inhalt['inhalt_id'],
			$inhalt['metavalue'],
			array(
				'angebot' => $angebot
			)
		);

		$email_inhalt = $this->helper->new_line_to_br($email_inhalt);

		$smtp_response = $this->email_senden(
			$empfaenger_email,
			$inhalt['betreff'],
			$email_inhalt,
			false,
			$attachments
		);

		$this->email_log->insert(array(
			'eintrag_id'    => $angebot_id,
			'empfaenger'    => $empfaenger_email,
			'betreff'       => $inhalt['betreff'],
			'text'          => $email_inhalt,
			'smtp_response' => $smtp_response,
			'eintrag_typ'   => 'angebot'
		));

		return array(
			'result'        => true,
			'smtp_response' => $smtp_response     
		);
		

	}


	public function rechnung_senden($rechnung_id) {
		
		global $c_rechnung, $c_inhalt, $c_pdf, $c_placeholder;
		
		$rechnung = $c_rechnung->get($rechnung_id);
		$inhalt  = $c_inhalt->get_by_metakey('email_rechnung_inhalt');


		if(($rechnung['rg_kunde_email'] == '') && ($rechnung['rg_kunde_email_angebot_rechnung'] == '')) {
			return array(
				'result'  => false,
				'message' => 'E-Mail Adresse des Kunden ist leer. Versand nicht möglich'
			);
		}

		if($rechnung['rg_kunde_email_angebot_rechnung'] != '') $empfaenger_email = $rechnung['rg_kunde_email_angebot_rechnung'];
		else $empfaenger_email = $rechnung['rg_kunde_email'];

		$attachments = array();
		array_push($attachments, array(
			'path' => $c_pdf->get_rechnung_pdf_pfad($rechnung['dateiname'])
		));
		array_push($attachments, array(
			'path' => $c_pdf->get_rechnungen_xml_pfad($rechnung['dateiname_e_rechnung'])
		)); 


		$email_inhalt = $c_placeholder->replace_placeholder_inhalt(
			$inhalt['inhalt_id'],
			$inhalt['metavalue'],
			array(
				'rechnung' => $rechnung
			)
		);

		$email_inhalt = $this->helper->new_line_to_br($email_inhalt);

		$smtp_response = $this->email_senden(
			$empfaenger_email,
			$inhalt['betreff'],
			$email_inhalt,
			false,
			$attachments
		);

		$this->email_log->insert(array(
			'eintrag_id'    => $rechnung_id,
			'empfaenger'    => $empfaenger_email,
			'betreff'       => $inhalt['betreff'],
			'text'          => $email_inhalt,
			'smtp_response' => $smtp_response,
			'eintrag_typ'   => 'rechnung'
		));

		return array(
			'result'        => true,
			'smtp_response' => $smtp_response     
		);
		

	}

	public function abonnement_senden($abonnement_id) {
		
		global $c_abonnement, $c_inhalt, $c_pdf, $c_placeholder, $c_kunde;
		
		$abonnement = $c_abonnement->get($abonnement_id);
		$inhalt  = $c_inhalt->get_by_metakey('email_abonnement_inhalt');


		if(($abonnement['kunde_email'] == '') && ($abonnement['kunde_email_abonnement_rechnung'] == '')) {
			return array(
				'result'  => false,
				'message' => 'E-Mail Adresse des Kunden ist leer. Versand nicht möglich'
			);
		}

		if($abonnement['kunde_email_abonnement_rechnung'] != '') $empfaenger_email = $abonnement['kunde_email_abonnement_rechnung'];
		else $empfaenger_email = $abonnement['kunde_email'];

		$attachments = array();
		array_push($attachments, array(
			'path' => $c_pdf->get_abonnement_pdf_pfad($abonnement['dateiname'])
		));

		$email_inhalt = $c_placeholder->replace_placeholder_inhalt(
			$inhalt['inhalt_id'],
			$inhalt['metavalue'],
			array(
				'abonnement' => $abonnement
			)
		);

		$email_inhalt = $this->helper->new_line_to_br($email_inhalt);

		$smtp_response = $this->email_senden(
			$empfaenger_email,
			$inhalt['betreff'],
			$email_inhalt,
			false,
			$attachments
		);

		$this->email_log->insert(array(
			'eintrag_id'    => $abonnement_id,
			'empfaenger'    => $empfaenger_email,
			'betreff'       => $inhalt['betreff'],
			'text'          => $email_inhalt,
			'smtp_response' => $smtp_response,
			'eintrag_typ'   => 'abonnement'
		));

		return array(
			'result'        => true,
			'smtp_response' => $smtp_response     
		);
		

	}

	public function zahlungserinnerung_senden($rechnung_id)
	{
		global $c_rechnung, $c_inhalt, $c_placeholder, $c_pdf;

		$rechnung = $c_rechnung->get($rechnung_id);
		$inhalt  = $c_inhalt->get_by_metakey('zahlungserinnerung_inhalt');


		if($rechnung['rg_kunde_email_angebot_rechnung'] != '') $empfaenger_email = $rechnung['rg_kunde_email_angebot_rechnung'];
		else $empfaenger_email = $rechnung['rg_kunde_email'];

		$email_inhalt = $c_placeholder->replace_placeholder_inhalt(
			$inhalt['inhalt_id'],
			$inhalt['metavalue'],
			array(
				'rechnung' => $rechnung
			)
		);

		$email_inhalt = $this->helper->new_line_to_br($email_inhalt);

		$attachments = array();
		array_push($attachments, array(
			'path' => $c_pdf->get_rechnung_pdf_pfad($rechnung['dateiname'])
		));

		$smtp_response = $this->email_senden(
			$empfaenger_email,
			$inhalt['betreff'],
			$email_inhalt,
			false,
			$attachments
		);

		$this->email_log->insert(array(
			'eintrag_id'    => $rechnung_id,
			'empfaenger'    => $empfaenger_email,
			'betreff'       => $inhalt['betreff'],
			'text'          => $email_inhalt,
			'smtp_response' => $smtp_response,
			'eintrag_typ'   => 'rechnung_zahlungserinnerung'
		));

		return array(
			'result'        => true,
			'smtp_response' => $smtp_response     
		);

	}

	public function mahnung_senden($rechnung_id, $mahnung_id)
	{
		global $c_rechnung, $c_inhalt, $c_placeholder, $c_pdf, $c_mahnung;

		$rechnung = $c_rechnung->get($rechnung_id);
		$mahnung  = $c_mahnung->get($mahnung_id);

		$inhalt  = $c_inhalt->get_by_metakey('mahnung_inhalt');

		if($rechnung['rg_kunde_email_angebot_rechnung'] != '') $empfaenger_email = $rechnung['rg_kunde_email_angebot_rechnung'];
		else $empfaenger_email = $rechnung['rg_kunde_email'];

		$email_inhalt = $c_placeholder->replace_placeholder_inhalt(
			$inhalt['inhalt_id'],
			$inhalt['metavalue'],
			array(
				'rechnung' => $rechnung,
				'mahnung'  => $mahnung
			)
		);

		$email_inhalt = $this->helper->new_line_to_br($email_inhalt);

		$attachments = array();
		array_push($attachments, array(
			'path' => $c_pdf->get_mahnung_pdf_pfad($mahnung['dateiname'])
		));

		$smtp_response = $this->email_senden(
			$empfaenger_email,
			$inhalt['betreff'],
			$email_inhalt,
			false,
			$attachments
		);

		$this->email_log->insert(array(
			'eintrag_id'    => $rechnung_id,
			'empfaenger'    => $empfaenger_email,
			'betreff'       => $inhalt['betreff'],
			'text'          => $email_inhalt,
			'smtp_response' => $smtp_response,
			'eintrag_typ'   => 'mahnung'
		));

		return array(
			'result'        => true,
			'smtp_response' => $smtp_response     
		);

	}
	

	

	

}