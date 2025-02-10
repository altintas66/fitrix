<?php 

class Table_Helper {

    private $helper;
    private $button;
    private $html;
    private $form;
    private $url;
    private $aktive_module;
    private $einstellungen;

    public function __construct($helper, $button, $html, $form, $url, $aktive_module, $einstellungen) 
    {
        $this->helper         = $helper;
        $this->button         = $button;
        $this->html           = $html;
        $this->form           = $form;
        $this->url            = $url;
        $this->aktive_module  = $aktive_module;
        $this->einstellungen  = $einstellungen;
    }

    public function get_td_image($img_url, $link) 
    {
        return '
        <h2 class="table-avatar">
            <a href="'.$link.'" class="avatar avatar-xl mr-2">
                <img class="avatar-img" src="'.$img_url.'" />
            </a>
        </h2>';
    }

    public function get_td_user($buff) 
    {
        global $c_url;
        return '<a class="a_link" href="'.$c_url->get_user_bearbeiten($buff['user_id']).'">'.$buff['user_username'].'</a><br><span class="table-data-small">'.$buff['rolle'].'</span>';
    }

    public function get_td_user_markierung($buff) 
    {
        global $c_url;
        return '<a class="a_link" href="'.$c_url->get_user_bearbeiten($buff['user_id']).'">'.$buff['username'].'</a>';
    }

    public function get_td_kunde($buff) 
    {
        global $c_url;
        return '<a class="a_link" href="'.$c_url->get_kunde_bearbeiten($buff['kunde_id']).'">'.$buff['kunde_firmen_name'].'</a><br><span class="table-data-small">Suchname: '.$buff['kunde_suchname'].'</span>';
    }
    
    public function get_td_kunde_webseite($buff) 
    {
        global $c_url;
        return '<a class="a_link" target="blank" href="'.$buff['webseite'].'">'.$buff['webseite'].'</a>';
    }

    public function get_td_letzte_rechnung($buff) 
    {
        global $c_helper;
        if($buff != null) return $buff['rechnungsnummer'].' ('.$c_helper->german_date_no_time($buff['angelegt_am']).')';
        return 'nicht vorhanden';
    }

    public function get_artikel_foto($artikel) 
    {
        global $c_artikel, $c_url;
        $url = $c_url->get_artikel_bearbeiten($artikel['artikel_id']);
        $foto_url = $c_artikel->get_foto_url($artikel);
      

        $html = '<h2 class="table-avatar">';
            $html .= '<a href="'.$url.'" class="avatar avatar-xl mr-2">';
                $html .= '<img class="avatar-img" src="'.$foto_url.'" />';
            $html .= '</a>';
        $html .= '</h2>';
        return $html;
    }

    public function get_kunde_logo($kunde) 
    {
        global $c_kunde, $c_url;
        $url = $c_url->get_kunde_bearbeiten($kunde['kunde_id']);

        $html = '<h2 class="table-avatar">';
            $html .= '<a href="'.$url.'" class="avatar avatar-xl mr-2">';
                $html .= '<img class="avatar-img" src="'.$c_kunde->get_logo_url($kunde).'" />';
            $html .= '</a>';
        $html .= '</h2>';
        return $html;
    }

    public function get_table_tr_th_td($label, $value)
    {
        ob_start();
    ?>
        <tr>
            <th><?php echo $label; ?></th>
            <td><?php echo $value; ?></td>
        </tr>
    <?php 
        $html = ob_get_clean();
        return $html;
    }

    public function get_table_email_log($eintraege) {
        ob_start();
        foreach($eintraege AS $eintrag) {
    ?>
        <tr>
            <td>
                <?php echo $this->helper->german_date($eintrag['erstellt_am']); ?>
            </td>
            <td>
                <?php echo $eintrag['empfaenger']; ?>
            </td>
            <td>
                <?php echo $this->helper->string_neue_zeilen($eintrag['betreff'], 20); ?>
            </td>
            <td>
                <?php echo $this->helper->string_neue_zeilen($eintrag['text'], 30); ?>
            </td>
            <td>
                <?php echo $eintrag['smtp_response']; ?>
            </td>
        </tr>

    <?php 
        } 
        $html = ob_get_clean();
        return $html;
    }

     
    public function get_card_title_mit_verfuegbarkeit($title, $object) 
    {
        $html = $title;
        $html .= '<span class="ml-10">(<span class="js_anzahl_'.$object.'_tabelle">0</span>)</span>';
        
        return $html;  
    }

