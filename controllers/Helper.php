<?php 

class Helper {

	private $db;

	public function __construct($db) 
	{
		$this->db            = $db;
	}

	public function delete_entry($id, $table) 
	{
		$sql = 'DELETE FROM '.$table.' WHERE id = '.intval($id);
		$this->db->delete($sql);
	}

	public function update_status($id, $table, $status) {
		$sql = 'UPDATE '.$table.' SET status = "'.$status.'" WHERE id = '.intval($id);
		$this->db->update($sql);
	}

    public function get_random_passwort($length = 8, $suffix = '') {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < $length; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return $suffix.implode($pass); //turn the array into a string
	}
	
	//Verschlüsseln beim Insert/Update
	public function encrypt($string) {
		if($string == '') return $string;
		$result = '';
		for($i = 0; $i < strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($this->key, ($i % strlen($this->key)) - 1, 1);
			$char = chr(ord($char) + ord($keychar));
			$result .= $char;
		}
		return base64_encode($result);
	}
	
	//Entschlüsseln bei GET
	function decrypt($string) {
		if($string == '') return $string;
		$result = '';
		$string = base64_decode($string);

		for($i = 0; $i < strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($this->key, ($i % strlen($this->key)) - 1, 1);
			$char = chr(ord($char) - ord($keychar));
			$result .= $char;
		}

		return $result;
	}
	
	
	public function escape_value($value) {
		if(is_array($value)) return;
		return $this->db->escape($value);
	}
			
	public function escape_values($post) {
		return $this->db->escape_values($post);
	}
	
	public function german_date($datum, $labeling = true) {	
		if($datum == '') return 'Niemals';
		if($datum == NULL) return 'Niemals';
		$buff1 = date('d.m.Y', strtotime($datum));
		$buff2 = date('H:i:s', strtotime($datum));
		$gestern = date('d.m.Y', strtotime('-1 day'));
		
		if($labeling) {
			if($buff1 == date('d.m.Y')) $buff1 = 'Heute';
			else if($buff1 == $gestern) $buff1 = 'Gestern';
		}
		
		$datumuhrzeit = $buff1.' '.$buff2;
		return $datumuhrzeit;
	}
	
	public function numbertoeuro($number) {
		$formatted_price = number_format($number, 2, ',', '.');
		return $formatted_price . ' €';
	}

	public function german_date_no_time($datum, $labeling = false) {
		if($datum == '') return '';
		$datum = date('d-m-Y', strtotime($datum));
		$datum = str_replace("-", ".", $datum);	
		$gestern = date('d.m.Y', strtotime('-1 day'));

		if($labeling) {
			if($datum == date('d.m.Y')) $datum = 'Heute';
			else if($datum == $gestern) $datum = 'Gestern';
		}
		return $datum;	
	}
	
	public function english_date_no_time($datum) {
		if($datum == '') return '';
		if($datum == null) return '';
		$d = new DateTime(date('d.m.Y', strtotime($datum)));
		return $d->format("Y-m-d");
	}

	public function english_date_with_time($datum) {
		if($datum == '') return '';
		if($datum == null) return '';
		$d = new DateTime(date('d.m.Y H:i:s', strtotime($datum)));
		return $d->format("Y-m-d H:i:s");
	}
	
	public function german_only_time($datum) {
		if($datum == '') return '';
		$datum = date('H:i', strtotime($datum));
		return $datum;
	}


    public function get_key_values_from_array($array, $key, $value, $empty_value = false) {
		if($array == null) return array();
		if(is_array($array) == false) return array();
		$results = array();
		if($empty_value == true) $result[''] = '---';
		foreach($array AS $arr) {
			$result[$arr[$key]] = $arr[$value];
		}
		return $result;
	}

	public function get_key_values_from_artikel($artikel) {
		if($artikel == null) return array();
		if(is_array($artikel) == false) return array();
		$results = array();
		$result[''] = '---';
		foreach($artikel AS $arr) {
			$result[$arr['artikel_id']] = $arr['artikel_name'].' ('.$this->waehrung($arr['preis']).')';
		}
		return $result;
	}

