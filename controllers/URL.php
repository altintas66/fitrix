<?php 

class URL {

    private $config;

    public function __construct($config) 
    {
        $this->config = $config;
    }

    public function get_base_url() {
        return $this->config['httpsurl'];
    }
    
    public function get_login() {
        return $this->get_base_url().'login.php';
    }

    //Allgemein

    public function get_passwort_vergessen() {
        return $this->get_base_url().'passwort-vergessen.php';
    }

    public function get_einstellungen() {
        return $this->get_base_url().'einstellungen.php';
    }

    public function get_benachrichtigungen() {
        return $this->get_base_url().'benachrichtigungen.php';
    }

    public function get_profil() {
        return $this->get_base_url().'profil.php';
    }

    public function get_error_page() {
        return $this->get_base_url().'error.php';
    }

    
    //User

    public function get_user_uebersicht() {
        return $this->get_base_url().'user.php'; 
    }

    public function get_user_anlegen() {
        return $this->get_base_url().'user-anlegen.php'; 
    }

    public function get_user_bearbeiten($id) {
        return $this->get_base_url().'user-bearbeiten.php?id='.$id; 
    }
    

    // Kunden

    public function get_kunde_uebersicht() {
        return $this->get_base_url().'kunden.php'; 
    }

    public function get_kunde_anlegen() {
        return $this->get_base_url().'kunde-anlegen.php'; 
    }

    public function get_kunde_bearbeiten($id) {
        return $this->get_base_url().'kunde-bearbeiten.php?id='.$id; 
    }

    // Rechnungen

    public function get_rechnung_uebersicht() {
        return $this->get_base_url().'rechnungen.php'; 
    }

    public function get_quality_hosting_rechnung_anlegen() {
        return $this->get_base_url().'qualityhosting-rechnung-anlegen.php'; 
    }

    public function get_rechnung_bearbeiten($id) {
        return $this->get_base_url().'rechnung-bearbeiten.php?id='.$id; 
    }

    public function get_rechnung_vorschau($dateiname) {
        return $this->config['rechnungen_pfad_url'].$dateiname;
    }

    // Angebote

    public function get_angebot_uebersicht() {
        return $this->get_base_url().'angebote.php'; 
    }

    public function get_angebot_anlegen() {
        return $this->get_base_url().'angebot-anlegen.php'; 
    }

    public function get_angebot_bearbeiten($id) {
        return $this->get_base_url().'angebot-bearbeiten.php?id='.$id; 
    }

    public function get_angebot_vorschau($dateiname) {
        return $this->config['angebote_pfad_url'].$dateiname; 
    }

    // Abonnement

    public function get_abonnement_uebersicht() {
        return $this->get_base_url().'abonnements.php'; 
    }

    public function get_abonnement_anlegen() {
        return $this->get_base_url().'abonnement-anlegen.php'; 
    }

    public function get_abonnement_bearbeiten($id) {
        return $this->get_base_url().'abonnement-bearbeiten.php?id='.$id; 
    }

    public function get_abonnement_vorschau($dateiname) {
        //return $this->get_base_url().'abonnement-vorschau.php?id='.$id; 
        return $this->config['abonnements_pfad_url'].$dateiname;
    }    

    // Artikel

    public function get_artikel_uebersicht() {
        return $this->get_base_url().'artikel.php'; 
    }

    public function get_artikel_anlegen() {
        return $this->get_base_url().'artikel-anlegen.php'; 
    }

    public function get_artikel_bearbeiten($id) {
        return $this->get_base_url().'artikel-bearbeiten.php?id='.$id; 
    }

    // Kategorie

    public function get_kategorie_uebersicht() {
        return $this->get_base_url().'kategorien.php'; 
    }

    public function get_kategorie_anlegen() {
        return $this->get_base_url().'kategorie-anlegen.php'; 
    }

    public function get_kategorie_bearbeiten($id) {
        return $this->get_base_url().'kategorie-bearbeiten.php?id='.$id; 
    }

    // Einheiten

    public function get_einheit_uebersicht() {
        return $this->get_base_url().'einheiten.php'; 
    }

    public function get_einheit_anlegen() {
        return $this->get_base_url().'einheit-anlegen.php'; 
    }

    public function get_einheit_bearbeiten($id) {
        return $this->get_base_url().'einheit-bearbeiten.php?id='.$id; 
    }
    

    // Orte

    public function get_ort_uebersicht() {
        return $this->get_base_url().'orte.php'; 
    }

    public function get_ort_anlegen() {
        return $this->get_base_url().'ort-anlegen.php'; 
    }

    public function get_ort_bearbeiten($id) {
        return $this->get_base_url().'ort-bearbeiten.php?id='.$id; 
    }

    // Artikel Typen

