<?php


class File_Upload {
	
	
    public function upload_file($fieldname, $files) 
    {
        $pfad = dirname(__FILE__).'/../upload/';
        $bool = true;

        if(isset($files[$fieldname])) {
            $errors     = array();
            $maxsize    = 24097152;
            
            $acceptable = array(
                'image/jpeg',
                'image/gif',
                'application/pdf',
                'image/JPG',
                'image/jpg',
                'video/mp4',
                'text/csv'
            );


            $error_datei_typ = 1;

            foreach($acceptable AS $a){
                if(str_ends_with($dateiname, $a)){
                    $error_datei_typ = 0;
                    break;
                }
            }

            if ($error_datei_typ == 1) ;


            if(count($errors) === 0) {
				$temp = explode(".", $files[$fieldname]["name"]);
				$dateiname = $temp[0].round(microtime(true)) . '.' . end($temp);
				$result = move_uploaded_file($files[$fieldname]["tmp_name"], $pfad. $dateiname);
            }
			
            if($result) { 
				return array(
					'result'        => $result, 
					'errors'        => $errors, 
					'dateiname'     => $dateiname, 
					'pfad'          => $pfad, 
					'original_name' => $files[$fieldname]["name"]
				);
			} else { 
				return array('result' => false); 
			}
		}
    } 

 
    
	

	

}


