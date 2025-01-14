<?php

class Cache { 

	private $filedir_einstellungen;
	private $filedir_zammad_organisationen;
	private $filedir_zammad_kunden;
	private $filedir_zammad_benutzer;
	private $filedir_abonnement_daten;

	CONST ROLLE_ID_KUNDE = 3;
	CONST ROLLE_ID_BENUTZER = 2;

	public function __construct() 
	{
		global $config;
		$dir = dirname(__FILE__).'/../cache/';
		$this->filedir_einstellungen           = $dir.'einstellungen.json';
		$this->filedir_zammad_organisationen   = $dir.'zammad_organisationen.json';
		$this->filedir_zammad_kunden           = $dir.'zammad_kunden.json';
		$this->filedir_zammad_benutzer         = $dir.'zammad_benutzer.json';
		$this->filedir_abonnement_daten        = $dir.'abonnement_daten.json';
		
	}

	public function get_cache_dateien() {
		return array(
			'Einstellungen'           => $this->filedir_einstellungen,
			'Zammad_Organisationen'   => $this->filedir_zammad_organisationen,
			'Zammad_Kunden'           => $this->filedir_zammad_kunden,
			'Zammad_Benutzer'         => $this->filedir_zammad_benutzer,
			'Abonnement_Daten'        => $this->filedir_abonnement_daten
		);
	}

	public function update_all() 
	{
		$this->set_einstellungen();
		$this->set_zammad_organisationen();
		$this->set_zammad_kunden();
		$this->set_zammad_benutzer();
		$this->set_abonnement_daten();
	}


	public function set_einstellungen() 
	{
		global $c_einstellungen;
		$result = $c_einstellungen->get_all();		
		
		$fp = fopen($this->filedir_einstellungen, 'w');
		fwrite(fopen($this->filedir_einstellungen, 'w'), json_encode($result));
		
		fclose($fp);
	}	

	
	public function set_zammad_organisationen() 
	{
		global $c_zammad;
		$response = $c_zammad->get_organisationen();
		$organisationen = json_decode($response['response'], true);
		$result = array();
		foreach($organisationen AS $orga) {
			$result[$orga['id']] = array(
				'id'           => $orga['id'],
				'name'         => $orga['name'],
				'domain'       => $orga['domain'],
				'erstellt_am'  => $c_zammad->format_date($orga['created_at']),
				'member_ids'   => $orga['member_ids']
			);
		}
		
		$fp = fopen($this->filedir_zammad_organisationen, 'w');
		fwrite(fopen($this->filedir_zammad_organisationen, 'w'), json_encode($result));
		
		fclose($fp);
	}	


	public function set_zammad_kunden() 
	{
		global $c_zammad;
		$response = $c_zammad->get_zammad_users();
		$kunden = json_decode($response['response'], true);
		
		$result = array();
		foreach($kunden AS $kunde) {
			if (in_array(self::ROLLE_ID_KUNDE, $kunde['role_ids'])) { 
				$result[$kunde['id']] = array(
					'vorname'     => $kunde['firstname'],
					'nachname'    => $kunde['lastname'],
					'email'       => $kunde['email'],
					'erstellt_am' => $c_zammad->format_date($kunde['created_at']),
					'rollen'      => $kunde['role_ids']
				);
			}
		}
		
		$fp = fopen($this->filedir_zammad_kunden, 'w');
		fwrite(fopen($this->filedir_zammad_kunden, 'w'), json_encode($result));
		
		fclose($fp);
	}	

	public function set_zammad_benutzer() 
	{
		global $c_zammad;
		$response = $c_zammad->get_zammad_users();
		$benutzer = json_decode($response['response'], true);
		
		$result = array();
		foreach($benutzer AS $ben) {
			if (in_array(self::ROLLE_ID_BENUTZER, $ben['role_ids'])) { 
				$result[$ben['id']] = array(
					'vorname'     => $ben['firstname'],
					'nachname'    => $ben['lastname'],
					'email'       => $ben['email'],
					'erstellt_am' => $c_zammad->format_date($ben['created_at']),
					'rollen'      => $ben['role_ids']
				);
			}
		}
		
		$fp = fopen($this->filedir_zammad_benutzer, 'w');
		fwrite(fopen($this->filedir_zammad_benutzer , 'w'), json_encode($result));
		
		fclose($fp);
	}	

	public function set_abonnement_daten() 
	{
		global $c_abonnement, $c_abonnement_vertrag;
		$abonnements = $c_abonnement->get_all();

		$result = array();

		foreach($abonnements AS $abo) {
			$vertraege = $abo['vertraege'];
			$umsatz_pro_monat = 0;
			
			if($vertraege != null) {
				foreach($vertraege AS $vertrag) {
					$umsatz_pro_monat += $c_abonnement_vertrag->get_monats_umsatz($vertrag);
				}
			}

			$result[$abo['abonnement_id']] = array(
				'umsatz_pro_monat' => $umsatz_pro_monat
			);
		}

		$fp = fopen($this->filedir_abonnement_daten, 'w');
		fwrite(fopen($this->filedir_abonnement_daten , 'w'), json_encode($result));
		
		fclose($fp);

	}


	public function get_einstellungen() 
	{
		return json_decode(file_get_contents($this->filedir_einstellungen), true);
	}

	public function get_zammad_organisationen() 
	{
		return json_decode(file_get_contents($this->filedir_zammad_organisationen), true);
	}

	public function get_zammad_kunden() 
	{
		return json_decode(file_get_contents($this->filedir_zammad_kunden), true);
	}

	public function get_zammad_benutzer() 
	{
		return json_decode(file_get_contents($this->filedir_zammad_benutzer), true);
	}

	public function get_abonnement_daten() 
	{
		return json_decode(file_get_contents($this->filedir_abonnement_daten), true);
	}


}