<?php 
    include dirname(__FILE__).'/../init.php';

    $cronjobs = $c_cronjob->get_cronjob_jobs();

    if(in_array('abonnements', $cronjobs)) include dirname(__FILE__).'/cronjob-abonnements.php'; 
    if(in_array('erinnerungen', $cronjobs)) include dirname(__FILE__).'/cronjob-erinnerungen.php'; 
    if(in_array('mahnungen', $cronjobs)) include dirname(__FILE__).'/cronjob-mahnungen.php'; 
    if(in_array('zahlungserinnerungen', $cronjobs)) include dirname(__FILE__).'/cronjob-zahlungserinnerungen.php'; 