    public function get_abonnement_vertrag_info($vertrag)
    {
        $html = '<tr>';
            $html .= '<td>';
                $html .= $this->helper->german_date($vertrag['angelegt_am']);
            $html .= '</td>';
            $html .= '<td>';
                $html .= $this->helper->german_date($vertrag['bearbeitet_am']);
            $html .= '</td>';
            $html .= '<td>';
                $html .= $vertrag['vertragsnummer'];
            $html .= '</td>';
            $html .= '<td>';
                $html .= $this->helper->german_date_no_time($vertrag['start']);
            $html .= '</td>';
            $html .= '<td>';
                $html .= $this->helper->german_date_no_time($vertrag['ende']);
            $html .= '</td>';
            $html .= '<td>';
                $html .= $vertrag['zahlungsart_bezeichnung'];
            $html .= '</td>';
            $html .= '<td>';
                $html .= $vertrag['artikel_typ_bezeichnung'];
            $html .= '</td>';

        $html .= '</tr>';
        return $html;
    }

    public function get_artikel_preise($preise)
    {
        $html = '';
        if(is_array($preise) == false) return $html;
        if($preise == null) return $html;

        foreach($preise AS $preis) {
            $html .= '<tr>';
                $html .= '<td>';
                    $html .= $this->helper->german_date($preis['angelegt_am']);
                $html .= '</td>';
                $html .= '<td>';
                    $html .= $this->helper->german_date($preis['bearbeitet_am']);
                $html .= '</td>';
                $html .= '<td>';
                    $html .= $preis['zyklus_bezeichnung'];
                $html .= '</td>';
                $html .= '<td>';
                    $html .= $this->html->waehrung($preis['preis']);
                $html .= '</td>';
                $html .= '<td class="text-right">';
                    $html .= '<a data-id="'.$preis['artikel_preis_id'].'" class="btn btn-sm btn-danger text-white" onclick="delete_artikel_preis(this)"><i class="fa fa-trash"></i></a>';
                $html .= '</td>';
            $html .= '</tr>';
        }

        return $html;
    }

    public function get_table_quality_hosting_rechnungen($rechnungen, $reseller_customer_id)
    {
        ob_start();
        global $c_url, $c_form;
            foreach($rechnungen AS $rechnung) {
        ?>
            <tr>
                <td>
                    <?php echo $rechnung['rechnungsnummer']; ?>
                </td>
                <td>
                    <?php echo $this->html->waehrung($rechnung['gesamt_brutto']);?>
                </td>
                <td>
                    <a class="a_link" href="<?php echo $c_url->get_rechnung_bearbeiten($rechnung['rechnung_id']); ?>" target="_blank">Hier klicken</a>
                </td>
                <td>
                    <?php 
                        $data = 'data-rechnung-id = "'.$rechnung['rechnung_id'].'"';
                        $c_form->button(
                                    '', 
                                    'Hinzufügen', 
                                    'btn btn-sm btn-success js_qualityhost_positionen_rechnung_hinzufuegen', 
                                    false,
                                    $data
                                ); ?>
                </td>
            </tr>
    
        <?php 
            } 
            $html = ob_get_clean();
            return $html;
    }

    public function get_rechnung_table_positionen($positionen, $optionen = false) 
    {
        if(isset($this->aktive_module['lackierer_kfz'])) {
            $this->get_rechnung_table_header_lackierer_kfz($optionen);
            $this->get_rechnung_table_positionen_lackierer_kfz($positionen, $optionen);
        } else if(isset($this->aktive_module['teppichreinigung'])) {
            $this->get_rechnung_table_header_teppichreinigung($optionen);
            $this->get_rechnung_table_positionen_teppichreinigung($positionen, $optionen);
        } else{
            $this->get_rechnung_table_header_standard($optionen);
            $this->get_rechnung_table_positionen_standard($positionen, $optionen);
        }
    }

    public function get_rechnung_table_header_standard($optionen) {
    ?>
        <tr class="heading">
            <th>Leistung/Artikel</th>
            <th>Beschreibung</th>
            <th>Menge</th>
            <th>E-Preis</th>
            <th>G-Preis</th>
            <?php if($optionen == true) echo '<th>Optionen</th>'; ?>
        </tr>
    <?php 
    }

