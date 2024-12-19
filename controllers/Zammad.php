<?php 

    class Zammad 
    {
        private $helper;
        private $config;

        private $auth_token;
        private $zammad_url;

        public function __construct($helper, $config) 
        {
            $this->helper = $helper;
            $this->config = $config;

            $this->auth_token = $config['zammad_auth_thoken'];
            $this->zammad_url = $config['zammad_url'];
        }

        public function get_response($url)
        {
            $ch = curl_init();
            $url = $this->zammad_url.$url;
         
            // cURL-Optionen setzen
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Token token=".$this->auth_token
            ]);

            $response = curl_exec($ch);
            // HTTP-Statuscode prüfen
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return array(
                'http_code' => $http_code,
                'response'  => $response
            );

        }

        public function get_tickets($jahr, $monat, $organization_id = '')
        {
            $from_date = $jahr."-".$monat."-01";
            $till_date = $jahr."-".$monat."-31";

            $url = '/api/v1/tickets/search?limit=999&query=';
            
            $query = "created_at:>={$from_date} AND created_at:<={$till_date}";
            if($organization_id != '') {
                
                if($organization_id == 'none')  $query .= ' AND NOT organization_id:*';
                else $query .= ' AND organization_id:'.$organization_id;
            }
            
            $query = urlencode($query);
            $url .= $query;
      
            $response = $this->get_response($url);

            return $response;
        }

        public function get_time_accounting($jahr, $monat) 
        {
            
            $url = '/api/v1/time_accounting/log/by_activity/'.$jahr.'/'.$monat;
            $response = $this->get_response($url);
            return $response;
        }
        
        


        public function get_zammad_users()
        {
            $response = $this->get_response('/api/v1/users?limit=999');
            return $response;
        }


        public function get_organisationen()
        {
            $response = $this->get_response('/api/v1/organizations?limit=999&active=1');
            return $response;
        }

        public function format_date($string)
        {
            if($string == null) return '';
            if($string == '') return '';
            $teile = explode("T", $string);
            return $this->helper->german_date_no_time($teile[0]);
        }

        public function get_zammad_domains($domain)
        {
            if (str_contains($domain, ',')) {
                $domain = str_replace(',', "<br>", $domain);
            }

            return $domain;
        }

        public function get_zeiterfassung($von, $bis, $organization_id) 
        {
            $url = '/api/v1/report/1?start='.$von.'&end='.$bis;

            $response = $this->get_response($url);

            return $response;
        }

        public function get_statistics() 
        {
            $url = '/api/v1/tickets/4113724/time_accounting';

            $response = $this->get_response($url);

            return $response;
        }

    }