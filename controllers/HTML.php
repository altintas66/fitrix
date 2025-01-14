<?php

    class HTML {
		
		private $helper;
		private $url;
		
        public function __construct($helper, $url) 
		{
		  
          $this->helper = $helper;
		  $this->url    = $url;
        }
		
		public function get_head() {
			include 'includes/head.php';
		} 

		public function get_header() {
			include 'includes/header.php';
		}
		
		public function get_footer() {
			include 'includes/footer.php';
		}
		
		public function get_menue() {
			include 'includes/menue.php';
		}
		
		public function get_navigation($entries) {
		
			$html = '<ul>';
			
			foreach($entries AS $entry) {
				if($entry[1] == NULL) {
					$html .= '<li class="menu-title"><span>'.$entry[0].'</span></li>';
				} else if((isset($entry[3])) && (is_array($entry[3]))) { 
					$html .= '<li class="submenu"><a href="#"><img src="assets/icons/'.$entry[1].'" /><span>'.$entry[0].'</span> <span class="menu-arrow"></span></a>';
						$html .= '<ul style="display: none;">';
						foreach($entry[3] AS $sub) { 
							$html .= '<li><a href="'.$sub[1].'">'.$sub[0].'</a></li>';
						}
						$html .= '</ul>';
					$html .= '</li>';
				} else {
					$class= '';
					if (str_contains($entry[2], $_SERVER["SCRIPT_NAME"])) $class = 'active';
				
					$html .= '<li class="'.$class.'"><a href="'.$entry[2].'"><img src="assets/icons/'.$entry[1].'" /> <span>'.$entry[0].'</span></a></li>';
				}
			}
			$html .= '</ul>';
			return $html;
		}
		
		
		public function get_breadcrumbs($entries) {
			include 'includes/breadcrumbs.php';
		}
	

		public function get_css() {
			include 'includes/css.php';
		}
		
		public function get_javascript() {
			include 'includes/javascript.php';
		}
		
		public function statistik_widget($label, $value, $icon, $farbe) {
			include 'includes/statistik-widget.php';		
		}
		
		public function datum_uhrzeit($datum, $uhrzeit = true, $labeling = true) {
			if($datum == null) return 'Niemals';
			global $c_helper;
			$html = '';
			if($datum == NULL) return 'Nie';
			if($datum == '') return '';
			$d_datum = explode(' ',$c_helper->german_date($datum, $labeling));
			$html .= $d_datum[0];
			if($uhrzeit == true) { 
				$html .= '
				<span class="">
					'.$d_datum[1].'
				</span>';
			}
			return $html;
		}

		public function datum($datum, $uhrzeit = true, $labeling = true) {
			global $c_helper;
			$html = '';
			if($datum == NULL) return 'Nie';
			if($datum == '') return '';
			$d_datum = explode(' ',$c_helper->german_date_no_time($datum, $labeling));
			$html .= $d_datum[0];
			if($uhrzeit == true) { 
				if(isset($d_datum[1])) {
					$html .= '
					<span class="text-primary">
						'.$d_datum[1].'
					</span>';
				}
			}
			return $html;
		}

		public function card_header($title) 
		{
		?>
			<div class="card-header">
				<h4 class="card-title"><?php echo $title; ?></h4>
			</div> 
		<?php 
		}
   
		public function sticky_footer($button = null) {
			global $c_form;
		?>
			<div class="sticky-footer">
				<div class="row">
					<div class="col-md-12">
						<?php 
							if($button != null) { 
								$c_form->button_submit(
									$button[0], 
									$button[1], 
									'btn-primary', 
									false
								); 
							}
						?>
					</div>
				</div>
			</div>	
		<?php 
		}
  
		public function waehrung($zahl) {
			return number_format(floatval($zahl), 2, ",", ".")." €";
		}

		public function table_header($ths, $thead = true, $echo = true, $class = '', $data = '') {
			$html = '';
			if($thead == true) $html .= '<thead>';
			$html .= '<tr '.$data.' class="'.$class.'">';
			foreach($ths AS $th) { 
				if(isset($th['class'])) $class = $th['class'];
				else $class = '';
				$html .= '<th class="'.$class.'">';
					$html .= $th['title'];
				$html .= '</th>';
			}
			$html .= '</tr>';

			if($thead) $html .= '</thead>';

			if($echo == true) echo $html;
			else return $html;
		}

		public function td_user($users) {
			if($users == NULL) return '';
			if(!is_array($users)) return '';
			global $c_url;
			$html = '';
			foreach($users AS $user) {
				if($m == NULL) continue;
				$url = $c_url->get_user_bearbeiten($user['user_id']);
				$html .= '
					<a href="'.$url.'">
						'.$user['vorname'].' '.$user['nachname'].' 
					</a>,';
			}
			$html = substr_replace($html ,"", -1);
			echo $html;
		}


		public function get_badge($text, $data = '') {
			return '<span '.$data.' class="badge badge-secondary mb-10 mr-10">'.$text.'</span>';
		}

		public function get_beitraege($beitraege, $disabled = false) {
			if($beitraege == NULL) return '';
			global $c_helper, $c_url;

			$html = '';
			foreach($beitraege AS $beitrag) {
				$username = '<i class="fe fe-user mr-10"></i> '.$beitrag['user_username'];
				$html.= '<li data-beitrag-id="'.$beitrag['beitrag_id'].'">';
					$html .= '<div class="row">';
						$html .= '<div class="col-md-2">';
							$html .= $this->get_user_foto(array(
								'user_id'        => $beitrag['user_id'],
								'foto'           => $beitrag['user_foto'],
								'geschlecht'     => $beitrag['user_geschlecht'],
							));
						$html.= '</div>';
						$html .= '<div class="col-md-10">';
							$html .= '<div class="beitrag-text">';
								if ($disabled == false) {
									$html .= '<div class="beitrag-optionen">';
										$html .= '<a data-beitrag-id="'.$beitrag['beitrag_id'].'" onclick="delete_beitrag(this)" class="delete_icon_beitrag">';
											$html .= '<i class="fe fe-trash"></i>';
										$html .= '</a>';
										$html .= '<a data-beitrag-id="'.$beitrag['beitrag_id'].'" onclick="get_beitrag(this)" class="edit_icon_beitrag">';
											$html .= '<i class="fe fe-pencil"></i>';
										$html .= '</a>';
										$html .= '<a data-beitrag-id="'.$beitrag['beitrag_id'].'" onclick="insert_beitrag_kommentar(this)" class="comments_icon_beitrag">';
											$html .= '<i class="fe fe-comment"></i>';
										$html .= '</a>';
									$html .= '</div>';
								}
								$html .= $beitrag['text'];
							$html .= '</div>';
							$html .= '<div class="row beitrag-date table-data-small">';
								$html .= '<div class="col-md-8">';
									$html .= 'Erstellt am: '.$c_helper->german_date($beitrag['erstellt_am']);
									if($beitrag['bearbeitet_am'] != NULL) $html .= ' / Bearbeitet am: '.$c_helper->german_date($beitrag['bearbeitet_am']);
								$html .= '</div>';
								$html .= '<div class="col-md-4 text-right table-data-small">';
									$html .= '<a target="_blank" class="link" href="'.$c_url->get_user_bearbeiten($beitrag['user_id']).'">';	
										$html .= $username;
									$html .= '</a>';	
								$html .= '</div>';
							$html .= '</div>';
						$html.= '</div>';
					$html.= '</div>';
					//Hier werden die Kommentare ausgegeben
					$html .= $this->get_beitraege_kommentare($beitrag['kommentare'], $beitrag['beitrag_id'], $disabled);
				$html.= '</li>';
			}

			return $html;

		}

		public function get_beitraege_kommentare($kommentare, $beitrag_id, $disabled = false) {
			if($kommentare == NULL) return '';
			global $c_helper, $c_url;

			$html = '<ul class="kommentare">';
			foreach ($kommentare AS $k) {
				$username = '<i class="fe fe-user mr-10"></i> '.$k['user_username'];
				$html .= '<li data-beitrag-id="'.$beitrag_id.'" data-kommentar-id="'.$k['kommentar_id'].'">';
				$html .= '<div class="row">';
					$html .= '<div class="col-md-2">';
						$html .= $this->get_user_foto(array(
							'user_id'        => $k['user_id'],
							'foto'           => $k['user_foto'],
							'geschlecht'     => $k['user_geschlecht'],
						));
					$html.= '</div>';
					$html .= '<div class="col-md-10">';
						$html .= '<div class="beitrag-text">';
							if ($disabled == false) {
								$html .= '<div class="beitrag-optionen">';
									$html .= '<a data-kommentar-id="'.$k['kommentar_id'].'" onclick="delete_kommentar(this)" class="delete_icon_beitrag">';
										$html .= '<i class="fe fe-trash"></i>';
									$html .= '</a>';
									$html .= '<a data-kommentar-id="'.$k['kommentar_id'].'" onclick="get_kommentar(this)" class="edit_icon_beitrag">';
										$html .= '<i class="fe fe-pencil"></i>';
									$html .= '</a>';
								$html .= '</div>';
							}
							$html .= $k['text'];
						$html .= '</div>';
						$html .= '<div class="row beitrag-date table-data-small">';
							$html .= '<div class="col-md-8">';
								$html .= 'Erstellt am: '.$c_helper->german_date($k['erstellt_am']);
								if($k['bearbeitet_am'] != NULL) $html .= ' / Bearbeitet am: '.$c_helper->german_date($k['bearbeitet_am']);
							$html .= '</div>';
							$html .= '<div class="col-md-4 table-data-small text-right">';
								$html .= '<a target="_blank" class="link" href="'.$c_url->get_user_bearbeiten($k['user_id']).'">';	
									$html .= $username;
								$html .= '</a>';	
							$html .= '</div>';
						$html .= '</div>';
						
					$html.= '</div>';
				$html.= '</div>';
				$html .= '</li>';
			}
			$html .= '</ul>';

			return $html;

		}
		
		public function wysiwyg_div($label, $text) {
			$html = '<div class="wysiwyg_div mt-50 mb-50">';
				$html .= '<label class="bold mb-20">'.$label.'</label><br>';
				$html .= $text;
			$html .= '</div>';
			return $html;
		}

		public function input_div($label, $text) {
			$html = '<div class="input_div mt-50 mb-50">';
				$html .= '<label class="bold mb-20">'.$label.'</label><br>';
				$html .= $text;
			$html .= '</div>';
			return $html;
		}

		public function badge($text, $class='badge-light') {
			return '<span class="badge '.$class.'">'.$text.'</span>';
		}
 

		public function get_tabs_navigation($menue) 
		{
			$html = '<ul>';
			foreach($menue AS $m_key => $m_value) {
				$html .= '<li><a href="#'.$m_key.'">'.$m_value.'</a></li>';
			}
			$html .= '</ul>';

			return $html;
		}

		public function modal_header($title) {
		?>
			<div class="modal-header">
				<h5 class="modal-title">
					<?php echo $title; ?>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		<?php 
		}

		public function get_status_label($status) {
			if($status == 'aktiv') $class = 'btn-success';
			else if($status == 'deaktiv') $class = 'btn-danger';

			return '<span class="btn btn-sm '.$class.'">'.$status.'</span>';
		}


		public function get_user_foto($user) 
		{
			global $c_user, $c_url;
			$url = $c_url->get_user_bearbeiten($user['user_id']);

			$html = '<h2 class="table-avatar">';
				$html .= '<a href="'.$url.'" class="avatar avatar-xl mr-2">';
					$html .= '<img class="avatar-img rounded-circle" src="'.$c_user->get_foto_url($user).'" />';
				$html .= '</a>';
			$html .= '</h2>';
			return $html;
		}

		public function get_kunde_logo($kunde) 
		{
			global $c_kunde, $c_url;
			$url = $c_url->get_kunde_bearbeiten($user['kunde_id']);

			$html = '<h2 class="table-avatar">';
				$html .= '<a href="'.$url.'" class="avatar avatar-xl mr-2">';
					$html .= '<img class="avatar-img" src="'.$c_kunde->get_logo_url($kunde).'" />';
				$html .= '</a>';
			$html .= '</h2>';
			return $html;
		}

		

		public function angebot_box($angebot, $kunde)
		{
			global $einstellungen, $c_einstellungen, $c_button, $c_angebot, $c_table_helper;
			$counter = 1;
			$netto_gesamt = 0;
			include 'includes/templates/angebot.php';
		}

		public function rechnung_box($rechnung, $kunde)
		{
			global $einstellungen, $c_einstellungen, $c_button, $c_rechnung_position, $c_table_helper;
			$counter = 1;
			$netto_gesamt = 0;
			include 'includes/templates/rechnung.php';
		}
		
		public function iframe_rechnung($rechnung) 
		{
			global $c_url;
			include 'includes/templates/rechnung-iframe.php';
		}

		public function array_2_ul($array) {
			$out = "<ul>";
			foreach($array as $key => $elem){
				if(!is_array($elem)){
						$out .= "<li><span>$key: $elem</span></li>";
				}
				else $out .= "<li><span>$key</span>".array2ul($elem)."</li>";
			}
			$out .= "</ul>";
			return $out; 
		}

		public function get_erinnerungen($erinnerungen)
		{
			$anzahl_erinnerungen = $this->helper->get_size_of_array($erinnerungen);
		?>
			<li class="nav-item dropdown noti-dropdown">
				<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
					<i class="fe fe-bell"></i> 
					<span class="badge badge-pill js_notifications_anzahl">
						<?php echo $anzahl_erinnerungen; ?>
					</span>
				</a>
				<div class="dropdown-menu notifications">
					<div class="noti-content">
						<ul class="notification-list">
							<?php foreach($erinnerungen AS $erinnerung) { ?>
								<li class="notification-message">
									<a href="#">
										<div class="media">
											<div class="media-body">
												<p clapss="noti-details">
													<p class="noti-text"><?php echo $erinnerung['text']; ?></p>
												</p>
												<p class="noti-time">
													<span class="notification-time">
														<?php echo $this->helper->german_date($erinnerung['erstellt_am']); ?>
													</span>
												</p>
											</div>
										</div>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
					<div class="topnav-dropdown-footer">
						<a href="<?php echo $this->url->get_erinnerung_uebersicht(); ?>">Zeige alle</a>
					</div>
				</div>
			</li>
		<?php 
		}

		public function get_abonnement_position_letzte_rechnung_label($letzte_rechnung) 
		{
			
			$html = '<span class="table-data-small bg-primary-light mt-10">Letzte RG: ';
			
			if($letzte_rechnung != null) $html .= $this->helper->german_date_no_time($letzte_rechnung['abonnement_vertrag_rechnung_angelegt_am']);
			else $html .= "n.v.";

			$html .= '</span>';

			return $html;

		}
		

    }      