    public function get_rechnung_table_header_lackierer_kfz($optionen = false) {
    ?>
         <tr class="heading">
            <th>Leistung</th>
            <th>Fahrzeug</th>
            <th>Kennzeichen</th>
            <th>Menge</th>
            <th>Leistungs<br>datum</th>
            <th>E-Preis</th>
            <th>G-Preis</th>
            <?php if($optionen == true) echo '<th>Optionen</th>'; ?>
        </tr>
    <?php 
    }

    public function get_rechnung_table_header_teppichreinigung($optionen = false) {
        ?>
             <tr class="heading">
                <th>Leistung</th>
                <th>Menge</th>
                <th>Maße</th>
                <th>Leistungs<br>datum</th>
                <th>E-Preis</th>
                <th>G-Preis</th>
                <?php if($optionen == true) echo '<th>Optionen</th>'; ?>
            </tr>
        <?php 
        }

    public function get_rechnung_table_positionen_standard($positionen, $optionen = false) 
    {
        global $c_rechnung_position;
        foreach($positionen AS $position) {
        ?>
            <tr>
                <td>
                    <?php echo $position['artikel_name']; ?>
                </td>
                <td>
                    <?php echo $this->helper->replace_rn_with_br($position['artikel_beschreibung']); ?>
                </td>
                <td>
                    <?php echo $position['artikel_menge']; ?>
                    <?php echo $position['artikel_einheit']; ?>
                </td>
                
                <td>
                    <?php 
                        echo $this->html->waehrung($position['artikel_preis']); 
                        echo $this->helper->string_neue_zeilen($c_rechnung_position->get_abrechnungszeitraum_beschreibung($position), 30);
                    ?>
                </td>
                <td>
                    <?php echo $this->html->waehrung($position['gesamt_preis']); ?>
                </td>
                <?php if($optionen == true) $this->get_rechnung_table_position_bearbeiten_td($position); ?>
            </tr>
        <?php 
        }
    }

    public function get_rechnung_table_positionen_lackierer_kfz($positionen, $optionen = false) 
    {
        global $c_rechnung_position;
        foreach($positionen AS $position) { ?>
            <tr>
                <td>
                    <?php echo $position['artikel_name']; ?>
                    <?php 
                        if($position['artikel_beschreibung'] != '') {
                            echo $this->helper->string_neue_zeilen($this->helper->replace_rn_with_br($position['artikel_beschreibung']), 30); 
                        }
                    ?>
                </td>
                <td>
                    <?php echo $position['fahrzeug_marke']; ?><br>
                    <?php echo $position['fahrzeug_modell']; ?>
                </td>
                <td>
                    <?php echo $position['fahrzeug_kennzeichen']; ?><br>
                    <?php echo $position['fahrzeug_fin']; ?>
                </td>
                <td>
                    <?php echo $position['artikel_menge']; ?>
                    <?php echo $position['artikel_einheit']; ?>
                </td>
                <td>
                    <?php echo $c_rechnung_position->get_abrechnungszeitraum_beschreibung($position); ?>
                </td>
                <td>
                    <?php echo $this->html->waehrung($position['artikel_preis']); ?>
                </td>
                <td>
                    <?php echo $this->html->waehrung($position['gesamt_preis']); ?>
                </td>
                <?php if($optionen == true) $this->get_rechnung_table_position_bearbeiten_td($position); ?>
            </tr>
        <?php 
        } 
    }

    public function get_rechnung_table_positionen_teppichreinigung($positionen, $optionen = false) 
    {
        global $c_rechnung_position;
        foreach($positionen AS $position) { ?>
            <tr>
                <td>
                    <?php echo $position['artikel_name']; ?>
                    <?php 
                        if($position['artikel_beschreibung'] != '') {
                            echo $this->helper->string_neue_zeilen($this->helper->replace_rn_with_br($position['artikel_beschreibung']), 30); 
                        }
                    ?>
                </td>
                <td>
                    <?php echo $position['artikel_menge']; ?>
                    <?php echo $position['artikel_einheit']; ?>
                </td>
                <td>
                    <span class="table-data-small">
                        (
                            Länge: <?php echo $this->helper->get_qm($position['teppichreinigung_laenge']); ?> /
                            Breite: <?php echo $this->helper->get_qm($position['teppichreinigung_breite']); ?> 
                        )
                    </span>
                    <br>
                    <?php echo $this->helper->get_qm($position['teppichreinigung_laenge'] * $position['teppichreinigung_breite']); ?>
                </td>
                <td>
                    <?php echo $c_rechnung_position->get_abrechnungszeitraum_beschreibung($position); ?>
                </td>
                <td>
                    <?php echo $this->html->waehrung($position['artikel_preis']); ?>
                </td>
                <td>
                    <?php echo $this->html->waehrung($position['gesamt_preis']); ?>
                </td>
                <?php if($optionen == true) $this->get_rechnung_table_position_bearbeiten_td($position); ?>
            </tr>
        <?php 
        } 
    }

