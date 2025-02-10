<?php 



    class Cronjob_Erinnerung {

        private $helper;
        private $angebot;
        private $erinnerung;
        private $einstellungen;
        private $notification;
        private $notification_user;
        private $user;

        private $heute;

        public function __construct($helper, $angebot, $erinnerung, $einstellungen, $notification, $notification_user, $user) 
        {

            $this->helper             = $helper;
            $this->angebot            = $angebot;
            $this->erinnerung         = $erinnerung;
            $this->einstellungen      = $einstellungen->get_all();
            $this->heute              = new DateTime(date('Y-m-d'));
            $this->notification       = $notification;
            $this->notification_user  = $notification_user;
            $this->user               = $user;

        }

        public function erinnerungen()
        {
    
            $erinnerungen = $this->erinnerung->get_all();

            foreach($erinnerungen AS $buff)
            {
                if($buff['datum'] != $this->heute) continue;
                $user = $this->user->get($buff['fk_user_id']);

                $notification = $this->notification->insert(array(
                    'eintrag_id' => $buff['erinnerung_id'],
                    'typ'        => 'erinnerung',
                    'text'       => $buff['text']
                ));

                $this->notification_user->insert(array(
                    'fk_user_id'            => $user['user_id'],
                    'fk_notification_id'    => $notification['id']
                ));

                $this->erinnerung->delete($buff['erinnerung_id']);
            }
        }
    }

    $cronjob_erinnerung = new Cronjob_Erinnerung(
        $c_helper,
        $c_angebot,
        $c_erinnerung,
        $c_einstellungen,
        $c_notification,
        $c_notification_user,
        $c_user
    );

    $cronjob_erinnerung->erinnerungen();