<?php

class Login {

	private $helper;
	private $user;
	private $url;
		
	public function __construct() 
	{
		global $c_helper, $c_user, $c_url;
		
		$this->helper    = $c_helper;
		$this->user      = $c_user;
		$this->url       = $c_url; 
	} 

   public function login($username, $passwort) 
   {
	   $user = $this->user->get_user_by_login($username, $passwort);

		if($user != NULL) {
		
			//Wenn gesperrt
			if($user['status'] == 'deaktiv') {
				return array(
					'result'  => false, 
					'message' => 'Ihr Account wurde gesperrt. Anmeldung nicht möglich.'
				);
			} else {
				$letzter_login = date('Y-m-d H:i:s');
				$this->user->update_letzter_login($user['user_id']);
				$user['letzter_login'] = $letzter_login;

				foreach(array(
					'id'             => 'user_id',
					'user_id'        => 'user_id',
					'username'       => 'username',
					'email'          => 'email',
					'nachname'       => 'nachname',
					'vorname'        => 'vorname',
					'letzter_login'  => 'letzter_login',
					'api_key_id'     => 'api_key_id',
					'api_key'        => 'api_key',
					'rolle_id'       => 'fk_rolle_id'
				
					) AS $key => $value)  {
					$_SESSION[$key] = $user[$value];
				}
				
				return array(
					'result' => true
				);
			}
		
		}
		else {
			return array(
				'result'   => false,
				'message'  => 'Username oder Passwort falsch!'
			);
		}
   }
   
   public function session_check() 
   {
		
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 2700)) {
			// last request was more than 45 minutes ago
			session_start();
			session_unset();
			session_destroy();
			session_write_close();
			setcookie(session_name(),'',0,'/');
			session_regenerate_id(true);
		}
		session_start();
		while (ob_get_level()) {
			ob_end_clean();
			header("Content-Encoding: None", true);
		}

		if(!isset($_SESSION["email"])) {
			header('Location: '.$this->url->get_login());
		}
		
		//Session vorhanden.. Eintrag in die DB
		if(isset($_SESSION['id'])) $this->user->update_letzter_login(intval($_SESSION['id']));
   }


    

    

    
   
    
}