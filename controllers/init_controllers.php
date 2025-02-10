<?php   

    $classes = array(
        'Abonnement_Vertrag_Rechnung_Position',
        'Abonnement_Vertrag_Rechnung',
        'Abonnement_Vertrag',
        'Abonnement',
        'Angebot_Position_Optionale_Felder',
        'Angebot',
        'Angebot_Position',
        'Ansprechpartner',
        'API',
        'Artikel_Kategorie',
        'Artikel',
        'Artikel_Preis',
        'Artikel_Typ',
        'Backup',
        'Beitrag',
        'Beitrag_User_Markierung',
        'Button',
        'Cache',
        'Cronjob',
        'Database',
        'Datei_Zuweisung',
        'Datei',
        'Einheit',
        'Einstellungen',
        'Email_Log',
        'Email',
        'Erinnerung',
        'File_Upload',
        'Form',
        'Helper',
        'Hosting',
        'HTML',
        'Inhalt',
        'Inhalt_Placeholder',
        'JSON_Helper',
        'Kategorie',
        'Kommentar',
        'Kunde',
        'Login',
        'Mahnung',
        'Modul',
        'Mwst',
        'Notification',
        'Notification_User',
        'Ort',
        'Parkwin',
        'PDF',
        'XML',
        'Permission',
        'Placeholder',
        'Plesk_API',
        'PLZ_Ort_Suche',
        'Quality_Hosting_CSV_Rechnung',
        'Rechnung_Position_Optionale_Felder',
        'Rechnung',
        'Rechnung_Position',
        'Rechnung_Qualityhosting',
        'Rechnung_Ticket',
        'Rechnung_Zahlung',
        'Rechnung_Zahlungserinnerung',
        'Rolle',
        'Server',
        'Statistik',
        'Table_Helper',
        'URL',
        'User',
        'Zahlungsart',
        'Zammad',
        'Zyklus'
    );
    
    foreach($classes AS $class) {
        include $class.'.php';
    }

    // Allgemein
    global 
        $einstellungen,
        $c_db,
        $c_url,
        $c_helper,
        $c_html,
        $c_cronjob,
        $c_mahnung,
        $c_inhalt,
        $c_inhalt_placeholder,
        $c_form,
        $c_erinnerung,
        $c_button,
        $c_table_helper,
        $c_json_helper,
        $c_email_log,
        $c_email,
        $c_file_upload,
        $c_einstellungen,
        $c_rolle,
        $c_user,
        $c_login,
        $c_permission,
        $c_kommentar,
        $c_beitrag,
        $c_xml,
        $c_pdf,
        $c_parkwin,
        $c_datei_zuweisung,
        $c_datei,
        $c_notification,
        $c_notification_user
    ;

    global 
        $c_einheit,
        $c_zahlungsart,
        $c_zyklus,
        $c_kategorie,
        $c_artikel_preis,
        $c_artikel_typ,
        $c_artikel,
        $c_ort,
        $c_mwst,
        $c_kunde,
        $c_ansprechpartner,
        $c_rechnung_position,
        $c_rechnung_qualityhosting,
        $c_rechnung_ticket,
        $c_rechnung_zahlung,
        $c_rechnung_zahlungserinnerung,
        $c_rechnung,
        $c_api,
        $c_artikel_kategorie,
        $c_angebot_position,
        $c_angebot,
        $c_abonnement_vertrag_rechnung_position,
        $c_abonnement_vertrag_rechnung,
        $c_abonnement_vertrag,
        $c_abonnement,
        $c_statistik,
        $c_zammad,
        $c_quality_hosting_csv_rechnung,
        $c_plesk_api,
        $c_server,
        $c_hosting,
        $c_modul,
        $module,
        $aktive_module,
        $c_backup,
        $c_rechnung_position_optionale_felder,
        $c_angebot_position_optionale_felder,
        $c_plz_ort_suche,
        $c_beitrag_user_markierung
    ;



    //Allgemeine Klassen
    $c_db                                    = new Database($link);
    $c_url                                   = new URL($config);
    $c_helper                                = new Helper($c_db);
    $c_modul                                 = new Modul($c_db, $c_helper);
    $module                                  = $c_modul->get_all();
    $aktive_module                           = $c_modul->get_aktive_module();
    $c_einstellungen                         = new Einstellungen($c_db);
    $einstellungen                           = $c_einstellungen->get_all();
    $c_cronjob                               = new Cronjob($c_db, $c_helper);
    $c_placeholder                           = new Placeholder($c_db, $c_helper, $einstellungen);
    $c_notification                          = new Notification($c_db, $c_helper, $c_url);
    $c_notification_user                     = new Notification_User($c_db, $c_helper);
    $c_erinnerung                            = new Erinnerung($c_db, $c_helper, $c_url);
    $c_inhalt                                = new Inhalt($c_db, $c_helper);
    $c_inhalt_placeholder                    = new Inhalt_Placeholder($c_db, $c_helper);
    $c_html                                  = new HTML($c_helper, $c_url);
    $c_form                                  = new Form($c_helper, $c_html, $einstellungen, $aktive_module);
    $c_button                                = new Button($c_url, $c_form);
    $c_table_helper                          = new Table_Helper($c_helper, $c_button, $c_html, $c_form, $c_url, $aktive_module, $einstellungen);
    $c_json_helper                           = new JSON_Helper();
    $c_email_log                             = new Email_Log($c_db, $c_helper);
    $c_email                                 = new Email($c_helper, $c_email_log);
    $c_file_upload                           = new File_Upload();
    $c_cache                                 = new Cache();
    
    $c_rolle                                 = new Rolle($c_db, $c_helper);
    $c_user                                  = new User($c_db, $c_helper, $c_inhalt, $c_placeholder, $einstellungen);
    $c_login                                 = new Login($c_helper, $c_url, $c_user);
    $c_permission                            = new Permission($c_db, $c_helper);
    $c_kommentar                             = new Kommentar($c_db, $c_helper, $c_user);
    $c_beitrag                               = new Beitrag($c_db, $c_helper);
    $c_beitrag_user_markierung               = new Beitrag_User_Markierung($c_db, $c_helper);
    $c_datei_zuweisung                       = new Datei_Zuweisung($c_db, $c_helper);
    $c_datei                                 = new Datei($c_db, $c_helper, $c_datei_zuweisung);
    $c_xml                                   = new XML($c_helper);
    $c_pdf                                   = new PDF($c_helper, $config);
    


    
    // Spezifische Klassen
    $c_einheit                               = new Einheit($c_db, $c_helper);
    $c_zahlungsart                           = new Zahlungsart($c_db, $c_helper);
    $c_zyklus                                = new Zyklus($c_db, $c_helper);
    $c_artikel_kategorie                     = new Artikel_Kategorie($c_db, $c_helper);
    $c_kategorie                             = new Kategorie($c_db, $c_helper);
    $c_artikel_preis                         = new Artikel_Preis($c_db, $c_helper);
    $c_artikel_typ                           = new Artikel_Typ($c_db, $c_helper);
    $c_artikel                               = new Artikel($c_db, $c_helper, $c_artikel_preis, $c_artikel_kategorie, $einstellungen);
    $c_ort                                   = new Ort($c_db, $c_helper);
    $c_api                                   = new API($c_helper, $c_email);
    $c_plz_ort_suche                         = new PLZ_Ort_Suche($c_db, $c_helper, $c_api, $c_ort);
    $c_mwst                                  = new Mwst($c_db, $c_helper, $c_artikel);
    $c_kunde                                 = new Kunde($c_db, $c_helper, $c_mwst, $einstellungen);
    $c_ansprechpartner                       = new Ansprechpartner($c_db, $c_helper, $c_kunde);
    $c_mahnung                               = new Mahnung($c_db, $c_helper, $c_email, $einstellungen);
    $c_rechnung_position_optionale_felder    = new Rechnung_Position_Optionale_Felder($c_db, $c_helper, $aktive_module);
    $c_rechnung_position                     = new Rechnung_Position($c_db, $c_helper, $c_artikel, $c_einheit, $c_zyklus, $c_artikel_typ, $c_artikel_preis, $c_rechnung_position_optionale_felder, $einstellungen, $aktive_module);
    $c_rechnung_qualityhosting               = new Rechnung_Qualityhosting($c_db, $c_helper);
    $c_rechnung_ticket                       = new Rechnung_Ticket($c_db, $c_helper);
    $c_rechnung_zahlung                      = new Rechnung_Zahlung($c_db, $c_helper, $c_zahlungsart);
    $c_rechnung_zahlungserinnerung           = new Rechnung_Zahlungserinnerung($c_db, $c_helper, $c_email);
    $c_rechnung                              = new Rechnung($c_db, $c_helper, $c_rechnung_position, $c_rechnung_zahlung, $c_kunde, $c_pdf, $c_mwst, $c_mahnung, $c_einstellungen);
    $c_parkwin                               = new Parkwin($c_helper);
    
    $c_angebot_position_optionale_felder     = new Angebot_Position_Optionale_Felder($c_db, $c_helper, $aktive_module);
    $c_angebot_position                      = new Angebot_Position($c_db, $c_helper, $c_artikel, $c_einheit, $c_artikel_typ, $c_artikel_preis, $c_zyklus, $c_angebot_position_optionale_felder, $aktive_module);
    $c_angebot                               = new Angebot($c_db, $c_helper, $c_kunde, $c_angebot_position, $c_pdf, $c_einstellungen);
    
    $c_statistik                             = new Statistik($c_helper, $c_rechnung, $c_rechnung_zahlung);
    $c_zammad                                = new Zammad($c_helper, $c_kunde, $config);
    
    $c_abonnement_vertrag_rechnung_position  = new Abonnement_Vertrag_Rechnung_Position($c_db, $c_helper);
    $c_abonnement_vertrag_rechnung           = new Abonnement_Vertrag_Rechnung($c_db, $c_helper, $c_abonnement_vertrag_rechnung_position);
    $c_abonnement_vertrag                    = new Abonnement_Vertrag($c_db, $c_helper, $c_artikel_preis);
    $c_abonnement                            = new Abonnement($c_db, $c_helper, $c_html, $c_kunde, $c_rechnung, $c_rechnung_position, $c_rechnung_ticket, $c_abonnement_vertrag, $c_abonnement_vertrag_rechnung, $c_einstellungen, $c_parkwin, $c_zammad, $c_api, $c_email, $c_url);
    $c_quality_hosting_csv_rechnung          = new Quality_Hosting_CSV_Rechnung($c_db, $c_helper, $c_kunde);
    $c_plesk_api                             = new Plesk_API();
    $c_hosting                               = new Hosting($c_db, $c_helper);
    $c_server                                = new Server($c_db, $c_helper, $c_hosting);
    $c_backup                                = new Backup($c_db, $c_helper);