    public function get_rechnung_table_position_bearbeiten_td($position) {
    ?>
        <td>
            <div class="button-row">
                <?php 
                    $this->button->button_rechnung_position_bearbeiten(
                        $position['rechnung_position_id']
                    );
                    $this->button->button_rechnung_position_loeschen(
                        $position['rechnung_position_id']
                    );
                ?>
            </div>
        </td>
    <?php 
    }

    public function get_angebot_table_position_bearbeiten_td($position) {
    ?>
        <td>
            <div class="button-row">
                <?php 
                    $this->button->button_angebot_position_bearbeiten(
                        $position['angebot_position_id']
                    );
                    $this->button->button_angebot_position_loeschen(
                        $position['angebot_position_id']
                    );
                ?>
            </div>
        </td>
    <?php 
    }

    public function get_angebot_table_positionen($positionen, $optionen = false) 
    {
       
        if(isset($this->aktive_module['lackierer_kfz'])) {
            $this->get_angebot_table_header_lackierer_kfz($optionen);
            $this->get_angebot_table_positionen_lackierer_kfz($positionen, $optionen);
        } else if(isset($this->aktive_module['teppichreinigung'])) {
            $this->get_angebot_table_header_teppichreinigung($optionen);
            $this->get_angebot_table_positionen_teppichreinigung($positionen, $optionen);
        } else {
            $this->get_angebot_table_header_standard($optionen);
            $this->get_angebot_table_positionen_standard($positionen, $optionen);
        }
    }

    public function get_angebot_table_header_lackierer_kfz($optionen = false) {
    ?>
        <tr class="heading">
            <th>Leistung</th>
            <th>Fahrzeug</th>
            <th>Kennzeichen</th>
            <th>Menge</th>
            <th>E-Preis</th>
            <th>G-Preis</th>
            <?php if($optionen == true) echo '<th>Optionen</th>'; ?>
        </tr>
    <?php 
    }

    public function get_angebot_table_header_standard($optionen = false) 
    {
    ?>
        <tr class="heading">
            <th>Leistung/Artikel</th>
            <th>Angebotsdetails</th>
            <th>Menge</th>
            <?php if($this->einstellungen['angebot_pdf_position_laufende_kosten_ausblenden'] == '0'){ ?>
                <th>Laufende<br>Kosten</th>
            <?php }?>
            <th>Einmalige<br>Kosten</th>
            <?php if($optionen == true) echo '<th>Optionen</th>'; ?>
        </tr>
    <?php 
    }

    public function get_angebot_table_header_teppichreinigung($optionen = false) 
    {
    ?>
        <tr class="heading">
            <th>Leistung/Artikel</th>
            <th>Menge</th>
            <th>Maße</th>
            <?php if($this->einstellungen['artikel_einrichtungsgebuehr_ausblenden'] == '0'){ ?>
                <th>Einmalige<br>Kosten</th>
            <?php }?>
            <th>Einzel-Preis</th>
            <th>Gesamt-Preis</th>
            <?php if($optionen == true) echo '<th>Optionen</th>'; ?>
        </tr>
    <?php 
    }

    public function get_angebot_table_positionen_teppichreinigung($positionen, $optionen = false) 
    {
        foreach($positionen AS $position) { ?>
            <tr class="item">
                <td>
                    <?php echo $position['artikel_name']; ?>
                    <?php 
                        if($position['artikel_beschreibung'] != '') {
                            echo $this->helper->string_neue_zeilen($this->helper->replace_rn_with_br($position['artikel_beschreibung']), 30); 
                        }
                    ?>
                </td>
                <td>
                    <?php echo $position['menge']; ?>
                    <?php echo $position['einheit_bezeichnung']; ?>
                </td>
                <td>
                    Länge: <?php echo $position['teppichreinigung_laenge']; ?><br>
                    Breite: <?php echo $position['teppichreinigung_breite']; ?>
                </td>
                <?php if($this->einstellungen['artikel_einrichtungsgebuehr_ausblenden'] == '0'){ ?>
                    <?php echo $this->html->waehrung($position['einrichtungsgebuehr']); ?>
                <?php }?>
                <td>
                    <?php echo $this->html->waehrung($position['netto_preis']); ?>
                </td>
                <td>
                    <?php echo $this->html->waehrung($position['gesamt_netto']); ?>
                </td>
                <?php if($optionen == true) $this->get_angebot_table_position_bearbeiten_td($position); ?>
            </tr>
        <?php 
        } 
    }


