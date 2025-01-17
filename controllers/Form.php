<?php

	class Form {
		
		private $helper;
		private $html;
		private $einstellungen;
		private $aktive_module;

		
		public function __construct($helper, $html, $einstellungen, $aktive_module) 
		{
			$this->helper          = $helper; 
			$this->html            = $html;
			$this->einstellungen   = $einstellungen;
			$this->aktive_module   = $aktive_module;
		}

		public function span_required($required = true) {
			if($required) echo ('<span class="required">*</span>');
		}

		public function get_rechnung_position_pflichtfelder() 
		{
			if($this->einstellungen['rechnung_position_keine_pflichtfelder'] == '1') return false;
			else return true;
		}

		public function get_angebot_position_pflichtfelder() 
		{
			if($this->einstellungen['rechnung_position_keine_pflichtfelder'] == '1') return false;
			else return true;
		}

		public function wrapper_start($label, $required = false) {
		?>
			<div class="form-group">
				<label class="col-form-label pt-0"><?php echo $label; ?></label>
				<?php if($required) { $this->span_required(); } ?>
		<?php 
		}
 
		public function wrapper_end() {
		?>
			</div>
		<?php 
		} 

		public function input_waehrung($label = false, $name, $value = '', $placeholder = '', $required = false, $class = '', $data = '') {
			
			if($label != false) $this->wrapper_start($label, $required);
		?>
			<input type="text" name="<?php echo $name; ?>" <?php if($required) echo 'required'; ?> id="<?php echo $name; ?>" <?php echo $data; ?> class="autonumeric form-control <?php echo $class; ?>" data-a-sign="€ " data-a-dec="," data-a-sep="." value="<?php echo $value; ?>" />
		<?php
			if($label != false) $this->wrapper_end(); 
		}
		
		public function input_text($label = false, $name, $value = '', $placeholder = '', $required = false, $wrapper = true, $disabled = false, $class= '', $data = '') {
			if(($wrapper == true) && ($label != false)) $this->wrapper_start($label, $required);
			$disabledtext = '';
			if($disabled == true) $disabledtext = 'disabled';

		?>
			<input autocomplete="off" <?php echo $data; ?> <?php if($required) echo 'required'; ?> class="form-control <?php echo $class; ?> " type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder;?>" <?php echo $disabledtext; ?> />
		<?php 
			if(($wrapper == true) && ($label != false)) $this->wrapper_end();
		}

		function input_timepicker($label = false, $name, $value = '', $placeholder = '', $required = true, $wrapper = true) {
			$timeValue = '';
		  
			// Set the time value if provided
			if (!empty($value)) {
			  $datetime = new DateTime($value);
			  $timeValue = $datetime->format('H:i');
			}
		  
			if($wrapper == true) $this->wrapper_start($label, $required);
		  
			// Output the time picker input field
			echo '<input type="time" name="' . $name . '" value="' . $timeValue . '" placeholder="' . $placeholder . '" ' . ($required ? 'required' : '') . '>';
			if($wrapper == true) $this->wrapper_end();
		}
		
		public function input_date($label = false, $name, $value = '', $placeholder = '', $required = false, $wrapper = true) {
			global $c_helper;
			if(($value != '') && ($value != null)) $value = $c_helper->german_date_no_time($value);
			if($wrapper == true) $this->wrapper_start($label, $required);
		?>
			<input autocomplete="off" <?php if($required) echo 'required'; ?> class="datepicker form-control" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>" />
		<?php 
			if($wrapper == true) $this->wrapper_end();
		}

		public function input_datetime($label = false, $name, $value = '', $placeholder = '', $required = false, $wrapper = true) {
			global $c_helper;
			$value = $c_helper->german_date_no_time($value);
			if($wrapper == true) $this->wrapper_start($label, $required);
		?>
			<input autocomplete="off" <?php if($required) echo 'required'; ?> class="datetimepicker form-control" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>" />
		<?php 
			if($wrapper == true) $this->wrapper_end();
		}
		
		public function geburtsdatum($label, $name, $value = '', $required = true, $wrapper = true) {
			if($wrapper == true) $this->wrapper_start($label, $required);
		?>
			<input autocomplete="off" <?php if($required) echo 'required'; ?> class="form-control geburtsdatum" type="text" name="<?php echo $name; ?>" value="<?php echo $value; ?>" placeholder="Hier klicken ..." />
		<?php 
			if($wrapper == true) $this->wrapper_end();
		}
		
		public function input_hidden($name, $value) {
		?>
			<input type="hidden" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo $value; ?>" />
		<?php 
		}
		
		public function input_disabled($value, $label, $id) {
		?>
			<label class="col-form-label pt-0"><?php echo $label; ?></label>
			<input id="<?php echo $id; ?>" name="<?php echo $id; ?>" class="form-control mb-4 disabled" type="text" value="<?php echo $value; ?>" />
		<?php 
		}
		
		public function input_email($label, $name, $value, $placeholder = '', $required = false) {
			if($label != false) $this->wrapper_start($label, $required);
		?>
			<input autocomplete="off" <?php if($required) echo 'required'; ?> class="form-control" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>" />
		<?php 
			if($label != false) $this->wrapper_end();
		}
		
		public function input_number($label, $name, $value = '', $placeholder = '', $required = false, $class = '', $custom = '') {
			if($label != false) $this->wrapper_start($label, $required);
		?>
			<input autocomplete="off" <?php if($required) echo 'required'; ?> class="form-control <?php echo($class); ?>" type="number" id="<?php echo $name; ?>" <?php echo($custom); ?> name="<?php echo $name; ?>" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>" />
		<?php
			if($label != false) $this->wrapper_end();
		}

		public function input_decimal($label, $name, $value = '', $placeholder = '', $required = false, $class = '', $custom = '') {
			if($label != false) $this->wrapper_start($label, $required);
		?>
			<input autocomplete="off"  data-a-sign=" " data-a-dec="," data-a-sep="."  <?php if($required) echo 'required'; ?> class="autonumeric form-control <?php echo($class); ?>" type="number" id="<?php echo $name; ?>" <?php echo($custom); ?> name="<?php echo $name; ?>" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>" />
		<?php
			if($label != false) $this->wrapper_end();
		}
		
		public function input_password($label = false, $name, $value, $placeholder = '', $required = false) {
		?>
			<div class="form-group">
				<?php if($label != false) { ?>
					<label for="<?php echo $name; ?>" class="control-label form-label"><?php echo $label; ?></label>
					<?php if($required) { $this->span_required(); } ?>
				<?php } ?>
				<input <?php if($required) echo 'required'; ?> class="form-control" type="password" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" placeholder="<?php echo $placeholder; ?>" />
			</div>
		<?php 
		}
		
		
		public function button_submit($name, $value, $class = '', $wrapper = true) {
		?>
			<?php if($wrapper) { ?><div class="submit-section"><?php } ?>
				<div class="form-group">
					<button class="btn <?php echo $class; ?>" type="submit" id="<?php echo $name; ?>" name="<?php echo $name; ?>">
						<?php echo $value; ?>
					</button>
				</div>
			<?php if($wrapper) { ?></div><?php } ?>
		<?php 
		}
		
		public function button($name, $value, $class = '', $submit = true, $data = '', $echo = true, $tooltip_text = '') {
			if($submit) $submit =  'type="submit"';
			else $submit = '';

			$tooltip = $this->get_tooltip_attribut($tooltip_text);

			$html = '<a '.$tooltip.' '.$data.' '.$submit.' class="btn text-white '.$class.'" id="'.$name.'" name="'.$name.'">'.$value.'</a>'; 
		
			if($echo == true) echo $html;
			else return $html;
		}
		
		public function button_link($href, $value, $class, $echo = true, $target = '_self') {

			$html = '<a target="'.$target.'" class="btn '.$class.'" href="'.$href.'">'.$value.'</a>';
			if($echo) echo $html;
			else return $html;
		}

		public function link($href, $text, $class = 'link', $target='_self') {
			$html = '<a target="'.$target.'" class="'.$class.'" href="'.$href.'">'.$text.'</a>';
			return $html;
		}
		
		public function textarea($label, $name, $value = '', $required = false, $wrapper = true) {
			$value = $this->format_textarea_value($value);
		?>
			<?php if($wrapper) { ?>
			<div class="form-group">
				<?php if($label != false) { ?>
					<label for="<?php echo $name; ?>" class="control-label form-label"><?php echo $label; ?></label>
					<?php if($required) { $this->span_required(); } ?>
				<?php } ?>
			<?php } ?>
				<textarea autocomplete="off" <?php if($required) echo 'required'; ?> class="form-control" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" rows="8"><?php echo $value; ?></textarea>
			<?php if($wrapper) { ?> </div> <?php } ?>
		<?php 
		}

		public function format_textarea_value($value) 
		{
			
			$value = str_replace("\\n", "&#13;&#10;", $value);
			$value = str_replace("\n\n", "&#13;&#10;", $value);
			$value = str_replace("\\n\\n", "&#13;&#10;", $value);
			$value = str_replace("\\r\\n", "&#13;&#10;", $value);
			return $value;
		}
		
		public function wysiwyg($label, $name, $value = '', $required = false) {
		?>
			<div class="form-group">
				<?php if($label != false) { ?>
					<label for="<?php echo $name; ?>" class="control-label form-label"><?php echo $label; ?></label>
					<?php if($required) { $this->span_required(); } ?>
				<?php } ?>
				<textarea id="<?php echo $name; ?>" <?php if($required) echo 'required'; ?> rows="20" class="form-control wysiwyg" name="<?php echo $name; ?>"><?php echo $value; ?></textarea>
			</div>
		<?php 
		}
		
		public function input_file($label = false, $name, $value = '', $required = false, $hinweis = NULL) {
		?>
			<div class="form-group">
				<label><?php echo $label; ?></label>
				<?php if($required) { $this->span_required(); } ?>
				<br/>
				<input id="<?php echo $name; ?>" name="<?php echo $name; ?>" type="file" value="<?php echo $value; ?>" <?php if($required) echo 'required'; ?> />
				<?php if($hinweis != NULL) { ?>
					<p class="hinweis-text"><?php echo $hinweis; ?></p>
				<?php } ?>
			</div>
		<?php 
		}
		
		public function input_toggle($label = false, $name, $value = '', $class='', $data='') {
		?>
			<div class="form-group">
				<?php if(false != $label) { ?><label><?php echo $label; ?></label><?php } ?>			
				<div class="custom-toggle">
					<input id="<?php echo $name; ?>" <?php echo $data; ?> name="<?php echo $name; ?>"  <?php if($value == '1') echo 'checked'; ?> type="checkbox" class="check <?php echo $class ?>"/>
					<label for="<?php echo $name; ?>" class="checktoggle">checkbox</label>
				</div>
			</div>	
		<?php 
		}
		
		public function checkbox($label = false, $id, $name, $value = '', $checked_value = '0') {
			$checked = '';
			if($checked_value == '1') $checked = 'checked';
		?>
			<?php if($label != false) { ?> 
			<div class="checkbox">
				<label for="<?php echo $id; ?>">
			<?php } ?>
					<input 
						type="checkbox" 
						class="checkbox" 
						id="<?php echo $id; ?>" 
						name="<?php echo $name; ?>" 
						value="<?php echo $value; ?>" 
						<?php echo $checked; ?>
					> 
				<?php if($label != false) { ?>
					<span><?php echo $label; ?></span>	
				</label>
			</div>
			<?php } ?>
		<?php 
		}

		public function radio($label, $id, $name, $value = '', $checked = '') {
			
		?>
			<div class="checkbox">
				<label for="<?php echo $id; ?>">
					<input 
						type="radio" 
						class="checkbox" 
						id="<?php echo $id; ?>" 
						name="<?php echo $name; ?>" 
						value="<?php echo $value; ?>" 
						<?php echo $checked; ?>
					> 
					<span><?php echo $label; ?></span>	
				</label>
			</div>
		<?php 
		}
		
		public function status_edit($value = '', $id, $table) {
			$input_id = $table.'_'.$id;
		?>
			<div class="status-toggle">
				<input id="<?php echo $input_id; ?>" type="checkbox" data-id="<?php echo $id; ?>" data-table="<?php echo $table; ?>" class="check js_status_change" <?php if($value == "aktiv") echo 'checked'; ?>>
				<label for="<?php echo $input_id; ?>" class="checktoggle">checkbox</label>
			</div>
		<?php 
		}
		
		public function select($label, $name, $options, $selected_value = '', $required = false, $z_class = '', $multiple = false, $data = '') {
			$class = 'form-control';
			if($z_class != '') $class .= ' '.$z_class;

		?>
			<div class="form-group">
				<?php if($label != false) { ?><label for="<?php echo $name; ?>" class="control-label form-label"><?php echo $label; ?></label><?php } ?>
				<?php if($required) { $this->span_required(); } ?>
				<select <?php echo $data; ?> <?php if($multiple) echo 'multiple'; ?> <?php if($required) echo 'required'; ?> class="<?php echo $class; ?>" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="width:100%;">
					<?php foreach($options AS $key => $value) { 
						$selected = '';
						if((is_array($selected_value)) && ($multiple == true)) {
							if(in_array($key, $selected_value)) $selected = 'selected';
						} else if($selected_value == $key) $selected = 'selected';	
					?>
						<option value="<?php echo $key; ?>" <?php echo $selected; ?>>
							<?php echo $value; ?>
						</option>
					<?php } ?>
				</select>
			</div>
		<?php 
		}

		public function toggle($checked, $name, $class = '') {
			if($checked == '1') $checked = true;
		?>
			<div class="status-toggle">
				<input id="<?php echo $name; ?>" name="<?php echo $name; ?>" type="checkbox" class="check <?php echo $class;?>" <?php if($checked == true) echo 'checked'; ?>>
				<label for="<?php echo $name; ?>" class="checktoggle">checkbox</label>
			</div>
		<?php 
		}

		
		public function user($wrapper = true, $value = '', $field_name = 'user_id', $label = 'User', $required = true, $multiple = false) {
			global $c_user;
			$users = $c_user->get_all();
			

			if($wrapper != true) $label = $wrapper;

			$values = $this->helper->get_key_values_from_array(
				$users, 
				'user_id', 
				'username',
				true
			);


			if($multiple == true) {
				$empty_value = false;
				$field_name .= '[]';
			}

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				$multiple
			);
		}

		public function artikel($wrapper = true, $value = '', $field_name = 'artikel_id', $label = 'Artikel', $required = true) {
			global $c_artikel;
			$artikel = $c_artikel->get_all();
			

			if($wrapper != true) $label = $wrapper;

			$values = $this->helper->get_key_values_from_artikel(
				$artikel
			);

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function artikel_webhosting($wrapper = true, $value = '', $field_name = 'artikel_webhosting_id', $label = 'Artikel', $required = true) {
			global $c_artikel;
			$artikel = $c_artikel->get_all('', 14);
			

			if($wrapper != true) $label = $wrapper;

			$values = $this->helper->get_key_values_from_artikel(
				$artikel
			);

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function fahrzeug_marke($wrapper = true, $value = '', $field_name = 'fahrzeug_marke', $label = 'Marke', $required = true) {
			
			if($wrapper != true) $label = $wrapper;

			$values = $this->helper->get_marken();

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function einheit($wrapper = true, $value = '', $field_name = 'einheit_id', $label = 'Einheit', $required = true) {
			global $c_einheit;
			$einheiten = $c_einheit->get_all();
			

			if($wrapper != true) $label = $wrapper;

			$values = $this->helper->get_key_values_from_array(
				$einheiten, 
				'einheit_id', 
				'bezeichnung',
				true
			);


			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

        public function rechnung_jahr($wrapper = true, $value = '', $field_name = 'rechnung_jahr', $label = 'Jahr', $required = true) {
			global $c_rechnung;
			$min = $c_rechnung->get_min_jahr();
			if($min == '-0001') $min = date('Y');
			$max = date('Y');
            $values = array();

			for($start=$min; $start<=$max; $start++) {
                $values[$start] = $start;
            }
			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function monat($wrapper = true, $value = '', $field_name = 'monat', $label = 'Monat', $required = true) {
			
            $values = array(
				'01' => 'Januar',
				'02' => 'Februar',
				'03' => 'März',
				'04' => 'April',
				'05' => 'Mai',
				'06' => 'Juni',
				'07' => 'Juli',
				'08' => 'August',
				'09' => 'September',
				'10' => 'Oktober',
				'11' => 'November',
				'12' => 'Dezember',
			);

			
			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function zammad_organisation($wrapper = true, $value = '', $field_name = 'zammad_organisation_id', $label = 'Organisation', $required = false) {
			global $c_cache;
			$organisationen = $c_cache->get_zammad_organisationen();
			

			if($wrapper != true) $label = $wrapper;

			$values = $this->helper->get_key_values_from_array(
				$organisationen, 
				'id', 
				'name',
				true
			);

			$values['none'] = 'Leere Organisationen';


			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function zahlungsart($wrapper = true, $value = '', $field_name = 'zahlungsart_id', $label = 'Zahlungsart', $required = true) {
			global $c_zahlungsart;
			$zahlungsarten = $c_zahlungsart->get_all();
			
			if($wrapper != true) $label = $wrapper;

			$values = $this->helper->get_key_values_from_array(
				$zahlungsarten, 
				'zahlungsart_id', 
				'bezeichnung',
				true
			);

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function zyklus($wrapper = true, $value = '', $field_name = 'zyklus_id', $label = 'Abrechnungszyklus', $required = true) {
			global $c_zyklus;
			$zyklen = $c_zyklus->get_all();
			

			if($wrapper != true) $label = $wrapper;

			$values = $this->helper->get_key_values_from_array(
				$zyklen, 
				'zyklus_id', 
				'bezeichnung',
				true
			);

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function rechnung_mahnung($wrapper = true, $value = '', $field_name = 'kunde_id', $label = 'Kunde', $required = true) {
			global $c_rechnung;
			$kunden = $c_rechnung->get_all($status);
			

			if($wrapper != true) $label = $wrapper;
 
			$values = $this->helper->get_key_values_from_kunde(
				$kunden
			);

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function kunde($wrapper = true, $value = '', $field_name = 'kunde_id', $label = 'Kunde', $required = true) {
			global $c_kunde;
			$kunden = $c_kunde->get_all('aktiv');
			

			if($wrapper != true) $label = $wrapper;
 
			$values = $this->helper->get_key_values_from_kunde(
				$kunden
			);

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function server($wrapper = true, $value = '', $field_name = 'server_id', $label = 'Server', $required = true) {
			global $c_server;
		
			$server = $c_server->get_all('aktiv');


			if($wrapper != true) $label = $wrapper;
 
			$values = $this->helper->get_key_values_from_array(
				$server,
				'server_id', 
				'name',
				true
			);

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function kategorien($wrapper = true, $value = '', $field_name = 'kategorien[]', $label = 'Kategorien', $required = true) {
			global $c_kategorie;
			$kategorien = $c_kategorie->get_all();
			

			if($wrapper != true) $label = $wrapper;

			$values = $this->helper->get_key_values_from_array(
				$kategorien, 
				'kategorie_id', 
				'name',
				false
			);

			
			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				true
			);
		}

		

		

		public function mwst($wrapper = true, $value = '', $field_name = 'mwst_id', $label = 'Mehrwertsteuersatz', $required = true) {
			global $c_mwst;
			$mwsts = $c_mwst->get_all();
			

			if($wrapper != true) $label = $wrapper;

			$values = $this->helper->get_key_values_from_array(
				$mwsts, 
				'mwst_id', 
				'bezeichnung',
				true
			);

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function ort($wrapper = true, $value = '', $field_name = 'ort_id', $label = 'Ort', $required = true) {
			global $c_ort;
			$orte = $c_ort->get_all();
			

			if($wrapper != true) $label = $wrapper;

			$values = $this->helper->get_key_values_from_array(
				$orte, 
				'ort_id', 
				'ortsname',
				true
			);


			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}
		

		public function geschlecht($wrapper = true, $value = '', $field_name = 'geschlecht') {
			$values = array(
				'-'    => '',
				'Männlich' => 'Männlich',
				'Weiblich' => 'Weiblich'
			);

			if($wrapper == true) $label = 'Geschlecht';
			else $label = $wrapper;

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				true,
				'select2'
			);
		}

		public function artikel_typ($wrapper = true, $value = '', $field_name = 'artikel_typ_id', $required = true) {
			
			global $c_artikel_typ;
			$artikel_typen = $c_artikel_typ->get_all();

			$values = $this->helper->get_key_values_from_array(
				$artikel_typen, 
				'artikel_typ_id', 
				'bezeichnung',
				true
			);

			if($wrapper == true) $label = 'Artikeltyp';
			else $label = $wrapper;

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2'
			);
		}

		public function anrede($wrapper = true, $value = '', $field_name = 'anrede') {
			
			global $c_ansprechpartner;
			$values = $c_ansprechpartner->get_anreden();

			if($wrapper == true) $label = 'Anrede';
			else $label = $wrapper;

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				false,
				'select2'
			);
		}

		public function theme_mode($wrapper = true, $value = '', $field_name = 'theme_mode') {
			
			$values = array(
				'light' => 'Light',
				'dark'  => 'Dark'
			);

			if($wrapper == true) $label = 'Theme Mode';
			else $label = $wrapper;

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				false,
				'select2'
			);
		}

		public function kunde_suche($wrapper = true, $value = '', $field_name = 'kunde_suche') {
			
			$values = array(
				''         => 'Firmenname',
				'suchname' => 'Firmenname (Suchname)',
				'adresse'  => 'Firmenname (Adresse)'
			);

			if($wrapper == true) $label = 'Kundensuche';
			else $label = $wrapper;

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				false,
				'select2'
			);
		}

		public function bericht($wrapper = true, $value = '', $field_name = 'bericht') {
			
			$values = array(
				'einkommen'         => 'Einkommen',
				'rechnungsausgang'  => 'Rechnungsausgang'
			);

			if($wrapper == true) $label = 'Berichte';
			else $label = $wrapper;

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				false,
				'select2'
			);
		}

		public function statistik($wrapper = true, $value = '', $field_name = 'statistik') {
			
			$values = array(
				'kunden'  => 'Kunden',
				'artikel' => 'Artikel'
			);

			if($wrapper == true) $label = 'Statistik';
			else $label = $wrapper;

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				false,
				'select2'
			);
		}


		

		public function rolle($wrapper = true, $value = '', $field_name = 'rolle_id') {
			
			global $c_rolle;
			$rollen = $c_rolle->get_all();
			$values = array();

			foreach($rollen AS $rolle) {
				$values[$rolle['rolle_id']] = $rolle['name'];
			}

			if($wrapper == true) $label = 'Rolle';
			else $label = $wrapper;

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				false,
				'select2'
			);
		}

		
		public function foto_upload($width, $height) {
		?>
			<div class="form-group">
				<label class="control-label">Foto hochladen</label>  
				<div class="col-md-12">
					<div id="retrievingfilename" class="html5imageupload" data-width="<?php echo $width; ?>" data-height="<?php echo $height; ?>" data-url="/controllers/Canvas.php" >
						<input type="file" name="thumb" />
					</div>
					<input type="hidden" name="foto" id="filename" class="form-control" />
				</div>  
			</div>
		<?php 
		}
		
		public function image_upload($label, $name, $width, $height) {
		?>
			<div class="form-group">
				<label class="control-label"><?php echo $label; ?></label>  
				<div class="col-md-12">
					<div id="retrievingfilename" class="html5imageupload" data-width="<?php echo $width; ?>" data-height="<?php echo $height; ?>" data-url="/website/infotainment/controllers/Canvas.php" >
						<input type="file" name="thumb" />
					</div>
					<input type="hidden" name="<?php echo $name; ?>" id="filename" class="form-control" />
				</div>  
			</div>
		<?php 
		}
		
		public function delete($id, $table, $title= 'löschen') {
		?>		
			<a data-id="<?php echo $id; ?>" data-table="<?php echo $table; ?>" class="btn btn-sm bg-danger-light js_delete_entry" data-toggle="modal" href="#modal_delete">
				<i class="fe fe-trash"></i> <?php echo $title; ?>
			</a>
		<?php 
		}
		
		public function get_tooltip_attribut($tooltip_text) {
			if($tooltip_text == '') return '';
			else return 'data-toggle="tooltip" data-placement="top" title="'.$tooltip_text.'"';
		}
		
		public function edit($id, $class, $href, $target="_self", $tooltip_text = '') {
			$tooltip = $this->get_tooltip_attribut($tooltip_text);
			$html = '<a '.$tooltip.' target="'.$target.'" data-id="' . $id . '" class="btn btn-sm btn-warning ' . $class . '" href="' . $href . '">' .
						'<i class="fe fe-pencil"></i>' .
					'</a>';
			return $html;
		}

		public function modal_header($title) 
		{
		?>
			<div class="modal-header">
				<h5 class="modal-title"><?php echo $title; ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		<?php 
		}

		public function modal_delete() {
		?>
			<div id="modal_delete" class="modal fade bd-example-modal-xl" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<?php $this->modal_header('Löschung'); ?>
						<div class="modal-body">
							<div id="form_modal_delete">
								<p>Möchten Sie den Eintrag wirklich löschen?</p>
								<?php 
									$this->button(
										'save_modal_delete', 
										'Eintrag löschen', 
										'btn btn-success btn-block'
									); 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		
		public function drucken() {
		?>
			<a onclick="window.print();" class="btn btn-sm btn-icon btn-success text-white">
				ausdrucken <i class="fa fa-print"></i>
			</a>
		<?php 
		}

		public function location_reload($label = 'neu laden') {
		?>
			<a onclick="location_reload()" class="btn btn-sm btn-icon btn-warning text-white">
				<?php echo $label; ?> <i class="fa fa-repeat"></i>
			</a>
		<?php 
		}

		
		public function beitraege($id, $typ, $disabled = false) {
		?>
			<div class="beitrag-area print_hidden">
				<ul class="js_beitraege_list" data-disabled="<?php echo $this->helper->strbool($disabled); ?>">
					<!-- Beiträge wird mit JS nachgeladen -->
				</ul>
				<div class="beitrag-form">
					<?php $this->add_beitrag($id.$typ, $id, $typ); ?>
				</div>
			</div>
		<?php
		}

		public function add_beitrag($wysiwyg_id, $id, $typ) 
		{
			$this->modal_beitrag_bearbeiten();
			$this->modal_beitrag_kommentar();
			$this->wysiwyg(
				false, 
				'js_beitrag_posten', 
				'', 
			);
		?>
			<div class="row justify-content-center">
				<div class="col-md-4">
					<?php 
						$this->button(
							'js_btn_beitrag_submit', 
							'Beitrag posten', 
							'btn btn-warning btn-block', 
							false,
							'data-id="'.$id.'" data-typ="'.$typ.'"'
						);
					?>
				</div>
			</div>
		<?php 
		}


		public function modal_beitrag_bearbeiten() {
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_beitrag_bearbeiten" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Beitrag bearbeiten'
							); 
						?>
						<div class="modal-body">
							<?php 
								$this->input_hidden('modal_beitrag_bearbeiten_id', '');
								$this->wysiwyg(
									false, 
									'wysiwyg_beitrag_bearbeiten', 
									'js_beitrag_bearbeiten', 
									''
								);
								$this->button(
									'js_modal_beitrag_bearbeiten_submit', 
									'Änderung speichern', 
									'btn btn-primary', 
									false
								);
							?>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function modal_beitrag_kommentar() {
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_beitrag_kommentar" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header('Kommentar'); 
						?>
						<div class="modal-body">
							<?php 
								$this->input_hidden('modal_kommentar_beitrag_id', '');
								$this->input_hidden('modal_kommentar_id', '');
								$this->input_hidden('modal_kommentar_action', '');
								$this->wysiwyg(
									false, 
									'wysiwyg_beitrag_kommentar', 
									'js_beitrag_kommentar', 
									''
								);
								$this->button(
									'js_modal_beitrag_kommentar_submit', 
									'Änderung speichern', 
									'btn btn-primary', 
									false
								);
							?>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function modal_email_logs($id, $eintrag_typ) {
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_email_logs" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header('E-Mail Logs'); 
						?>
						<div class="modal-body padding-0">
							<?php include dirname(__FILE__).'/../includes/table/table-email-logs.php'; ?>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function modal_abonnement_vertrag_anlegen() {
			$praefix = 'mava_';
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_abonnement_vertrag_anlegen" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header('Vertrag anlegen'); 
						?>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<?php 
										$this->artikel(
											true, 
											'',
											$praefix.'artikel_id'
										);
									?>
								</div>
								<div class="col-md-6">
									<?php 
										$this->select(
											'Abrechnungszyklus',
											$praefix.'zyklus_id',
											'',
											'',
											true
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php
										$this->input_number(
											'Menge', 
											$praefix.'artikel_menge', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
								<div class="col-md-6">
									<?php
										$this->zahlungsart(
											true,
											'',
											$praefix.'zahlungsart_id'
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php 
										$this->input_date(
											'Start', 
											$praefix.'start', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
								<div class="col-md-6">
									<?php 
										$this->input_date(
											'Ende', 
											$praefix.'ende', 
											'', 
											'', 
											$required = false
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="button-row">
										<?php 
											$this->button(
												'js_modal_abonnement_vertrag_anlegen_submit', 
												'Anlegen', 
												'btn btn-success', 
												false
											);
											$this->button(
												'js_modal_abonnement_individuelle_position', 
												'Individuelle Position hinzufügen', 
												'btn btn-blue', 
												false
											);

										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}
		
	
		public function tabs_navigation(String $headline, Array $elements) {
			$counter = 1;
		?>
			<ul class="tab">
				<li class="tabs_header"><h3><?php echo $headline; ?></h3></li>
				<?php foreach($elements AS $element_key => $element_value) { ?>
					<li class>
						<button class="tablinks <?php if($counter == 1) echo 'active'; ?>" onclick="openCity(event, '<?php echo $element_key; ?>')">
							<?php echo $element_value; ?>
						</button>
					</li>
					<?php $counter++; ?>
				<?php } ?>
				
			</ul>
		<?php 
		}


		public function modal_anhang_hinzufuegen() {
			$files = '';
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_anhang_hinzufuegen" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php $this->html->modal_header('Anhang hinzufügen'); ?>
						<div class="modal-body">
							<div>
								<?php 
									$this->upload_area(
										'anhang', 
										$files
									); 
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}
	

		public function freitext_suche_filter($id, $statis)
		{

			$statis = array('alle' => array('label' => 'Alle', 'class' => '')) + $statis;

			$status = array();
			foreach($statis AS $key => $value) {
				$status[$key] = $value['label'];
			}
		?> 
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<?php 
							$this->input_text(
								'Suche', 
								$id, 
								'', 
								'', 
								$required = true 
							);
						?>
					</div>
				</div>
				<div class="col-md-4">
					<?php 
						$this->select(
							'Status', 
							'filter_status', 
							$status, 
							$value, 
							false,
							'',
							false
						);
					?>
				</div>
			</div>
		<?php
		}

		public function freitext_suche_server_filter($id, $server)
		{
			$server_liste = array();
			$server_liste['alle'] = 'Alle';
			foreach($server AS $value) {
				$server_liste[$value['name']] = $value['name'];
			}
		?> 
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<?php 
							$this->input_text(
								'Suche', 
								$id, 
								'', 
								'', 
								$required = true 
							);
						?>
					</div>
				</div>
				<div class="col-md-4">
					<?php 
						$this->select(
							'Server', 
							'filter_server', 
							$server_liste, 
							$value, 
							false,
							'',
							false
						);
					?>
				</div>
			</div>
		<?php
		}

		public function modal_angebot_anlegen() {
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_angebot_anlegen" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Angebot anlegen'
							); 
						?>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-4">
									<?php 
										$this->input_disabled(
											'', 
											'Angebotsnummer',
											'angebotsnummer'
										);
									?>
								</div>
								<div class="col-md-4">
									<?php 
										$this->input_date(
											'Angebotsdatum', 
											'angebotsdatum', 
											date('d.m.Y'), 
											'', 
											$required = true
										);
									?>
								</div>
								<div class="col-md-4">
									<?php 
										$this->input_date(
											'Fällig am', 
											'faellig_am', 
											date('d.m.Y', strtotime(date('Y-m-d'). ' + 14 days')), 
											'', 
											$required = true
										);
									?>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->kunde();
									?>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->button(
											'js_modal_angebot_anlegen_submit', 
											'Angebot anlegen', 
											'btn btn-success', 
											false
										);
									?>
								</div>
							</div>
								
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function modal_rechnung_anlegen() {
			global $c_rechnung;
			$heute = date('Y-m-d');
			$faellig_am = $c_rechnung->get_faellig_am($heute);
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_rechnung_anlegen" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Rechnung anlegen'
							); 
						?>
						<div class="modal-body">
							
							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->input_disabled(
											'', 
											'Rechnungsnummer',
											'rechnungsnummer'
										);
									?>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->kunde();
									?>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<?php 
										$this->input_date(
											'Rechnungsdatum', 
											'rechnungsdatum', 
											$this->helper->german_date_no_time($heute), 
											'', 
											$required = true
										);
									?>
								</div>
								<div class="col-md-6">
									<?php 
										$this->input_date(
											'Fällig am', 
											'faellig_am', 
											$this->helper->german_date_no_time($faellig_am), 
											'', 
											$required = true
										);
									?>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->button(
											'js_modal_rechnung_anlegen_submit', 
											'Rechnung anlegen', 
											'btn btn-success', 
											false
										);
									?>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function modal_mahnung_anlegen() {
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_mahnung_anlegen" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Mahnung anlegen'
							); 
						?>
						<div class="modal-body">
							<?php 
								$this->rechnung();
								$this->button(
									'js_modal_mahnung_anlegen_submit', 
									'Mahnung anlegen', 
									'btn btn-success', 
									false
								);
							?>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function modal_angebot_position_hinzufuegen() {
			$praefix = 'maph_';
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_angebot_position_hinzufuegen" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Position hinzufügen'
							); 
						?>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-9">
									<?php 
										$this->artikel(
											true,
											'',
											$praefix.'artikel_id'
										); 
									?>
								</div>
								<div class="col-md-3">
									<?php
										$this->input_number(
											'Menge', 
											$praefix.'menge', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
							</div>

							<?php if($this->einstellungen['rechnung_datum_nach_leistungsdatum'] == '0') { ?>
								<div class="row">
									<div class="col-md-12">
										<?php
											$this->select(
												'Abrechnungszyklus',
												$praefix.'zyklus_id',
												'',
												'',
												true
											);
										?>
									</div>
								</div>
							<?php } ?>

							<?php 
								if(isset($this->aktive_module['lackierer_kfz'])) $this->get_rechnung_angebot_position_fahrzeugdaten($praefix); 
								if(isset($this->aktive_module['teppichreinigung'])) $this->get_rechnung_angebot_position_teppichreinigung($praefix);
							?>

							<div class="row">
								<div class="col-md-12">
									<div class="button-row">
										<?php 
											$this->button(
												'js_modal_angebot_position_anlegen_submit', 
												'Position hinzufügen', 
												'btn btn-success', 
												false
											);
											$this->button(
												'js_modal_angebot_position_individuelle_position', 
												'Individuelle Position hinzufügen', 
												'btn btn-blue', 
												false
											);

										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function modal_rechnung_position_hinzufuegen() {
			$praefix = 'mrph_';
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_rechnung_position_hinzufuegen" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Position hinzufügen'
							); 
						?>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<?php 
										$this->artikel(
											true,
											'',
											$praefix.'artikel_id'
										); 
									?>
								</div>
								<div class="col-md-3">
									<?php
										$this->input_number(
											'Menge', 
											$praefix.'menge', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
								<?php if($this->einstellungen['rechnung_datum_nach_leistungsdatum'] == '1') { ?>
								<div class="col-md-3">
									<?php
										$this->input_date(
											'Leistungsdatum', 
											$praefix.'leistungsdatum', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
								<?php } else { ?>
									<div class="col-md-3">
										<?php
											$this->select(
												'Abrechnungszyklus',
												$praefix.'zyklus_id',
												'',
												'',
												true
											);
										?>
									</div>
								<?php } ?>
								
							</div>
							
							<?php 
								if(isset($this->aktive_module['lackierer_kfz'])) $this->get_rechnung_angebot_position_fahrzeugdaten($praefix); 
								if(isset($this->aktive_module['teppichreinigung'])) $this->get_rechnung_angebot_position_teppichreinigung($praefix);
							?>
		

							<div class="row">
								<div class="col-md-12">
									<div class="button-row">
										<?php 
											$this->button(
												'js_modal_rechnung_position_anlegen_submit', 
												'Position hinzufügen', 
												'btn btn-success', 
												false
											);
											$this->button(
												'js_modal_rechnung_position_individuelle_position', 
												'Individuelle Position hinzufügen', 
												'btn btn-blue', 
												false
											);

										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function get_rechnung_angebot_position_fahrzeugdaten($praefix)
		{
			if($this->einstellungen['rechnung_position_keine_pflichtfelder'] == '1') $required = false;
			else $required = true;
		?>
			<div class="row">
				<div class="col-md-6">
					<?php 
						$this->fahrzeug_marke(
							true,
							'',
							$praefix.'fahrzeug_marke',
							'Marke',
							$required
						); 
					?>
				</div>
				<div class="col-md-6">
					<?php
						$this->input_text(
							'Modell', 
							$praefix.'fahrzeug_modell', 
							'', 
							'', 
							$required
						);
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<?php
						$this->input_text(
							'Kennzeichen', 
							$praefix.'fahrzeug_kennzeichen', 
							'', 
							'', 
							$required
						);
					?>
				</div>
				<div class="col-md-6">
					<?php
						$this->input_text(
							'FIN', 
							$praefix.'fahrzeug_fin', 
							'', 
							'', 
							$required
						);
					?>
				</div>
			</div>
		<?php 
		}

		public function get_rechnung_angebot_position_teppichreinigung($praefix)
		{
			$required = true;
		?>
			<div class="row">
				<div class="col-md-6">
					<?php 
						$this->input_decimal(
							'Länge', 
							$praefix.'teppichreinigung_laenge', 
							'', 
							'', 
							$required
						);
					?>
				</div>
				<div class="col-md-6">
					<?php
						$this->input_decimal(
							'Breite', 
							$praefix.'teppichreinigung_breite', 
							'', 
							'', 
							$required
						);
					?>
				</div>
			</div>
			
		<?php 
		}

		public function modal_rechnung_zahlung_hinzufuegen() {
			$praefix = 'mrzh_';
			$heute = date('Y-m-d');
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_rechnung_zahlung_hinzufuegen" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Zahlung hinzufügen'
							); 
						?>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-4">
									<?php 
										$this->input_hidden('rechnung_id', $_GET['id']);
										$this->zahlungsart(
											true,
											1,
											$praefix.'zahlungsart_id'
										); 
									?>
								</div>
								<div class="col-md-4">
									<?php
										$this->input_waehrung(
											'Zahlungsbetrag', 
											$praefix.'zahlungsbetrag', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
								<div class="col-md-4">
									<?php
										$this->input_date(
											'Zahlungsdatum', 
											$praefix.'zahlungsdatum', 
											$this->helper->german_date_no_time($heute), 
											'', 
											$required = true
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<p>Rechnungsstatus wird automatisch auf bezahlt markiert, wenn bezahlte Summe größer oder gleich Rechnungssumme</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="button-row">
										<?php 
											$this->button(
												'js_modal_rechnung_zahlung_hinzufuegen_submit', 
												'Zahlung hinzufügen', 
												'btn btn-success', 
												false
											);
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		
	
		
		public function modal_angebot_individuelle_position_hinzufuegen() {
			$praefix = 'maiph_'
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_angebot_individuelle_position_hinzufuegen" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Individuelle Position hinzufügen'
							); 
						?>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-9">
									<?php 
										$this->input_text(
											'Artikelname', 
											$praefix.'artikel_name', 
											'', 
											'', 
											$required = true 
										);
									?>
								</div>
								<div class="col-md-3">
									<?php
										$this->input_number(
											'Menge', 
											$praefix.'menge', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php 
										$this->einheit(
											true,
											'',
											$praefix.'einheit_id'
										); 
									?>
								</div>
								<div class="col-md-6">
									<?php
										$this->input_waehrung(
											'Netto Preis', 
											$praefix.'netto_preis', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
							</div>
							<div class="row">
								<?php if($this->einstellungen['artikel_einrichtungsgebuehr_ausblenden'] == '0') { ?>
									<div class="col-md-4">
										<?php
											$this->input_waehrung(
												'Einrichtungsgebühr', 
												$praefix.'einrichtungsgebuehr', 
												'', 
												'', 
												$required = false
											);
										?>
									</div>
								<?php } ?>
								<?php if($this->einstellungen['rechnung_datum_nach_leistungsdatum'] == '0') { ?>
									<div class="col-md-4">
										<?php 
											$this->zyklus(
												true,
												'',
												$praefix.'zyklus_id'
											); 
										?>
									</div>
								<?php } ?>
								<div class="col-md-4">
									<?php 
										$this->artikel_typ(
											true,
											'',
											$praefix.'artikel_typ_id'
										); 
									?>
								</div>
							</div>
							
							<?php 
								if(isset($this->aktive_module['lackierer_kfz'])) $this->get_rechnung_angebot_position_fahrzeugdaten($praefix); 
								if(isset($this->aktive_module['teppichreinigung'])) $this->get_rechnung_angebot_position_teppichreinigung($praefix); 
							?>

							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->textarea(
											'Beschreibung', 
											$praefix.'beschreibung', 
											'', 
											false
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="button-row">
										<?php 
											$this->button(
												'js_modal_angebot_individuelle_position_anlegen_submit', 
												'Position hinzufügen', 
												'btn btn-success', 
												false
											);
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function modal_rechnung_individuelle_position_hinzufuegen() {
			$praefix = 'mriph_';
			$required = $this->get_rechnung_position_pflichtfelder();

 		?>
			<div class="modal fade bd-example-modal-xl" id="modal_rechnung_individuelle_position_hinzufuegen" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Individuelle Position hinzufügen'
							); 
						?>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-8">
									<?php 
										$this->input_text(
											'Artikelname', 
											$praefix.'artikel_name', 
											'', 
											'', 
											true
										);
									?>
								</div>
								<div class="col-md-4">
									<?php
										$this->input_waehrung(
											'Artikel Preis', 
											$praefix.'artikel_preis', 
											'', 
											'', 
											true
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4"> 
									<?php
										$this->input_number(
											'Menge', 
											$praefix.'artikel_menge', 
											'', 
											'', 
											true
										);
									?>
								</div>
								<div class="col-md-4">
									<?php 
										$this->einheit(
											true,
											'',
											$praefix.'einheit_id'
										); 
									?>
								</div>
								<div class="col-md-4">
									<?php 
										$this->artikel_typ(
											true,
											'',
											$praefix.'artikel_typ_id'
										); 
									?>
								</div>
								
							</div>

							<?php 
								if($this->einstellungen['rechnung_datum_nach_leistungsdatum'] == '1') $this->rechnung_modal_leistungsdatum($praefix);
								else $this->rechnung_modal_abrechnungszeitraum_zyklus($praefix);
							?>
							
							<?php 
								if(isset($this->aktive_module['lackierer_kfz'])) $this->get_rechnung_angebot_position_fahrzeugdaten($praefix); 
								if(isset($this->aktive_module['teppichreinigung'])) $this->get_rechnung_angebot_position_teppichreinigung($praefix); 
							?>

							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->textarea(
											'Beschreibung', 
											$praefix.'artikel_beschreibung', 
											'', 
											$required
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="button-row">
										<?php 
											$this->button(
												'js_modal_rechnung_individuelle_position_anlegen_submit', 
												'Position hinzufügen', 
												'btn btn-success', 
												false
											);
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function rechnung_modal_leistungsdatum($praefix) {
			$this->input_hidden($praefix.'abrechnungszeitrum_von', '');
			$this->input_hidden($praefix.'abrechnungszeitrum_bis', '');
			$this->input_hidden($praefix.'zyklus_id', '');
		?>
			<div class="row">
				<div class="col-md-12">
					<?php 
						$this->input_date(
							'Leistungsdatum', 
							$praefix.'leistungsdatum', 
							'', 
							'', 
							$required = true
						);
					?>
				</div>
			</div>
		<?php 
		}

		public function rechnung_modal_abrechnungszeitraum_zyklus($praefix) {
			$this->input_hidden($praefix.'leistungsdatum', '');
		?>
			<div class="row">
				<div class="col-md-4">
					<?php 
						$this->zyklus(
							true,
							'',
							$praefix.'zyklus_id'
						); 
					?>
				</div>
				<div class="col-md-4">
					<?php 
						$this->input_date(
							'Abrechnungszeitrum von', 
							$praefix.'abrechnungszeitrum_von', 
							'', 
							'', 
							$required = true
						);
					?>
				</div>
				<div class="col-md-4">
					<?php 
						$this->input_date(
							'Abrechnungszeitrum bis', 
							$praefix.'abrechnungszeitrum_bis', 
							'', 
							'', 
							$required = true
						);
					?>
				</div>
			</div>
		<?php 
		}

		

		public function modal_angebot_position_bearbeiten() {
			$praefix = 'mapb_';
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_angebot_position_bearbeiten" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Position bearbeiten'
							); 
						?>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->input_text(
											'Artikelname', 
											$praefix.'artikel_name', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
								
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php
										$this->input_number(
											'Menge', 
											$praefix.'menge', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
								<div class="col-md-6">
									<?php  
										$this->einheit(
											true,
											'',
											$praefix.'einheit_id'
										); 
									?>
								</div>
								
							</div>
							<div class="row">
								<?php if($this->einstellungen['artikel_einrichtungsgebuehr_ausblenden'] == '0') { ?>
									<div class="col-md-6">
										<?php
											$this->input_waehrung(
												'Einrichtungsgebühr', 
												$praefix.'einrichtungsgebuehr', 
												'', 
												'', 
												$required = true
											);
										?>
									</div>
								<?php } ?>
								<?php if($this->einstellungen['rechnung_datum_nach_leistungsdatum'] == '0') { ?>
									<div class="col-md-6">
										<?php  
											$this->zyklus(
												true,
												'',
												$praefix.'zyklus_id'
											); 
										?>
									</div>
								<?php } ?>
							</div>

							<div class="row">
								<div class="col-md-6">
									<?php
										$this->input_waehrung(
											'Netto Preis', 
											$praefix.'netto_preis', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
								<div class="col-md-6">
									<?php  
										$this->artikel_typ(
											true,
											'',
											$praefix.'artikel_typ_id'
										); 
									?>
								</div>
								
							</div>

							<?php 
								if(isset($this->aktive_module['lackierer_kfz'])) $this->get_rechnung_angebot_position_fahrzeugdaten($praefix); 
								if(isset($this->aktive_module['teppichreinigung'])) $this->get_rechnung_angebot_position_teppichreinigung($praefix); 
							?>

							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->textarea(
											'Beschreibung', 
											$praefix.'beschreibung', 
											'', 
											false
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="button-row">
										<?php 
											$this->button(
												'js_modal_angebot_position_bearbeiten_submit', 
												'Änderungen speichern', 
												'btn btn-success', 
												false
											);
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function modal_rechnung_position_bearbeiten() {
			$praefix = 'mrpb_';
			$required = $this->get_rechnung_position_pflichtfelder();
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_rechnung_position_bearbeiten" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Position bearbeiten'
							); 
						?>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->input_text(
											'Artikelname', 
											$praefix.'artikel_name', 
											'', 
											'', 
											true
										);
									?>
								</div>
								
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php
										$this->input_number(
											'Menge', 
											$praefix.'artikel_menge', 
											'', 
											'', 
											true
										);
									?>
								</div>
								<div class="col-md-6">
									<?php  
										$this->input_text(
											'Einheit', 
											$praefix.'artikel_einheit', 
											'', 
											'', 
											true
										);
									?>
								</div>	
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php
										$this->input_waehrung(
											'Artikel Preis', 
											$praefix.'artikel_preis', 
											'', 
											'', 
											true
										);
									?>
								</div>

								<div class="col-md-6">
									<?php  
										$this->input_text(
											'Artikel Typ', 
											$praefix.'artikel_artikel_typ', 
											'', 
											'', 
											$required
										);
									?>
								</div>
							</div>
							
							<?php $this->modal_rechnung_zeitraum($praefix); ?>
							<?php if(isset($this->aktive_module['lackierer_kfz'])) $this->get_rechnung_angebot_position_fahrzeugdaten($praefix); ?>

							
							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->textarea(
											'Beschreibung', 
											$praefix.'beschreibung', 
											'', 
											$required
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="button-row">
										<?php 
											$this->button(
												'js_modal_rechnung_position_bearbeiten_submit', 
												'Änderungen speichern', 
												'btn btn-success', 
												false
											);
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function modal_rechnung_zeitraum($praefix) {
			if($this->einstellungen['rechnung_datum_nach_leistungsdatum'] == '1') { 
			?>
				<div class="row">
					<div class="col-md-12">
						<?php 
							$this->input_date(
								'Leistungsdatum', 
								$praefix.'leistungsdatum', 
								'', 
								'', 
								$required = true
							);
						?>
					</div>
				</div>
			<?php 
			} else {
		?>
			<div class="row">
				<div class="col-md-4">
					<?php 
						$this->input_text(
							'Zyklus', 
							$praefix.'artikel_zyklus', 
							'', 
							'', 
							$required = true
						);
					?>
				</div>
				<div class="col-md-4">
					<?php 
						$this->input_date(
							'Abrechnungszeitraum von', 
							$praefix.'abrechnungszeitraum_von', 
							'', 
							'', 
							$required = true
						);
					?>
				</div>
				<div class="col-md-4">
					<?php 
						$this->input_date(
							'Abrechnungszeitraum bis', 
							$praefix.'abrechnungszeitraum_bis', 
							'', 
							'', 
							$required = true
						);
					?>
				</div>
			</div>
		<?php 
			}
		}

		public function modal_abonnement_anlegen() {
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_abonnement_anlegen" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Abonnement anlegen'
							); 
						?>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->kunde();
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="button-row">
										<?php 
											$this->button(
												'js_modal_abonnement_anlegen_submit', 
												'Abonnement anlegen', 
												'btn btn-success', 
												false
											);
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}


		public function modal_abonnement_vertrag_individuelle_position_anlegen() {
			$praefix = 'mavipa_';
		?>
		<div class="modal fade bd-example-modal-xl" id="modal_abonnement_vertrag_individuelle_position_anlegen" role="dialog" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<?php 
						$this->html->modal_header(
							'Individuelle Position anlegen'
						); 
					?>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<?php 
									$this->input_text(
										'Name', 
										$praefix.'artikel_name', 
										'', 
										'', 
										$required = true
									);
								?>
							</div>
							<div class="col-md-6">
								<?php
									$this->input_number(
										'Menge', 
										$praefix.'artikel_menge', 
										'', 
										'', 
										$required = true
									);
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<?php
									$this->input_waehrung(
										'Netto Betrag', 
										$praefix.'artikel_preis', 
										'', 
										'', 
										$required = true
									);
								?>
							</div>
							<div class="col-md-6">
								<?php
									$this->zahlungsart(
										true,
										'',
										$praefix.'zahlungsart_id'
									);
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<?php 
									$this->einheit(
										true,
										'',
										$praefix.'einheit_id'
									); 
								?>
							</div>
							<div class="col-md-6">
								<?php
									$this->zyklus(
										true,
										'',
										$praefix.'zyklus_id'
									); 
								?>
							</div>
						</div>
						
						<div class="row">
								<div class="col-md-4">
									<?php 
										$this->input_date(
											'Start', 
											$praefix.'start', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
								<div class="col-md-4">
									<?php 
										$this->input_date(
											'Ende', 
											$praefix.'ende', 
											'', 
											'', 
											$required = false
										);
									?>
								</div>
								<div class="col-md-4">
									<?php 
										$this->artikel_typ(
											true, 
											'', 
											$praefix.'artikel_typ_id', 
										);
									?>
								</div>
							</div>
						<div class="row">
							<div class="col-md-12">
								<?php 
									$this->textarea(
										'Beschreibung', 
										$praefix.'artikel_beschreibung', 
										'', 
										true
									);
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="button-row">
									<?php 
										$this->button(
											'js_modal_abonnement_vertrag_individuelle_position_anlegen_submit', 
											'Anlegen', 
											'btn btn-success', 
											false
										);
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php	
		}



		


		public function angebot_status($wrapper = true, $value = '', $label = 'Status', $required = true) {
			global $c_angebot;
			$status = $c_angebot->get_status();
			$values = array();

			foreach($status AS $status_key => $status_value) {
				$values[$status_key] = $status_value['label'];
			}
			

			if($wrapper != true) $label = $wrapper;

			$field_name = 'status';

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}

		public function rechnung_status($wrapper = true, $value = '', $label = 'Status', $required = true) {
			global $c_rechnung;
			$status = $c_rechnung->get_status();
			$values = array();

			foreach($status AS $status_key => $status_value) {
				$values[$status_key] = $status_value['label'];
			}
			

			if($wrapper != true) $label = $wrapper;

			$field_name = 'status';

			$this->select(
				$label, 
				$field_name, 
				$values, 
				$value, 
				$required,
				'select2',
				false
			);
		}


		public function modal_ansprechpartner_anlegen()
		{
			$praefix = 'maa_';
		?>
		<div class="modal fade bd-example-modal-xl" id="modal_ansprechpartner_anlegen" role="dialog" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<?php 
						$this->html->modal_header(
							'Ansprechpartner <span>anlegen</span>'
						); 
					?>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-4">
								<?php
									$this->anrede(
										true,
										'',
										$praefix.'anrede'
									);
								?>
							</div>
							<div class="col-md-4">
								<?php 
									$this->input_text(
										'Vorname', 
										$praefix.'vorname', 
										'', 
										'', 
										$required = true
									);
								?>
							</div>
							<div class="col-md-4">
								<?php 
									$this->input_text(
										'Nachname', 
										$praefix.'nachname', 
										'', 
										'', 
										$required = true
									);
								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<?php 
									$this->input_email(
										'E-Mail', 
										$praefix.'email', 
										'', 
										'', 
										$required = false
									);
								?>
							</div>
							<div class="col-md-4">
								<?php 
									$this->input_text(
										'Mobilnummer', 
										$praefix.'mobilnummer', 
										'', 
										'', 
										$required = false
									);
								?>
							</div>
							<div class="col-md-4">
								<?php 
									$this->input_toggle(
										'Whatsapp?', 
										$praefix.'whatsapp', 
										''
									);
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<?php 
									$this->input_text(
										'Bemerkung', 
										$praefix.'bemerkung', 
										'', 
										'', 
										$required = false
									);
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="button-row">
									<?php 
										$this->button(
											'js_modal_ansprechpartner_anlegen_submit', 
											'Anlegen', 
											'btn btn-success', 
											false
										);
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php 
		}

		public function modal_abonnement_vertrag_bearbeiten() {
			$praefix = 'mavb_';
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_abonnement_vertrag_bearbeiten" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Vertrag bearbeiten'
							); 
						?>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->input_text(
											'Artikelname', 
											$praefix.'artikel_name', 
											'',  
											'', 
											$required = true
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php
										$this->input_waehrung(
											'Preis', 
											$praefix.'artikel_preis', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
								<div class="col-md-6">
									<?php 
										$this->zahlungsart(
											true,
											'',
											$praefix.'zahlungsart_id', 
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php
										$this->input_number(
											'Menge', 
											$praefix.'artikel_menge', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
								<div class="col-md-6">
									<?php  
										$this->einheit(
											true,
											'',
											$praefix.'einheit_id'
										); 
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php
										$this->artikel_typ(
											true,
											'',
											$praefix.'artikel_typ_id'
										); 
									?>
								</div>
								<div class="col-md-6">
									<?php  
										$this->zyklus(
											true,
											'',
											$praefix.'zyklus_id'
										); 
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php 
										$this->input_date(
											'Start', 
											$praefix.'start', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
								<div class="col-md-6">
									<?php 
										$this->input_date(
											'Ende', 
											$praefix.'ende', 
											'', 
											'', 
											$required = false
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<?php 
										$this->textarea(
											'Beschreibung', 
											$praefix.'artikel_beschreibung', 
											'', 
											'', 
											true
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="button-row">
										<?php 
											$this->button(
												'js_modal_abonnement_vertrag_bearbeiten_submit', 
												'Änderungen speichern', 
												'btn btn-success', 
												false
											);
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function filter_zammad_tickets($jahr, $monat, $organisation) {
		?>
			<form method="POST" action="">
				<div class="row">
					<div class="col-md-3">
						<?php 
							$this->rechnung_jahr(
								true,
								$jahr
							);
						?>
					</div>
					<div class="col-md-3">
						<?php 
							$this->monat(
								true,
								$monat
							);
						?>
					</div>
					<div class="col-md-3">
						<?php 
							$this->zammad_organisation(
								true,
								$organisation
							);
						?>
					</div>
					<div class="col-md-3">
						<label>&nbsp;</label>
						<?php 
							$this->button_submit(
								'btn_submit_zammad',
								'Tickets anzeigen',
								'btn btn-primary btn-block',
								false
							);
						?>
					</div>
				</div>
			</form>
		<?php 
		}

		public function filter_berichte($von, $bis, $bericht) {
		?>
			<form method="GET" action="">
				<div class="row">
					<div class="col-md-3">
						<?php 
							$this->bericht(
								true,
								$bericht
							);
						?>
					</div>
					<div class="col-md-3">
						<?php 
							$this->input_date(
								'Von', 
								'von', 
								$von, 
								'', 
								$required = true
							);
						?>
					</div>
					<div class="col-md-3">
						<?php 
							$this->input_date(
								'Bis', 
								'bis', 
								$bis, 
								'', 
								$required = true
							);
						?>
					</div>
					
					<div class="col-md-3">
						<label>&nbsp;</label>
						<?php 
							$this->button_submit(
								'btn_submit_berichte_filter',
								'Anzeigen',
								'btn btn-primary btn-block',
								false
							);
						?>
					</div>
				</div>
			</form>
		<?php 
		}

		public function filter_statistik($statistik) {
		?>
			<form method="GET" action="">
				<div class="row">
					<div class="col-md-9">
						<?php 
							$this->statistik(
								true,
								$statistik
							);
						?>
					</div>
					<div class="col-md-3">
						<label>&nbsp;</label>
						<?php 
							$this->button_submit(
								'btn_submit_statistik_filter',
								'Anzeigen',
								'btn btn-primary btn-block',
								false
							);
						?>
					</div>
				</div>
			</form>
		<?php 
		}

		public function item_tabelle_filter($arten, $waren_art){
			$default = array_values($arten); 
			$default = $default['0'];
		?>

		<div class="row">
			<div class="col-md-12">
				<?php 
					foreach($arten AS  $label => $art){
						
						if($art == $default) $checked= 'checked';
						else $checked = '';
						$this->radio(
							$label, 
							'radio_'.$art, 
							'radio_'.$waren_art.'_filter',
							$art,
							$checked
						); 
					};
				?>
			</div>
		</div>
		<?php
		}

		public function modal_abonnement_vertrag_info() {
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_abonnement_vertrag_info" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header(
								'Vertragsinformationen'
							); 
						?>
						<div class="modal-body padding-0">
							<?php include dirname(__FILE__) .'/../includes/table/table-vertrag-info.php'; ?>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function upload_area($typ, $files, $label_datei = 'Dateiname', $disabled = false, $upload_area_class = '')
		{
			global $c_html;
		?>
			
			<div class="card">
				<?php $c_html->card_header('Dateien'); ?>
				<div class="card-body padding-0">
					<div class="row">
						<div class="col-md-12">
							<?php 
								$this->generate_file_table($files, $label_datei, $disabled);
							?>
						</div>
					</div> 
					
					<div class="row mb-20 print_hidden <?php echo $upload_area_class; ?>">
						<div class="col-md-12">
							<div class="upload-area" data-typ="<?php echo $typ; ?>">
								<div class="files-list"></div>
								<i class="fas fa-cloud-upload-alt"></i>
								<span class="upload-text">
									Ziehen Sie Dateien hierher oder klicken Sie, um sie hochzuladen.
								</span>
								<input id="fileInput" type="file" class="upload-input" />
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}

		public function generate_file_table($files, $label_datei = 'Dateiname', $disabled = false) 
		{
			global $c_helper;

			$table = '<div class="table-responsive">';
				$table .= '<table class="mb-20 table table-files table-bordered">';
					$table .= '<thead>';
						$table .= '<tr>';
							$table .= '<th>'.$label_datei.'</th>';
							$table .= '<th>Bezeichnung</th>';
							if($disabled == false) $table .= '<th>Löschen</th>';
						$table .= '</tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
						if(!empty($files)) {
							foreach ($files as $file) {
								$table .= '<tr data-id="'.$file['id'].'">';
									$table .= '<td>';
										$table .= '<a target="_blank" href="'.$c_helper->get_upload_path($file['dateiname']).'">';
											$table .= $file['dateiname'];
										$table .= '</a>';
									$table .= '</td>';
									$table .= '<td>';
										$table .= '<div class="editable-text">';
											$table .= '<span class="text edit-text">'.$file['description'].'</span>';
											if($disabled == false) $table .= '<button class="edit-icon"><i class="fa fa-pencil"></i></button>';
											if($disabled == false) $table .= '<button class="tick-icon"><i class="fa fa-check"></i></button>';
											if($disabled == false) $table .= '<input type="text" data-id="'.$file['id'].'" class="edit-input">';
										$table .= '<div>';
									$table .= '</td>';
									if($disabled == false) {
										$table .= '<td>';
											$table .= '<a href="#" onclick="deleteFileById(event, '.$file['id'].')">';
												$table .= '<i class="fe fe-trash text-danger"></i>';
											$table .= '</a>';
										$table .= '</td>';
									}
								$table .= '</tr>';
							}
						}
					$table .= '</tbody>';
				$table .= '</table>';
			$table .= '</div>';

			echo($table);
		}

		public function modal_artikel_preis_anlegen() {
			$praefix = 'mapa_';
		?>
			<div class="modal fade bd-example-modal-xl" id="modal_artikel_preis_anlegen" role="dialog" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-xl" role="document">
					<div class="modal-content">
						<?php 
							$this->html->modal_header('Vertrag anlegen'); 
						?>
						<div class="modal-body">
							
							<div class="row">
								<div class="col-md-6">
									<?php
										$this->zyklus(
											true, 
											'', 
											$praefix.'zyklus_id'
										);
									?>
								</div>
								<div class="col-md-6">
									<?php
										$this->input_waehrung(
											'Preis', 
											$praefix.'artikel_preis', 
											'', 
											'', 
											$required = true
										);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="button-row">
										<?php 
											$this->button(
												'js_modal_artikel_preis_anlegen_submit', 
												'Anlegen', 
												'btn btn-success', 
												false
											);
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	
		}

		public function modal_quality_hosting_rechnung_anlegen_rechnung_auswahl() {
			?>
				<div class="modal fade bd-example-modal-xl" id="modal_quality_hosting_rechnung_anlegen_rechnung_auswahl" role="dialog" aria-hidden="true" style="display: none;">
					<div class="modal-dialog modal-xl" role="document">
						<div class="modal-content">
							<?php 
								$this->html->modal_header('Quality Hosting Rechnung anlegen'); 
							?>
							<div class="modal-body padding-0">
								<?php include dirname(__FILE__).'/../includes/table/table-quality-hosting-rechnungen.php'; ?>
							</div>
						</div>
					</div>
				</div>
			<?php	
			}


	} 