	public function get_key_values_from_kunde($kunden) 
	{
		global $einstellungen;
		if($kunden == null) return array();
		if(is_array($kunden) == false) return array();
		$results = array();
		$result[''] = '---';

		foreach($kunden AS $arr) {
			
			if($einstellungen['kunde_suche'] == 'adresse') $result[$arr['kunde_id']] = $arr['firmen_name'].' ('.$arr['adresse'].')';
			else if($einstellungen['kunde_suche'] == 'suchname') $result[$arr['kunde_id']] = $arr['firmen_name'].' ('.$arr['suchname'].')';
			else $result[$arr['kunde_id']] = $arr['firmen_name'];
		}

		return $result;
	}

	

	public function waehrung($zahl) {
		return number_format(floatval($zahl), 2, ",", ".")." €";
	}

    public function __message($message, $class = 'success') {
    ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-<?php echo $class; ?>">
                    <?php echo $message; ?>
                </div>
            </div>
        </div>
    <?php 
    }
        
    public function redirect($url, $message = '') {
        if($message != '') {
            if (strpos($url, '?') !== false) $url.= '&message='.$message;
            else $url.= '?message='.$message; 
        }
    ?>
        <script type="text/javascript">
            window.location.href = "<?php echo $url; ?>"
        </script>
    <?php
    }

    public function get_toggle_value($value) {
        if(!isset($value)) return '0';
		else if($value == false) return '0';
		else if($value == 'false') return '0';
        else if($value == '0') return '0';
        else if($value == '') return '0';
        else if($value == '1') return '1';
        else if($value == 'off') return '0';
        else if($value == 'on') return '1';
		else if($value == true) return '1';
		else if($value == 'true') return '1';
        else return '1';
    }
    
    public function get_toggle_label($value) {
        if($value == '1') return 'Ja';
        elseif($value == '0') return 'Nein';
    }

    public function get_size_of_array($a) {
        if($a == NULL) return 0;
        else return sizeof($a);
    }

    public function get_upload_path($img) {
		global $config;
		return $config['siteurl'].'upload/'.$img;
	}

	public function get_user_ip_adresse() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			// Check if IP is from shared internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			// Check if IP is passed from a proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			// Get IP from remote address
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public function get_english_datetime_now() {
		return date('Y-m-d H:i:s');
	}
	public function get_english_date_now() {
		return date('Y-m-d');
	}

	public function upload_foto($files, $filename) 
	{
		
		if($files[$filename]['name'] == '') return;
		if($files[$filename] == NULL) return;
		
		global $c_file_upload;
		$errors = array();
		
		$result_file_upload = $c_file_upload->upload_file($filename, $files);
		
		if($result_file_upload['result']) {
			return array(
				'result' => true,
				'dateiname' => $result_file_upload['dateiname']
			);	
		} else {
			foreach($result_file_upload['errors'] AS $e) {
				array_push($errors, $e);
			}
		} 
		
		return array(
			'result' => false,
			'errors' => $errors
		);
	}

	public function lat_lng_link() {
	?>
		<a class="link" href="https://www.latlong.net/" target="_blank">Längen- und Breitengrad nachschlagen</a>
	<?php 
	}

	public function format_waehrung_for_db($value) 
	{
		if($value == '') return 0;
		if($value == NULL) return 0;
		$value = trim($value);
		$value = str_replace('€', '', $value);
		$value = str_replace('.', '', $value);
		$value = str_replace(',', '.', $value);

		return floatval($value);

	}

	public function format_number_for_db($value) 
	{
		if($value == '') return 0;
		if($value == NULL) return 0;
		$value = trim($value);
		$value = str_replace('.', '', $value);
		$value = str_replace(',', '.', $value);
		$value = number_format($value, 2, '.', '');
		return $value;
	}

