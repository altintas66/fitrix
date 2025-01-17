## Installationsschritte

Folgende Dateien anlegen:

* Unter config/config-custom.php anlegen (Als Vorlage config-custom-vorlage.php verwenden)
* Unter config/db.php anlegen (Als Vorlage db-vorlage.php verwenden)

Folgende Order anlegen und 777 Rechte vergeben

* /backup/
* /cache/
* /pdf/
   * /pdf/abonnements/
   * /pdf/angebote/
   * /pdf/mahnungen/
   * /pdf/rechnungen
* /upload/
* /xml/
   * /xml/rechnungen/


In der Datenbank die erforderlichen Module unter "modul" aktivieren
In der Datenbank die Einstellungen vornehmen unter "einstellungen"


Bei Bedarf Cronjob anlegen und in der Datenbank folgende aktivieren:

* abonnements
* erinnerungen
* abonnements
* zahlungserinnerungen