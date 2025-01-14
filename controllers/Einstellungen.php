<?php

class Einstellungen {
	
	private $db;
	private $helper;
	
	private $fields;
	private $tablename; 
	
	public function __construct($db) 
	{
		global $c_helper;
		
		$this->db     = $db;
		$this->helper = $c_helper;
		
		$this->set_fields();
		$this->set_tablename();
	}
	
	public function set_fields() 
	{
		$this->fields = "
			id          AS 'id', 
			metakey     AS 'metakey', 
			metavalue   AS 'metavalue'
		";
	}
	
	public function set_tablename() 
	{
		$this->tablename = 'einstellungen';
	}
	
	public function get_fields()
	{
		return $this->fields;
	}
	
	public function get_tablename()
	{
		return $this->tablename;
	}	

	public function get_bilder() {
		return array(
			'user_avatar_maennlich'           => 'User Avatar (m) anpassen',
			'user_avatar_weiblich'            => 'User Avatar (w) anpassen',
			'artikel_foto'                    => 'Artikel Foto',
			'kunde_logo'                      => 'Kunde Logo',
			'logo_angebot_rechnung'           => 'Logo für Angebot & Rechnung'
		);
 	}

	 public function get_optionen() {
		return array(
			'rechnung_position_keine_pflichtfelder'         			    => 'Keine Pflichtfelder in der Rechnungsposition',
			'angebot_position_keine_pflichtfelder'           			    => 'Keine Pflichtfelder in der Angebotsposition',
			'angebot_pdf_position_laufende_kosten_ausblenden'               => 'Angebot PDF laufende Kosten ausblenden',
			'rechnung_pdf_position_laufende_kosten_ausblenden'              => 'Rechnung PDF laufende Kosten ausblenden',
			'quality_hosting_rechnungen_ausblenden'              			=> 'Qualityhosting Rechnung anlegen ausblenden',
			'rechnung_datum_nach_leistungsdatum'                            => 'Soll die Rechnung das Leistungsdatum berücksichtigen? Ansonsten wird die Rechnung nach dem Abrechnungszeitraum berücksichtigt.'
		);
 	}
 
	//rechnung_datum_nach_lieferdatum_oder_abrechnungszeitraum = lieferdatum oder abrechnungszeitraum
	
	/**
		Get by metakey
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_by_metakey($metakey) 
	{
	
		$sql = "SELECT 
				metavalue
			FROM ".$this->get_tablename()."
			WHERE metakey = '".$metakey."'";

		return $this->db->get($sql);
	}	
	
	/**
		Get all
		@var: int id
		@return: MYSQL_ASSOC | NULL
	**/

	public function get_all() 
	{
	
		$sql = "SELECT 
				metakey,
				metavalue
			FROM ".$this->get_tablename();
	
		$buff = $this->db->get_all($sql);
		$rows = array();

		foreach($buff AS $b) {
			$rows[$b['metakey']] = $b['metavalue'];
		}
	
		return $rows;
	}
	
	public function update_cache() 
	{
		global $c_cache;
		//$c_cache->set_einstellungen();
	}
	
	/**
		update
		@var: post array
	**/
	
	public function update_einstellungen($post, $files) 
	{
		global $c_file_upload;
		$errors = array();

		$bilder = $this->get_bilder();

		//Bilder
		foreach(array_keys($bilder) AS $a) {
			if($files[$a]['name'] == '') continue;
			if($files[$a] == NULL) continue;

			
			$result_file_upload = $c_file_upload->upload_file($a, $_FILES);
			if($result_file_upload['result']) {
				$this->sql_update($a, $this->helper->get_upload_path($result_file_upload['dateiname']));	
			} else {
				foreach($result_file_upload['errors'] AS $e) {
					array_push($errors, $e);
				}
			}
		}	
		
		//Normale Felder
		foreach(array(
			'firmen_name',
			'firma_geschaeftsfuehrer',
			'firma_umsatzsteuer_id',
			'registergericht',
			'registernummer',
			'strasse',
			'plz',
			'ort',
			'lat',
			'lng',
			'telefon',
			'email',
			'webseite',
			'smtp_server',
			'smtp_email',
			'smtp_passwort',
			'bank',
			'iban',
			'bic',
			'angebot_bedingungen',
			'angebot_angebotsnummer_praefix',
			'rechnung_bedingungen',
			'firma_steuernummer',
			'rechnung_rechnungsnummer_praefix',
			'rechnung_anzahl_tage_faelligkeit',
			'abonnement_abonnementnummer_praefix',
			'angebot_erinnerin_in_tagen',
			'mahnungen_senden_nach_x_tagen',
			'zahlungserinnerung_senden_nach_x_tagen',
			'firmen_name_kurz',
			'zuletzt_vergebene_rechnungsnummer',
			'mahngebuehr'
		) AS $a) {
			$this->sql_update($a, $this->helper->escape_value($post[$a]));	
		}	
		
		//Toggles
		foreach(array(

		) AS $a) {
			$this->sql_update($a, $this->helper->get_toggle_value($post[$a]));	
		}
		
		//JSONs
		/*foreach(array(
			''
		) AS $json_name) {
			$this->sql_update($json_name, json_encode($post[$json_name]));	
		}*/


		
		$this->update_cache();
		return $errors;
	}
	
	public function sql_update($metakey, $metavalue) 
	{
		$sql ="
		UPDATE ".$this->get_tablename()." SET 
			metavalue           = '".$metavalue."'
		WHERE metakey = '".$metakey."'";
		return $this->db->update($sql);	
	}

	public function get_foto_url($datei_pfad)
	{
		global $config;
		$url = str_replace($config['siteurl'], $config['httpsurl'], $datei_pfad);
		$url = str_replace('/var/www/vhosts/'.$config['site_path'], $config['httpsurl'], $datei_pfad);
		

		return $url;
	}
	
	
}
