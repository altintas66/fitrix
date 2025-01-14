<?php 

class Button {

    private $url;
    private $form;

    public function __construct($url, $form) {
        $this->url  = $url;
        $this->form = $form;
    }


    // User 

    public function button_user_uebersicht($title = 'User Übersicht') {
        $this->form->button_link(
            $this->url->get_user_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_user_anlegen() {
        $this->form->button_link(
            $this->url->get_user_anlegen(), 
            '<i class="fa fa-plus"></i> User anlegen', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }

    // Ort

    public function button_ort_uebersicht($title = 'Ort Übersicht') {
        $this->form->button_link(
            $this->url->get_ort_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_ort_anlegen() {
        $this->form->button_link(
            $this->url->get_ort_anlegen(), 
            '<i class="fa fa-plus"></i> Ort anlegen', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }

    // Artikel Typ

    public function button_artikel_typ_uebersicht($title = 'Artikel Typ Übersicht') {
        $this->form->button_link(
            $this->url->get_artikel_typ_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_artikel_typ_anlegen() {
        $this->form->button_link(
            $this->url->get_artikel_typ_anlegen(), 
            '<i class="fa fa-plus"></i> Artikel Typ anlegen', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }

    // Artikel Preis

    public function button_artikel_preis_anlegen() {
        $this->form->button(
            'btn_artikel_preis_anlegen', 
            '<i class="fa fa-plus"></i> Preis anlegen', 
            'btn btn-success btn-sm btn-icon js_artikel_preis_anlegen'
        ); 
    }

    // Kunde

    public function button_kunde_uebersicht($title = 'Kunden Übersicht') {
        $this->form->button_link(
            $this->url->get_kunde_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_kunde_anlegen() {
        $this->form->button_link(
            $this->url->get_kunde_anlegen(), 
            '<i class="fa fa-plus"></i> Kunde anlegen', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }

    // Artikel

    public function button_artikel_uebersicht($title = 'Artikel Übersicht') {
        $this->form->button_link(
            $this->url->get_artikel_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_artikel_anlegen() {
        $this->form->button_link(
            $this->url->get_artikel_anlegen(), 
            '<i class="fa fa-plus"></i> Artikel anlegen', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }

    // Kategorie

    public function button_kategorie_uebersicht($title = 'Kategorie Übersicht') {
        $this->form->button_link(
            $this->url->get_kategorie_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_kategorie_anlegen() {
        $this->form->button_link(
            $this->url->get_kategorie_anlegen(), 
            '<i class="fa fa-plus"></i> Kategorie anlegen', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }

    // Angebot

    public function button_angebot_uebersicht($title = 'Angebot Übersicht') {
        $this->form->button_link(
            $this->url->get_angebot_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_angebot_anlegen() {
        $this->form->button(
            'btn_angebot_anlegen', 
            '<i class="fa fa-plus"></i> Angebot anlegen', 
            'btn btn-success btn-sm btn-icon js_angebot_anlegen'
        ); 
    }

    public function button_angebot_bearbeiten()
    {
        $this->form->button_link(
            '#angebot-bearbeiten',
            '<i class="fa fa-edit"></i> Angebot bearbeiten', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }

    public function button_angebot_position_hinzufuegen()
    {
        $this->form->button(
            'btn_angebot_position_hinzufuegen', 
            '<i class="fa fa-plus"></i> Position hinzufügen', 
            'btn btn-green btn-sm btn-icon js_angebot_position_hinzufuegen'
        ); 
    }

    public function button_angebot_vorschau($angebot)
    {
        $this->form->button_link(
            $this->url->get_angebot_vorschau($angebot['dateiname']), 
            'Vorschau', 
            'btn btn-blue btn-sm btn-icon',
            true,
            '_blank'
        ); 
    }

    public function button_angebot_kunden_senden($id)
    {
        $this->form->button(
            'btn_angebot_kunde_senden', 
            '<i class="fa fa-envelope"></i> an Kunden senden', 
            'btn btn-danger btn-sm btn-icon js_angebot_kunde_senden',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    // Abonnement

    public function button_abonnement_uebersicht($title = 'Abonnement Übersicht') {
        $this->form->button_link(
            $this->url->get_abonnement_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_abonnement_anlegen() {
        $this->form->button(
            'btn_abonnement_anlegen', 
            '<i class="fa fa-plus"></i> Abonnement anlegen',  
             'btn btn-success btn-sm btn-icon js_abonnement_anlegen'
        ); 
    }

    public function button_abonnement_vorschau($abonnement)
    {
        $this->form->button_link(
            $this->url->get_abonnement_vorschau($abonnement['dateiname']), 
            'Vorschau', 
            'btn btn-blue btn-sm btn-icon',
            true,
            '_blank'
        ); 
    }
    
    public function button_abonnement_bearbeiten()
    {
        $this->form->button_link(
            '#abonnement-bearbeiten',
            '<i class="fa fa-edit"></i> Abonnement bearbeiten', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }

    public function button_abonnement_kunden_senden($id)
    {
        $this->form->button(
            'btn_abonnement_kunde_senden', 
            '<i class="fa fa-envelope"></i> an Kunden senden', 
            'btn btn-danger btn-sm btn-icon js_abonnement_kunde_senden',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    public function button_abonnement_rechnungen_erstellen($id)
    {
        $this->form->button(
            'btn_abonnement_rechnungen_erstellen', 
            '<i class="fa fa-refresh fa-spin"></i> Rechnungen erstellen', 
            'btn btn-secondary btn-sm btn-icon js_abonnement_rechnungen_erstellen',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    

    public function button_abonnement_vertrag_bearbeiten($id)
    {
        $this->form->button(
            'btn_abonnement_vertrag_bearbeiten_'.$id, 
            '<i class="fa fa-edit"></i>', 
            'btn btn-small btn-blue js_abonnement_vertrag_bearbeiten',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    public function button_abonnement_vertrag_loeschen($id)
    {
        $this->form->button(
            'btn_abonnement_vertrag_loeschen_'.$id, 
            '<i class="fa fa-trash"></i>', 
            'btn btn-small btn-danger js_abonnement_vertrag_loeschen',
            false,
            'data-id="'.$id.'"'
        ); 
    }    

    public function button_abonnement_vertrag_info($id)
    {
        $this->form->button(
            'btn_abonnement_vertrag_info_'.$id, 
            '<i class="fa fa-info-circle"></i>', 
            'btn btn-small btn-secondary js_abonnement_vertrag_info',
            false,
            'data-id="'.$id.'"'
        ); 
    }    

    
    

    // Angebot Position

    public function button_angebot_position_bearbeiten($id)
    {
        $this->form->button(
            'btn_angebot_position_bearbeiten_'.$id, 
            '<i class="fa fa-edit"></i>', 
            'btn btn-small btn-blue js_angebot_position_bearbeiten',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    public function button_angebot_position_loeschen($id)
    {
        $this->form->button(
            'btn_angebot_position_loeschen_'.$id, 
            '<i class="fa fa-trash"></i>', 
            'btn btn-small btn-danger js_angebot_position_loeschen',
            false,
            'data-id="'.$id.'"'
        ); 
    }


    

    // Rechnung

    public function button_rechnung_uebersicht($title = 'Rechnung Übersicht') {
        $this->form->button_link(
            $this->url->get_rechnung_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_rechnung_anlegen() {
        $this->form->button(
            'btn_rechnung_anlegen', 
            '<i class="fa fa-plus"></i> Rechnung anlegen', 
            'btn btn-success btn-sm btn-icon js_rechnung_anlegen'
        ); 
    }

    public function button_quality_hosting_rechnung_anlegen() {
        $this->form->button_link(
            $this->url->get_quality_hosting_rechnung_anlegen(),
            '<i class="fa fa-edit"></i> Qualityhosting Rechnung anlegen', 
            'btn btn-secondary btn-sm btn-icon'
        ); 
    }

    public function button_rechnung_bearbeiten()
    {
        $this->form->button_link(
            '#rechnung-bearbeiten',
            '<i class="fa fa-edit"></i> Rechnung bearbeiten', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }

    public function button_rechnung_position_hinzufuegen()
    {
        $this->form->button(
            'btn_rechnung_position_hinzufuegen', 
            '<i class="fa fa-plus"></i> Position hinzufügen', 
            'btn btn-green btn-sm btn-icon js_rechnung_position_hinzufuegen'
        ); 
    }

    public function button_rechnung_vorschau($rechnung)
    {
        $this->form->button(
            'btn_rechnung_vorschau', 
            'Vorschau', 
            'btn btn-blue btn-sm btn-icon js_button_vorschau',
            false
        ); 
    }

    public function button_rechnung_kunden_senden($id)
    {
        $this->form->button(
            'btn_rechnung_kunde_senden', 
            '<i class="fa fa-envelope"></i> an Kunden senden', 
            'btn btn-primary btn-sm btn-icon js_rechnung_kunde_senden',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    public function button_rechnung_korrektur($id)
    {
        $this->form->button(
            'btn_rechnung_korrektur', 
            'Korrektur', 
            'btn btn-danger btn-sm js_rechnung_korrektur',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    public function button_rechnung_festschreiben($id)
    {
        $this->form->button(
            'btn_rechnung_festschreiben', 
            '<i class="fa fa-check-square"></i> festschreiben', 
            'btn btn-green btn-sm btn-icon js_rechnung_festschreiben',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    public function button_rechnung_stornieren($id)
    {
        $this->form->button(
            'btn_rechnung_festschreiben', 
            '<i class="fa fa-times"></i> stornieren', 
            'btn btn-danger btn-sm btn-icon js_rechnung_stornieren',
            false,
            'data-id="'.$id.'"'
        ); 
    }
    
    public function button_rechnung_zahlung_hinzufuegen($id)
    {
        $this->form->button(
            'btn_rechnung_zahlung_hinzufuegen', 
            '<i class="fa fa-euro"></i> Zahlung hinzufügen', 
            'btn btn-green btn-sm btn-icon js_rechnung_zahlung_hinzufuegen',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    public function button_rechnung_zahlung_loeschen($id)
    {
        $this->form->button(
            'btn_rechnung_zahlung_loeschen_'.$id, 
            '<i class="fa fa-trash"></i>', 
            'btn btn-danger btn-sm js_rechnung_zahlung_loeschen',
            false,
            'data-id="'.$id.'"'
        ); 
    }
 
    public function button_rechnung_drucken($id)
    {
        $this->form->button(
            'btn_rechnung_drucken', 
            '<i class="fa fa-print"></i> Drucken', 
            'btn btn-primary btn-sm btn-icon js_rechnung_drucken',
            false,
            'onclick="printPDF()" data-id="'.$id.'"'
        ); 
    }
    
    
    // Rechnung Position

    public function button_rechnung_position_bearbeiten($id)
    {
        $this->form->button(
            'btn_rechnung_position_bearbeiten_'.$id, 
            '<i class="fa fa-edit"></i>', 
            'btn btn-small btn-blue js_rechnung_position_bearbeiten',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    public function button_rechnung_position_loeschen($id)
    {
        $this->form->button(
            'btn_rechnung_position_loeschen_'.$id, 
            '<i class="fa fa-trash"></i>', 
            'btn btn-small btn-danger js_rechnung_position_loeschen',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    

    // MwSt

    public function button_mwst_uebersicht($title = 'MwSt Übersicht') {
        $this->form->button_link(
            $this->url->get_mwst_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_mwst_anlegen() {
        $this->form->button_link(
            $this->url->get_mwst_anlegen(), 
            '<i class="fa fa-plus"></i> MwSt anlegen', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }


    // Zyklus

    public function button_zyklus_uebersicht($title = 'Zyklen Übersicht') {
        $this->form->button_link(
            $this->url->get_zyklus_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_zyklus_anlegen() {
        $this->form->button_link(
            $this->url->get_zyklus_anlegen(), 
            '<i class="fa fa-plus"></i> Zyklus anlegen', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }

   
    // Einheit

    public function button_einheit_uebersicht($title = 'Einheit Übersicht') {
        $this->form->button_link(
            $this->url->get_einheit_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_einheit_anlegen() {
        $this->form->button_link(
            $this->url->get_einheit_anlegen(), 
            '<i class="fa fa-plus"></i> Einheit anlegen', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }   

    // E-Mail Log

    public function button_email_logs_anzeigen() {
        $this->form->button(
            'email_logs_anzeigen', 
            '<i class="fa fa-envelope"></i> E-Mail Logs anzeigen', 
            'btn btn-success btn-sm btn-icon js_email_logs_anzeigen'
        ); 
    }

    // Abonnement Vertrag

    public function button_abonnement_vertrag_anlegen() {
        $this->form->button(
            'abonnement_vertrag_anlegen', 
            '<i class="fa fa-plus"></i> Vertrag anlegen', 
            'btn btn-success btn-sm btn-icon js_abonnement_vertrag_anlegen'
        ); 
    }

    // Ansprechpartner

    public function button_ansprechpartner_anlegen() {
        $this->form->button(
            'ansprechpartner_anlegen', 
            '<i class="fa fa-user"></i> Ansprechpartner anlegen', 
            'btn btn-blue btn-sm btn-icon js_ansprechpartner_anlegen'
        ); 
    }

    public function button_ansprechpartner_bearbeiten($id) {
        $this->form->button(
            'ansprechpartner_bearbeiten_'.$id, 
            '<i class="fa fa-edit"></i>', 
            'btn btn-primary btn-sm js_ansprechpartner_bearbeiten',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    // Zahlungsart

    public function button_zahlungsart_uebersicht($title = 'Zahlungsart Übersicht') {
        $this->form->button_link(
            $this->url->get_zahlungsart_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_zahlungsart_anlegen() {
        $this->form->button_link(
            $this->url->get_zahlungsart_anlegen(), 
            '<i class="fa fa-plus"></i> Zahlungsart anlegen', 
            'btn btn-success btn-sm btn-icon'
        ); 
    }   

    // Mahnung

    public function button_mahnung_uebersicht($title = 'Mahnungen Übersicht') {
        $this->form->button_link(
            $this->url->get_mahnung_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_mahnlauf_starten() {
        $this->form->button(
            'btn_mahnlauf_starten', 
            '<i class="fa fa-plus"></i> Mahnlauf starten', 
            'btn btn-success btn-sm btn-icon js_mahnlauf_starten'
        ); 
    }
    
    
    // Cronjob 

    public function cronjob_abo_rechnungen_erstellen() {
        $this->form->button_link(
            $this->url->get_cronjob_abo_rechnungen_erstellen(), 
            '<i class="fa fa-refresh fa-spin"></i> Abo Rechnungen erstellen', 
            'btn btn-green btn-sm btn-icon',
            true,
            '_blank'
        ); 
    }

    // Rechnung Zahlungserinnerung 

    public function button_rechnung_zahlungserinnerung_anzeigen($rechnung_id) {
        $this->form->button(
            'button_rechnung_zahlungserinnerung_anzeigen'.$id, 
            '<i class="fa fa-info-circle"></i> Zahlungserinnerung anzeigen', 
            'btn btn-danger btn-sm btn-icon js_rechnung_zahlungserinnerung_anzeigen',
            false,
            'data-id="'.$rechnung_id.'"'
        ); 
    }

    // Server

    public function button_server_uebersicht($title = 'Server Übersicht') {
        $this->form->button_link(
            $this->url->get_server_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_server_anlegen() {
        $this->form->button_link(
            $this->url->get_server_anlegen(), 
            '<i class="fa fa-plus"></i> Server anlegen', 
            'btn btn-success btn-sm btn-icon'
        );  
    }

    // Hosting

    public function button_hosting_uebersicht($title = 'Hosting Übersicht') {
        $this->form->button_link(
            $this->url->get_hosting_uebersicht(), 
            $title, 
            'btn btn-primary btn-sm btn-icon'
        ); 
    }

    public function button_hosting_anlegen() {
        $this->form->button_link(
            $this->url->get_hosting_anlegen(), 
            '<i class="fa fa-plus"></i> Hosting anlegen', 
            'btn btn-success btn-sm btn-icon'
        );  
    }

    // Backup

    public function button_backup_erstellen() {
        $this->form->button(
            'btn_backup_erstellen', 
            '<i class="fa fa-refresh fa-spin"></i> Backup erstellen', 
            'btn btn-success btn-sm btn-icon js_backup_erstellen'
        ); 
    }

    public function button_backup_loeschen($id)
    {
        $this->form->button(
            'btn_backup_loeschen_'.$id, 
            '<i class="fa fa-trash"></i>', 
            'btn btn-small btn-danger js_backup_loeschen',
            false,
            'data-id="'.$id.'"'
        ); 
    }

    

}