    public function get_artikel_typ_uebersicht() {
        return $this->get_base_url().'artikel-typen.php'; 
    }

    public function get_artikel_typ_anlegen() {
        return $this->get_base_url().'artikel-typ-anlegen.php'; 
    }

    public function get_artikel_typ_bearbeiten($id) {
        return $this->get_base_url().'artikel-typ-bearbeiten.php?id='.$id; 
    }

    // Zyklen

    public function get_zyklus_uebersicht() {
        return $this->get_base_url().'zyklen.php'; 
    }

    public function get_zyklus_anlegen() {
        return $this->get_base_url().'zyklus-anlegen.php'; 
    }

    public function get_zyklus_bearbeiten($id) {
        return $this->get_base_url().'zyklus-bearbeiten.php?id='.$id; 
    }

    // MwST

    public function get_mwst_uebersicht() {
        return $this->get_base_url().'mwsts.php'; 
    }

    public function get_mwst_anlegen() {
        return $this->get_base_url().'mwst-anlegen.php'; 
    }

    public function get_mwst_bearbeiten($id) {
        return $this->get_base_url().'mwst-bearbeiten.php?id='.$id; 
    }

    // Permission

    public function get_permission_uebersicht()
    {
        return $this->get_base_url().'permissions.php'; 
    }

    // E-Mail Inhalt
    
    public function get_email_inhalt_uebersicht()
    {
        return $this->get_base_url().'email-inhalte.php'; 
    }


    //Cache

    public function get_cache_uebersicht() {
        return $this->get_base_url().'cache.php'; 
    }

    
    // Ansprechpartner

    public function get_ansprechpartner_bearbeiten($id) {
        return $this->get_base_url().'ansprechpartner-bearbeiten.php?id='.$id; 
    }

    // Zahlungsart

    public function get_zahlungsart_uebersicht() {
        return $this->get_base_url().'zahlungsarten.php'; 
    }

    public function get_zahlungsart_anlegen() {
        return $this->get_base_url().'zahlungsart-anlegen.php'; 
    }

    public function get_zahlungsart_bearbeiten($id) {
        return $this->get_base_url().'zahlungsart-bearbeiten.php?id='.$id; 
    }

    // Zammad 

    public function get_zammad_ticket_uebersicht() {
        return $this->get_base_url().'zammad-tickets.php'; 
    }

    public function get_zammad_organisation_uebersicht() {
        return $this->get_base_url().'zammad-organisationen.php'; 
    }

    public function get_zammad_kunden_uebersicht() {
        return $this->get_base_url().'zammad-kunden.php'; 
    }

    public function get_zammad_benutzer_uebersicht() {
        return $this->get_base_url().'zammad-benutzer.php'; 
    }

    // Cronjob

    public function get_cronjob_uebersicht() {
        return $this->get_base_url().'cronjobs.php'; 
    }

    public function get_cronjob_abo_rechnungen_erstellen() {
        return $this->get_base_url().'cronjob/cronjob-abonnements.php'; 
    }

    // Berichte
    
    public function get_berichte_uebersicht() {
        return $this->get_base_url().'berichte.php'; 
    }

    // Statistik
    
    public function get_statistik_uebersicht() {
        return $this->get_base_url().'statistik.php'; 
    }

    // E-Mail Log
    
    public function get_email_log_uebersicht() {
        return $this->get_base_url().'email-logs.php'; 
    }

    // Erinnerungen
    
    public function get_erinnerung_uebersicht() {
        return $this->get_base_url().'erinnerungen.php'; 
    }
    
    // Mahnung
    
    public function get_mahnung_uebersicht() {
        return $this->get_base_url().'mahnungen.php'; 
    }

    public function get_mahnung_anlegen() {
        return $this->get_base_url().'mahnung-anlegen.php'; 
    }

    public function get_mahnung_bearbeiten($id) {
        return $this->get_base_url().'mahnung-bearbeiten.php?id='.$id; 
    }

    // Server
    
    public function get_server_uebersicht() {
        return $this->get_base_url().'server.php'; 
    }

    public function get_server_anlegen() {
        return $this->get_base_url().'server-anlegen.php'; 
    }

    public function get_server_bearbeiten($id) {
        return $this->get_base_url().'server-bearbeiten.php?id='.$id; 
    }

    // Hosting
    
    public function get_hosting_uebersicht() {
        return $this->get_base_url().'hostings.php'; 
    }

    public function get_hosting_anlegen() {
        return $this->get_base_url().'hosting-anlegen.php'; 
    }

    public function get_hosting_bearbeiten($id) {
        return $this->get_base_url().'hosting-bearbeiten.php?id='.$id; 
    }

    // Modul

    public function get_modul_uebersicht() {
        return $this->get_base_url().'module.php'; 
    }

    

}