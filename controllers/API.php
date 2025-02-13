<?php 

    class API {
		
		private $helper;
		private $email;

		CONST APIURL_PLZ = 'https://openplzapi.org/de/Localities';

		public function __construct($helper, $email)
		{
			$this->helper = $helper;
			$this->email  = $email;
		}

		public function get_parkwin_api_aufruf_buchungen($system_url, $start, $ende) 
		{
			$url = $system_url.'/controllers/Webseite.php?action=get_anzahl_buchungen&von='.$start.'&bis='.$ende;
			return $url;
		}

		public function get_api_url_plz() {
            return self::APIURL_PLZ;
        }
		
		
		public function get_parkwin_buchungen($kunde) 
		{
			$heute         = new DateTime($this->helper->get_english_datetime_now());
			$letzter_monat = $heute->modify('-1 month');
			
			$erster_tag  = $letzter_monat->modify('first day of this month');
			$letzter_tag = $letzter_monat->modify('last day of this month');

			$system_url = $kunde['parkwin_system_url'];
			$api_url    = $this->get_parkwin_api_aufruf_buchungen(
				$system_url, 
				'01.'.$erster_tag->format('m').'.'.$erster_tag->format('Y'), 
				$letzter_tag->format('d.m.Y')
			);
		
			$response = json_decode(file_get_contents($api_url), true);
		
			
			if(is_array($response)) {
				return $response['alle_buchungen'];
			} else {
				$this->email->administrator_email('Fehler. Parkwin API nicht erreichbar! '.$api_url);
				return null;
			}
		}

        public function get_response($url, $type = 'GET', $data = array()) 
        { 
		
          
            $curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL             => $url,
				CURLOPT_RETURNTRANSFER  => true,
				CURLOPT_CUSTOMREQUEST   => $type,
                CURLOPT_POSTFIELDS      => json_encode($data),
				CURLOPT_HTTPHEADER      => array(
					'cache-control: no-cache',
                    'content-type: application/json'
				),
			));
            
			$response = json_decode(curl_exec($curl), true);
			curl_close($curl);

			return $response;
		}

    }

   