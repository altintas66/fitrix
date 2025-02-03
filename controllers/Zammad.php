<?php 

    class Zammad 
    {
        private $helper;
        private $kunde;
        private $config;

        private $auth_token;
        private $zammad_url;

        public function __construct($helper, $kunde, $config) 
        {
            $this->helper = $helper;
            $this->kunde  = $kunde;
            $this->config = $config;

            $this->auth_token = $config['zammad_auth_thoken'];
            $this->zammad_url = $config['zammad_url'];
        }

        public function get_response($url, $data = null)
        {
            $ch = curl_init();
            $url = $this->zammad_url.$url;
         
            // cURL-Optionen setzen
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                 "Authorization: Token token=".$this->auth_token."",
                "Content-Type: application/json"
            ]);

            if($data != null) {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }

            

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
            return json_decode($response['response'], true);
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

        public function insert_ticket_eintrag($ticket_id, $betreff, $text) 
        {
            $url = '/api/v1/ticket_articles';

            $data = array(
                "ticket_id" => $ticket_id, 
                "subject"   => $betreff,
                "body"      => $text,
                "type"      => "note",
                "content_type" => "text/html",
                "internal"  => false
            );

            $response = $this->get_response($url, $data);
            var_dump($response);
            return $response;

        }

        public function get_zeitabrechnung($jahr, $monat, $organization_id = null)
        {
            $response = $this->get_time_accounting($jahr, $monat);

            $zeitabrechnung = array();

            $zammad_kunden = $this->kunde->get_zammad_kunden();

            foreach($zammad_kunden AS $zammad_kunde) {
                if(($zammad_kunde == null) || ($zammad_kunde == '')) continue;
                if(isset($zammad_kunde['zammad_organization_id'])) {
                    $zeitabrechnung[$zammad_kunde['zammad_organization_id']] = array(
                        'kunde_id'       => $zammad_kunde['kunde_id'],
                        'firmen_name'    => $zammad_kunde['firmen_name'],
                        'takt'           => 0, 
                        'anzahl_tickets' => 0,
                        'tickets'        => array()
                    );
                }
            }

            foreach($response AS $entry) {
                $time_unit       = floatval($entry['time_unit']);
                $organization_id = intval($entry['ticket']['organization_id']);
                $ticket          = $entry['ticket'];
                

                if(array_key_exists($organization_id, $zeitabrechnung) == false) {
                    $zeitabrechnung[$organization_id] = array(
                        'firmen_name'     => $entry['organization'],
                        'takt'            => 0, 
                        'anzahl_tickets'  => 0,
                        'tickets'        => array()
                    );   
                }

                $zeitabrechnung[$organization_id]['takt'] += $time_unit;

                if(array_key_exists($ticket['id'], $zeitabrechnung[$organization_id]['tickets']) == true)
                {
                    $zeitabrechnung[$organization_id]['tickets'][$ticket['id']]['takt'] += $time_unit;
                } else {
                    $zeitabrechnung[$organization_id]['anzahl_tickets'] += 1;

                    $zeitabrechnung[$organization_id]['tickets'][$ticket['id']] = array(
                    'id'          => $ticket['id'],
                    'number'      => $ticket['number'],
                    'takt'        => $time_unit,
                    'gesamt_takt' => $ticket['time_unit']
                    );
                }

            }

            foreach ($zeitabrechnung AS $zeitab) {  
                if (isset($zeitab['tickets']) && is_array($zeitab['tickets'])) {
                    usort($zeitab['tickets'], function ($a, $b) {
                        return $b['takt'] <=> $a['takt'];
                    });
                }
            }
            unset($zeitab);
   

            return $zeitabrechnung;
            
        }

        public function get_ticket_badge($ticket)
        {
            global $c_url;
            $html = '<a target="_blank" class="badge badge-secondary mr-10 mb-10" href="'.$c_url->get_zammad_ticket_bearbeiten($ticket['id']).'">';
            $html .= '#'.$ticket['number'].' ('.$ticket['takt'].')';
            if($ticket['takt'] != $ticket['gesamt_takt']) $html .= ' <span class="bg-warning-light">'.$ticket['gesamt_takt'].'</span>';
            $html .= '</a>';
            return $html;
        }
        

    }