    public function get_angebot_table_positionen_lackierer_kfz($positionen, $optionen = false) 
    {
        foreach($positionen AS $position) { ?>
            <tr class="item">
                <td>
                    <?php echo $position['artikel_name']; ?>
                    <?php 
                        if($position['artikel_beschreibung'] != '') {
                            echo $this->helper->string_neue_zeilen($this->helper->replace_rn_with_br($position['artikel_beschreibung']), 30); 
                        }
                    ?>
                </td>
                <td>
                    <?php echo $position['fahrzeug_marke']; ?><br>
                    <?php echo $position['fahrzeug_modell']; ?>
                </td>
                <td>
                    <?php echo $position['fahrzeug_kennzeichen']; ?><br>
                    <?php echo $position['fahrzeug_fin']; ?>
                </td>
                <td>
                    <?php echo $position['menge']; ?>
                    <?php echo $position['einheit_bezeichnung']; ?>
                </td>
                <td>
                    <?php echo $this->html->waehrung($position['netto_preis']); ?>
                </td>
                <td>
                    <?php echo $this->html->waehrung($position['gesamt_netto']); ?>
                </td>
                <?php if($optionen == true) $this->get_angebot_table_position_bearbeiten_td($position); ?>
            </tr>
        <?php 
        } 
    }


   
    

    public function get_angebot_table_positionen_standard($positionen, $optionen = false) 
    {
        global $c_rechnung_position;
        foreach($positionen AS $position) {
        ?>
            <tr>
                <td>
                    <?php echo $position['artikel_name']; ?>
                </td>
                <td>
                    <?php echo $this->helper->replace_rn_with_br($position['beschreibung']); ?>
                </td>
                <td>
                    <?php echo $position['menge']; ?>
                    <?php echo $position['einheit_bezeichnung']; ?>
                </td>
                <?php if($this->einstellungen['angebot_pdf_position_laufende_kosten_ausblenden'] == '0'){ ?>
                    <td>
                        <?php echo $this->html->waehrung($position['netto_preis']); ?><br>
                        <small><?php echo $position['zyklus_bezeichnung']; ?></small>
                    </td>
                <?php }?>
                <td>
                    <?php echo $this->html->waehrung($position['einrichtungsgebuehr']); ?>
                </td>
                <?php if($optionen == true) $this->get_angebot_table_position_bearbeiten_td($position); ?>
            </tr>
        <?php 
        }
    }

    public function get_table_kunden($kunden)
    {
        global $c_kunde;
        ob_start();
        foreach($kunden AS $buff) { 
    ?>
        <tr data-id="<?php echo $buff['kunde_id']; ?>" data-status="<?php echo $buff['status']; ?>">
            <td>
                <?php echo $this->get_kunde_logo($buff); ?>
            </td>
            <td>
                <?php echo $this->helper->string_neue_zeilen($buff['firmen_name'], 30); ?><br>
                <span class="table-data-small">Suchname: <?php echo $buff['suchname']; ?></span>
            </td>
            <td>
                <?php echo $buff['telefon']; ?><br>
                <?php echo $buff['email']; ?><br> 
                <?php if($buff['webseite'] != '') { ?> 
                    <a href="<?php echo $buff['webseite']; ?>" class="a_link" target="_blank">Webseite</a>	
                <?php } ?>
            </td>
            <td>
                <?php echo $buff['strasse']; ?><br>
                <?php echo $buff['plz']; ?>
                <?php echo $buff['ort']; ?>
            </td>
            <td>
                <?php echo $buff['mwst_bezeichnung']; ?>
            </td>
            <td>
                <?php $this->form->status_edit($buff['status'], $buff['kunde_id'], $c_kunde->get_tablename()); ?>
            </td>
            <td class="text-right"> 
                <div class="actions">
                    <?php 
                        echo $this->form->edit(
                            $buff['kunde_id'], 
                            'edit_kunde', 
                            $this->url->get_kunde_bearbeiten($buff['kunde_id'])
                        ); 
                    ?>
                </div>
            </td>
        </tr>
    <?php 
        }
        $html = ob_get_clean();
        return $html;
    }

}

