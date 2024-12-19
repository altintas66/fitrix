<?php 
    global $config;
    
    $config['site_title']             = 'FITRIX Rechnungssystem';
    $config['system_name']            = 'FITRIX';
    $config['stytem_label']           = 'FITRIX';	
    $config['angebote_pfad']          = dirname(__FILE__).'/../pdf/angebote/';
	$config['mahnungen_pfad']         = dirname(__FILE__).'/../pdf/mahnungen/';
	$config['rechnungen_pfad']        = dirname(__FILE__).'/../pdf/rechnungen/';
	$config['rechnungen_xml_pfad']    = dirname(__FILE__).'/../xml/rechnungen/';
	$config['abonnements_pfad']       = dirname(__FILE__).'/../pdf/abonnements/';

    include 'config-custom.php';

    $config['angebote_pfad_url']       = $config['httpsurl'].'pdf/angebote/';
    $config['mahnungen_pfad_url']      = $config['httpsurl'].'pdf/mahnungen/';
	$config['rechnungen_pfad_url']     = $config['httpsurl'].'pdf/rechnungen/';
    $config['rechnungen_xml_pfad_url'] = $config['httpsurl'].'xml/rechnungen/';
	$config['abonnements_pfad_url']    = $config['httpsurl'].'pdf/abonnements/';

   