    public function clean_wysiwyg_html($html)
    {
        
		$html = str_replace('\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\', '', $html);
		$html = str_replace('\\\\\\\\\\\\\\\\', '', $html);
		$html = str_replace('\\\\\\\\', '', $html);
		$html = str_replace('\\\\', '', $html);
		$html = str_replace('\\', '', $html);
		$html = str_replace('&quot;', '', $html);
		

        return $html;
    }

	public function get_netto($brutto, $mwst_satz) {

		$mwst_satz = intval($mwst_satz);
		if($mwst_satz == 0) return $netto;

		$vatMultiplier = 1 + ($mwst_satz / 100);
		$netto = $brutto / $vatMultiplier;
		return round($netto, 2);
	}

	public function get_brutto($netto, $mwst_satz) {

		$mwst_satz = intval($mwst_satz);
		if($mwst_satz == 0) return $netto;

		$vatMultiplier = 1 + ($mwst_satz / 100);
		$brutto = $netto * $vatMultiplier;
		return round($brutto, 2);
	}

	public function get_mwst($netto, $mwst_satz) {
		$mwst_satz = intval($mwst_satz);
		$vatDecimal = $mwst_satz / 100;
    
		// Calculate MwSt by multiplying netto with the VAT rate in decimal
		$mwst = $netto * $vatDecimal;
		
		// Optionally, round to 2 decimal places for currency
		return round($mwst, 2);
	}

	public function new_line_to_br($html) 
	{
		$html = str_replace('\\r\\n\\r\\n', '<br><br>', $html);
		$html = str_replace('\r\n\r\n', '<br><br>', $html);
		$html = str_replace('\\r\\n', '<br>', $html);
		$html = str_replace('\r\n', '<br>', $html);
		return $html;
	}

	public function string_neue_zeilen($string, $length) 
	{
		return wordwrap($string, $length, '<br>');
	}

	public function get_message_for_url($message)
	{
		$message = str_replace(' ', '+', $message);
		return $message;
	}
	
	public function update_sort($rows, $tablename) {
		foreach($rows AS $row) { 
			$sql = "UPDATE ".$tablename." SET position = ".intval($row['sort'])." WHERE id = ".intval($row['id']);
			$this->db->update($sql); 
		}
	}
	
	public function add_months($datum, $anzahl_monate, $german_format = false) {
		$heute = new DateTime($datum);
		$heute->modify('+ '.$anzahl_monate.' month');
		
		if($german_format == true) return $heute->format('d.m.Y');
		else return $heute->format('Y-m-d'); 

	}

	public function get_monat_label($monat) {
		if(($monat == 1) || ($monat == '01')) return 'Januar';
		else if(($monat == 2) || ($monat == '02')) return 'Februar';
		else if(($monat == 3) || ($monat == '03')) return 'März';
		else if(($monat == 4) || ($monat == '04')) return 'April';
		else if(($monat == 5) || ($monat == '05')) return 'Mai';
		else if(($monat == 6) || ($monat == '06')) return 'Juni';
		else if(($monat == 7) || ($monat == '07')) return 'Juli';
		else if(($monat == 8) || ($monat == '08')) return 'August';
		else if(($monat == 9) || ($monat == '09')) return 'September';
		else if(($monat == 10) || ($monat == '10')) return 'Oktober';
		else if(($monat == 11) || ($monat == '11')) return 'November';
		else if(($monat == 12) || ($monat == '12')) return 'Dezember';
	}

	public function strbool($value)
	{
		return $value ? 'true' : 'false';
	}

	public function get_select_values($optionen)
	{
		
		$html = '';
		if($optionen == null) return $html;
		if(is_array($optionen) == false) return $html;

		foreach($optionen AS $option_key => $option_value) {
			$html .= '<option value="'.$option_key.'">'.$option_value.'</option>';
		}

		return $html;
	}

	public function escape_html($html)
	{
		$safe_html = htmlspecialchars($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		return $safe_html;
	}

	public function get_marken()
	{
		return array(
			""               => "auswählen",
			"Mercedes-Benz"  => "Mercedes-Benz",
			"VW"             => "VW",
			"BMW"            => "BMW",
			"Audi"           => "Audi",
			"Opel"           => "Opel",
			"----"           => "----",
			"Abarth"         => "Abarth",
			"AC"             => "AC",
			"Acura"          => "Acura",
			"Aixam"          => "Aixam",
			"Alfa Romeo"     => "Alfa Romeo",
			"Alpina"         => "Alpina",
			"Artega"         => "Artega",
			"Aston Martin"   => "Aston Martin",
			"Austin"         => "Austin",
			"Austin Healey"  => "Austin Healey",
			"Baic"           => "Baic",
			"Barkas"         => "Barkas",
			"Bentley"        => "Bentley",
			"Brilliance"     => "Brilliance",
			"Bugatti"        => "Bugatti",
			"Buick"          => "Buick",
			"Cadillac" => "Cadillac",
			"Casalini" => "Casalini",
			"Caterham" => "Caterham",
			"Changhe" => "Changhe",
			"Chevrolet" => "Chevrolet",
			"Chrysler" => "Chrysler",
			"Citroen" => "Citroen",
			"Cobra" => "Cobra",
			"Corvette" => "Corvette",
			"Dacia" => "Dacia",
			"Daewoo" => "Daewoo",
			"DAF" => "DAF",
			"Daihatsu" => "Daihatsu",
			"Daimler" => "Daimler",
			"De Tomaso" => "De Tomaso",
			"Dodge" => "Dodge",
			"DS Automobiles" => "DS Automobiles",
			"Ferrari" => "Ferrari",
			"Fiat" => "Fiat",
			"Fisker" => "Fisker",
			"Ford" => "Ford",
			"GAC Gonow" => "GAC Gonow",
			"GMC" => "GMC",
			"Hamann" => "Hamann",
			"Honda" => "Honda",
			"Hummer" => "Hummer",
			"Hyundai" => "Hyundai",
			"Infiniti" => "Infiniti",
			"Isuzu" => "Isuzu",
			"Iveco" => "Iveco",
			"Jaguar" => "Jaguar",
			"Jeep" => "Jeep",
			"Kia" => "Kia",
			"KTM" => "KTM",
			"Lada" => "Lada",
			"Lamborghini" => "Lamborghini",
			"Lancia" => "Lancia",
			"Land Rover" => "Land Rover",
			"Landwind" => "Landwind",
			"Lexus" => "Lexus",
			"Ligier" => "Ligier",
			"Lincoln" => "Lincoln",
			"Lotus" => "Lotus",
			"Mahindra" => "Mahindra",
			"Maserati" => "Maserati",
			"Maybach" => "Maybach",
			"Mazda" => "Mazda",
			"McLaren" => "McLaren",
			"MG" => "MG",
			"Microcar" => "Microcar",
			"Mini" => "Mini",
			"Mitsubishi" => "Mitsubishi",
			"Morgan" => "Morgan",
			"Nissan" => "Nissan",
			"NSU" => "NSU",
			"Oldsmobile" => "Oldsmobile",
			"Pagani" => "Pagani",
			"Peugeot" => "Peugeot",
			"Piaggio" => "Piaggio",
			"Plymouth" => "Plymouth",
			"Pontiac" => "Pontiac",
			"Porsche" => "Porsche",
			"Renault" => "Renault",
			"Rolls-Royce" => "Rolls-Royce",
			"Rover" => "Rover",
			"Ruf" => "Ruf",
			"Saab" => "Saab",
			"Santana" => "Santana",
			"Seat" => "Seat",
			"Skoda" => "Skoda",
			"Smart" => "Smart",
			"SsangYong" => "SsangYong",
			"Subaru" => "Subaru",
			"Suzuki" => "Suzuki",
			"Talbot" => "Talbot",
			"Tata" => "Tata",
			"Tesla" => "Tesla",
			"Toyota" => "Toyota",
			"Trabant" => "Trabant",
			"Triumph" => "Triumph",
			"TVR" => "TVR",
			"Volvo" => "Volvo",
			"Wartburg" => "Wartburg",
			"Westfield" => "Westfield",
			"Wiesmann" => "Wiesmann",
			"andere" => "andere"
		);
	}

}