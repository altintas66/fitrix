<?php 

class Table_Helper {

    private $helper;
    private $button;
    private $html;
    private $form;

    public function __construct($helper, $button, $html, $form) 
    {
        $this->helper = $helper;
        $this->button = $button;
        $this->html   = $html;
        $this->form   = $form;
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

    public function get_td_kunde($buff) 
    {
        global $c_url;
        return '<a class="a_link" href="'.$c_url->get_kunde_bearbeiten($buff['kunde_id']).'">'.$buff['kunde_firmen_name'].'</a><br><span class="table-data-small">Suchname: '.$buff['kunde_suchname'].'</span>';
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

    

}

