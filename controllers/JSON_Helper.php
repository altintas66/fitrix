<?php 

    class JSON_Helper {

        CONST PARTNERGLN    = '4022127000028';
        CONST PRINCIPAL_ID  = '47196878';
        CONST SHIPPINGROUTE = 'DHL';

        public function __construct()
        {

        }

        public function fehlermeldung($error_code, $nachricht) {
            echo $this->get_json_result(array(
                'result'        => null,
                'error_code'    => $error_code,
                'error_message' => $nachricht
            ));
            exit();
        }
    
      
        public function get_json_result($array) {
            return str_replace('\\/', '/', json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }

        

    }