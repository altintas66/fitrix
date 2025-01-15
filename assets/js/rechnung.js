/*
	Author       : INOYA
*/

/*============================
 [Table of JS]

    1.  Rechnung anlegen
	2.  Rechnung bearbeiten
	3.  Rechnung Position bearbeiten
	4.  Rechnung Position löschen
	5.  Rechnung Korrektur
	6.  Rechnung festschreiben
	7.  Rechnung stornieren
	8.  Rechnung Zahlung hinzufügen
	9.  Rechnung Zahlung löschen
	10. Rechnung an Kunden senden
	11. Rechnung Zahlungserinnerung zeigen
	12. Rechnung drucken
	13. Rechnung Vorschau PDF generieren


========================================*/

	
/*-----------------
	1. Rechnung anlegen
-----------------------*/

    $(document).ready(function() { 
        if($('.js_rechnung_anlegen').length == 0) return;


        $('.js_rechnung_anlegen').click(function() { 

            var data = {
                action  : "get_rechnungsnummer"
            };

            $.ajax({
                url: siteurl + "controllers/AJAX.php",
                type: "POST",
                data: data,
                success: function (success) {
                    var obj = jQuery.parseJSON(success);
                    $('#modal_rechnung_anlegen #rechnungsnummer').val(obj.rechnungsnummer);
                    $('#modal_rechnung_anlegen').modal('show');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error('Fehler, bitte Administrator kontaktieren');
                }
            });

            
        });

        $('.js_modal_rechnung_anlegen_submit').click(function() { 
            $('#modal_rechnung_anlegen').modal('show');
        });

        $('#js_modal_rechnung_anlegen_submit').click(function() { 

            var required_fields = [
                '#kunde_id',
                '#rechnungsdatum',
                '#faellig_am'
            ];

            var modal = '#modal_rechnung_anlegen';

            var valid = true;

            $(required_fields).each(function(index, id) {
                if($(modal).find(id).val() == '') valid = false;
            });

            if(valid == false) {
                fehlermeldung('Bitte alle Pflichtfelder eingeben');
                return;
            }

            ajax_rechnung_anlegen({
                'kunde_id'        : $(modal).find(required_fields[0]).val(),
                'rechnungsdatum'  : $(modal).find(required_fields[1]).val(),
                'faellig_am'      : $(modal).find(required_fields[2]).val()
            });


        });

        function ajax_rechnung_anlegen(fields) {
            
            Locker.lock(true);
            
            var data = {
                action          : "insert_rechnung",
                kunde_id        : fields.kunde_id,
                rechnungsdatum  : fields.rechnungsdatum,
                faellig_am      : fields.faellig_am
            };

            $.ajax({
                url: siteurl + "controllers/AJAX.php",
                type: "POST",
                data: data,
                success: function (success) {
                    var obj = jQuery.parseJSON(success);
                    if(obj.result != false) {
                        location.reload();
                    }
                    Locker.lock(false);
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    fehlermeldung();
                    Locker.lock(false);
                }
            });
        }

        

    });



/*-----------------
	2. Rechnung bearbeiten
-----------------------*/

    $('.js_rechnung_position_hinzufuegen').click(function() { 
        $('#modal_rechnung_position_hinzufuegen').modal('show');
    });

    $('#js_modal_rechnung_position_individuelle_position').click(function() { 
        $('#modal_rechnung_position_hinzufuegen').modal('hide');
        $('#modal_rechnung_individuelle_position_hinzufuegen').modal('show');
    });

    $('#js_modal_rechnung_position_anlegen_submit').click(function() { 

        var praefix = '#mrph_'

        var required_fields = [
            praefix + 'artikel_id',
            praefix + 'menge',
            praefix + 'zyklus_id',
            praefix + 'leistungsdatum'
        ];

        var valid = check_required_fields(required_fields);

        if(valid == false) {
            fehlermeldung('Bitte alle Pflichtfelder eingeben');
            return;
        }

        ajax_rechnung_position_artikel_anlegen({
            'artikel_id'               : $(required_fields[0]).val(),
            'menge'                    : $(required_fields[1]).val(),
            'zyklus_id'                : $(required_fields[2]).val(),
            'leistungsdatum'           : $(required_fields[3]).val(),
            'fahrzeug_marke'           : $(praefix + 'fahrzeug_marke').val(),
            'fahrzeug_modell'          : $(praefix + 'fahrzeug_modell').val(),
            'fahrzeug_kennzeichen'     : $(praefix + 'fahrzeug_kennzeichen').val(),
            'fahrzeug_fin'             : $(praefix + 'fahrzeug_fin').val(),
            'teppichreinigung_laenge'  : $(praefix + 'teppichreinigung_laenge').val(),
            'teppichreinigung_breite'  : $(praefix + 'teppichreinigung_breite').val()
        });

    });

    function ajax_rechnung_position_artikel_anlegen(fields) {
        Locker.lock(true);

        var data = {
            action                   : "insert_rechnung_artikel_position",
            rechnung_id              : $('#rechnung_id').val(),
            artikel_id               : fields.artikel_id,
            menge                    : fields.menge,
            zyklus_id                : fields.zyklus_id,
            leistungsdatum           : fields.leistungsdatum,
            fahrzeug_marke           : fields.fahrzeug_marke,
            fahrzeug_modell          : fields.fahrzeug_modell,
            fahrzeug_kennzeichen     : fields.fahrzeug_kennzeichen,
            fahrzeug_fin             : fields.fahrzeug_fin,
            teppichreinigung_laenge  : fields.teppichreinigung_laenge,
            teppichreinigung_breite  : fields.teppichreinigung_breite
        };

        $.ajax({
            url: siteurl + "controllers/AJAX.php",
            type: "POST",
            data: data,
            success: function (success) {
                var obj = jQuery.parseJSON(success);
                if(obj.result != false) {
                    location.reload();
                }
                Locker.lock(false);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                fehlermeldung();
                Locker.lock(false);
            }
        });
    }

    $('#js_modal_rechnung_individuelle_position_anlegen_submit').click(function() { 

        var praefix = '#mriph_';

        //Validierung
        var required_fields = [
            praefix +'artikel_name',
            praefix +'einheit_id',
            praefix +'artikel_menge',
            praefix +'artikel_typ_id',
            praefix +'zyklus_id',
            praefix +'artikel_preis',
            praefix +'artikel_beschreibung',
            praefix +'abrechnungszeitrum_von',
            praefix +'abrechnungszeitrum_bis'
        ];
        
        

        var valid = check_required_fields(required_fields);

        if(valid == false) {
            fehlermeldung('Bitte alle Pflichtfelder eingeben');
            return;
        }

        //var artikel_beschreibung = get_wysiwyg_value($(praefix+'artikel_beschreibung'));

        // if(validate_wyiswyg(artikel_beschreibung) == false) {
        //     fehlermeldung('Bitte alle Pflichtfelder eingeben');
        //     return;
        // }

        ajax_rechnung_individuelle_position_anlegen({
            'artikel_name'             : $(required_fields[0]).val(),
            'einheit_id'               : $(required_fields[1]).val(),
            'artikel_menge'            : $(required_fields[2]).val(),
            'artikel_typ_id'           : $(required_fields[3]).val(),
            'zyklus_id'                : $(required_fields[4]).val(),
            'artikel_preis'            : $(required_fields[5]).val(),
            'artikel_beschreibung'     : $(required_fields[6]).val(),
            'abrechnungszeitrum_von'   : $(praefix + 'abrechnungszeitrum_von').val(),
            'abrechnungszeitrum_bis'   : $(praefix + 'abrechnungszeitrum_bis').val(),
            'leistungsdatum'           : $(praefix + 'leistungsdatum').val(),
            'fahrzeug_marke'           : $(praefix + 'fahrzeug_marke').val(),
            'fahrzeug_modell'          : $(praefix + 'fahrzeug_modell').val(),
            'fahrzeug_kennzeichen'     : $(praefix + 'fahrzeug_kennzeichen').val(),
            'fahrzeug_fin'             : $(praefix + 'fahrzeug_fin').val(),
            'teppichreinigung_laenge'  : $(praefix + 'teppichreinigung_laenge').val(),
            'teppichreinigung_breite'  : $(praefix + 'teppichreinigung_breite').val(),
        });

    });

    function ajax_rechnung_individuelle_position_anlegen(fields) {
        Locker.lock(true);
            
        var data = {
            action              		: "insert_rechnung_individuelle_position",
            rechnung_id          		: $('#rechnung_id').val(),
            artikel_name        		: fields.artikel_name,
            einheit_id          		: fields.einheit_id,
            artikel_menge       		: fields.artikel_menge,
            artikel_typ_id      		: fields.artikel_typ_id,
            zyklus_id           		: fields.zyklus_id,
            artikel_preis       		: fields.artikel_preis,
            artikel_beschreibung        : fields.artikel_beschreibung,
            abrechnungszeitrum_von      : fields.abrechnungszeitrum_von,
            abrechnungszeitrum_bis      : fields.abrechnungszeitrum_bis,
            leistungsdatum              : fields.leistungsdatum,
            fahrzeug_marke              : fields.fahrzeug_marke,
            fahrzeug_modell             : fields.fahrzeug_modell,
            fahrzeug_kennzeichen        : fields.fahrzeug_kennzeichen,
            fahrzeug_fin                : fields.fahrzeug_fin,
            teppichreinigung_laenge     : fields.teppichreinigung_laenge,
            teppichreinigung_breite     : fields.teppichreinigung_breite
        };

        $.ajax({
            url: siteurl + "controllers/AJAX.php",
            type: "POST",
            data: data,
            success: function (success) {
                var obj = jQuery.parseJSON(success);
                if(obj.result != false) {
                    location.reload();
                }
                Locker.lock(false);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                fehlermeldung();
                Locker.lock(false);
            }
        });
    }




/*-----------------
	3. Rechnung Position bearbeiten
-----------------------*/

    var rechnung_position_bearbeiten_id;

    $('.js_rechnung_position_bearbeiten').click(function() { 

        Locker.lock(true);
            
        var data = {
            action               : "get_rechnung_position",
            rechnung_position_id  : $(this).attr('data-id')
        };

        $.ajax({
            url: siteurl + "controllers/AJAX.php",
            type: "POST",
            data: data,
            success: function (success) {
                var obj = jQuery.parseJSON(success);
                if(obj.result != false) {
                    modal_rechnung_position_bearbeiten(obj.result);
                }
                Locker.lock(false);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                fehlermeldung();
                Locker.lock(false);
            }
        });

    });


    function modal_rechnung_position_bearbeiten(position) {
        var modal = $('#modal_rechnung_position_bearbeiten');
        var praefix = '#mrpb_';


        $(modal).find(praefix+'artikel_name').val(position.artikel_name);
        $(modal).find(praefix+'artikel_menge').val(position.artikel_menge);
        set_waehrung_value(praefix+'artikel_preis', position.artikel_preis);
        $(modal).find(praefix+'beschreibung').val(position.artikel_beschreibung);
        $(modal).find(praefix+'artikel_artikel_typ').val(position.artikel_artikel_typ);
        $(modal).find(praefix+'artikel_einheit').val(position.artikel_einheit);
        $(modal).find(praefix+'artikel_zyklus').val(position.artikel_zyklus);

        fill_optionale_felder(modal, praefix, position);


        $('#modal_rechnung_position_bearbeiten').modal('show');
        rechnung_position_bearbeiten_id = position.rechnung_position_id;

    }


    $('#js_modal_rechnung_position_bearbeiten_submit').click(function() { 
        var praefix = '#mrpb_';

        var required_fields = [
            praefix+'artikel_name',
            praefix+'artikel_menge',
            praefix+'artikel_preis',
            praefix+'beschreibung',
            praefix+'artikel_artikel_typ',
            praefix+'artikel_einheit',
            praefix+'artikel_zyklus'
        ];

        var valid = check_required_fields(required_fields);

        if(valid == false) {
            fehlermeldung('Bitte alle Pflichtfelder eingeben');
            return;
        }

        ajax_rechnung_position_bearbeiten({
            'rechnung_position_id'     : rechnung_position_bearbeiten_id,
            'artikel_name'             : $(required_fields[0]).val(),
            'artikel_menge'            : $(required_fields[1]).val(),
            'artikel_preis'            : $(required_fields[2]).val(),
            'beschreibung'             : $(required_fields[3]).val(),
            'artikel_artikel_typ'      : $(required_fields[4]).val(),
            'artikel_einheit'          : $(required_fields[5]).val(),
            'artikel_zyklus'           : $(required_fields[6]).val(),
            'artikel_zyklus'           : $(required_fields[6]).val(),
            'leistungsdatum'           : $(praefix + 'leistungsdatum').val(),
            'abrechnungszeitrum_von'   : $(praefix + 'abrechnungszeitrum_von').val(),
            'abrechnungszeitrum_bis'   : $(praefix + 'abrechnungszeitrum_bis').val(),
            'fahrzeug_marke'           : $(praefix + 'fahrzeug_marke').val(),
            'fahrzeug_modell'          : $(praefix + 'fahrzeug_modell').val(),
            'fahrzeug_kennzeichen'     : $(praefix + 'fahrzeug_kennzeichen').val(),
            'fahrzeug_fin'             : $(praefix + 'fahrzeug_fin').val(),
            'teppichreinigung_laenge'  : $(praefix + 'teppichreinigung_laenge').val(),
            'teppichreinigung_breite'  : $(praefix + 'teppichreinigung_breite').val(),
        });

        

    });

    function ajax_rechnung_position_bearbeiten(position) {
        Locker.lock(true);
        var data = {
            action                   : "update_rechnung_position",
            rechnung_id              : $('#rechnung_id').val(),
            rechnung_position_id     : rechnung_position_bearbeiten_id,
            artikel_name             : position.artikel_name,
            artikel_menge            : position.artikel_menge,
            artikel_preis            : position.artikel_preis,
            beschreibung             : position.beschreibung,
            artikel_artikel_typ      : position.artikel_artikel_typ,
            artikel_einheit          : position.artikel_einheit,
            artikel_zyklus           : position.artikel_zyklus,
            leistungsdatum           : position.leistungsdatum,
            abrechnungszeitrum_von   : position.abrechnungszeitrum_von,
            abrechnungszeitrum_bis   : position.abrechnungszeitrum_bis,
            fahrzeug_marke           : position.fahrzeug_marke,
            fahrzeug_modell          : position.fahrzeug_modell,
            fahrzeug_kennzeichen     : position.fahrzeug_kennzeichen,
            fahrzeug_fin             : position.fahrzeug_fin,
            teppichreinigung_laenge  : position.teppichreinigung_laenge,
            teppichreinigung_breite  : position.teppichreinigung_breite
        };
        $.ajax({
            url: siteurl + "controllers/AJAX.php",
            type: "POST",
            data: data,
            success: function (success) {
                var obj = jQuery.parseJSON(success);
                if(obj.result != false) {
                    location.reload();
                }
                Locker.lock(false);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                fehlermeldung();
                Locker.lock(false);
            }
        });
    }



/*-----------------
    4. Rechnung Position löschen
-----------------------*/

    var rechnung_position_loeschen_id;

    $('.js_rechnung_position_loeschen').click(function() { 
        rechnung_position_loeschen_id = $(this).attr('data-id');
        if(confirm('Sicher?') == false) return;

        ajax_rechnung_position_loeschen(rechnung_position_loeschen_id);
    });

    function ajax_rechnung_position_loeschen(id) {
        
        Locker.lock(true);
            
        var data = {
            action                : "delete_rechnung_position",
            rechnung_id           : $('#rechnung_id').val(),
            rechnung_position_id  : id
        };

        $.ajax({
            url: siteurl + "controllers/AJAX.php",
            type: "POST",
            data: data,
            success: function (success) {
                var obj = jQuery.parseJSON(success);
                if(obj.result != false) {
                    location.reload();
                }
                Locker.lock(false);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                fehlermeldung();
                Locker.lock(false);
            }
        });
    }




/*-----------------
	5. Rechnung Korrektur
-----------------------*/

    $(document).ready(function() {

        if($('.js_rechnung_korrektur').length == 0) return;

        $('.js_rechnung_korrektur').click(function() { 
            var message = 'Sicher?'
            if(confirm(message) == false) return;

            Locker.lock(true);

            var data = {
                action             : 'rechnung_korrektur',
                rechnung_id        : $(this).attr('data-id')
            };

            $.ajax({
                url: siteurl + "controllers/AJAX.php",
                type: "POST",
                data: data,
                success: function (success) {
                    var obj = jQuery.parseJSON(success);
                    if(obj.result != false) {
                        location.reload();
                    }
                    Locker.lock(false);
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    fehlermeldung();
                    Locker.lock(false);
                }
            });


        });

    });


/*-----------------
    6. Rechnung Festschreiben
-----------------------*/	

    $(document).ready(function() {

        if($('.js_rechnung_festschreiben').length == 0) return;

        $('.js_rechnung_festschreiben').click(function() { 
            var message = 'Sicher?'
            if(confirm(message) == false) return;

            Locker.lock(true);

            var data = {
                action             : 'rechnung_festschreiben',
                rechnung_id        : $(this).attr('data-id')
            };

            $.ajax({
                url: siteurl + "controllers/AJAX.php",
                type: "POST",
                data: data,
                success: function (success) {
                    var obj = jQuery.parseJSON(success);
                    if(obj.result != false) {
                        location.reload();
                    }
                    Locker.lock(false);
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    fehlermeldung();
                    Locker.lock(false);
                }
            });


        });

    });




/*-----------------
    7. Rechnung stornieren
-----------------------*/	

    $(document).ready(function() {

        if($('.js_rechnung_stornieren').length == 0) return;

        $('.js_rechnung_stornieren').click(function() { 
            var message = 'Sicher?'
            if(confirm(message) == false) return;

            Locker.lock(true);

            var data = {
                action             : 'rechnung_stornieren',
                rechnung_id        : $(this).attr('data-id')
            };

            $.ajax({
                url: siteurl + "controllers/AJAX.php",
                type: "POST",
                data: data,
                success: function (success) {
                    var obj = jQuery.parseJSON(success);
                    if(obj.result != false) {
                        location.reload();
                    }
                    Locker.lock(false);
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    fehlermeldung();
                    Locker.lock(false);
                }
            });


        });

    });


/*-----------------
    8. Rechnung Zahlung hinzufügen
-----------------------*/	

    $(document).ready(function() {

        if($('.js_rechnung_zahlung_hinzufuegen').length == 0) return;

        $('.js_rechnung_zahlung_hinzufuegen').click(function() { 
            var data = {
                action          : "get_rechnung_gesamt_brutto",
                rechnung_id     : $('#rechnung_id').val()
            };

            $.ajax({
                url: siteurl + "controllers/AJAX.php",
                type: "POST",
                data: data,
                success: function (success) {
                    var obj = jQuery.parseJSON(success);
                    set_waehrung_value('#mrzh_zahlungsbetrag', obj.gesamt_brutto);
                    $('#modal_rechnung_zahlung_hinzufuegen').modal('show');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error('Fehler, bitte Administrator kontaktieren');
                }
            });
        });


        $('#js_modal_rechnung_zahlung_hinzufuegen_submit').click(function() { 

            var praefix = '#mrzh_';

            var required_fields = [
                praefix+'zahlungsart_id',
                praefix+'zahlungsbetrag',
                praefix+'zahlungsdatum'
            ];

            var valid = check_required_fields(required_fields);

            if(valid == false) {
                fehlermeldung('Bitte alle Pflichtfelder eingeben');
                return;
            }

            ajax_rechnung_zahlung_hinzufuegen({
                'zahlungsart_id' : $(required_fields[0]).val(),
                'zahlungsbetrag' : $(required_fields[1]).val(),
                'zahlungsdatum'  : $(required_fields[2]).val()
            })

        });

        function ajax_rechnung_zahlung_hinzufuegen(fields) {
            
            var data = {
                action             : 'rechnung_zahlung_hinzufuegen',
                rechnung_id        : $('#rechnung_id').val(),
                zahlungsart_id     : fields.zahlungsart_id,
                zahlungsbetrag     : fields.zahlungsbetrag,
                zahlungsdatum      : fields.zahlungsdatum
            };

            $.ajax({
                url: siteurl + "controllers/AJAX.php",
                type: "POST",
                data: data,
                success: function (success) {
                    var obj = jQuery.parseJSON(success);
                    if(obj.result != false) {
                        location.reload();
                    }
                    Locker.lock(false);
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    fehlermeldung();
                    Locker.lock(false);
                }
            });

        }

    });


/*-----------------
    9. Rechnung Zahlung löschen
-----------------------*/	

    $(document).ready(function() {

        if($('.js_rechnung_zahlung_loeschen').length == 0) return;

        $('.js_rechnung_zahlung_loeschen').click(function() { 
            if(confirm('Sicher?') == false) return;

            var data = {
                action              : 'rechnung_zahlung_loeschen',
                rechnung_id         : $('#rechnung_id').val(),
                rechnung_zahlung_id : $(this).attr('data-id')
            };

            $.ajax({
                url: siteurl + "controllers/AJAX.php",
                type: "POST",
                data: data,
                success: function (success) {
                    var obj = jQuery.parseJSON(success);
                    if(obj.result != false) {
                        location.reload();
                    }
                    Locker.lock(false);
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    fehlermeldung();
                    Locker.lock(false);
                }
            });


        });


    });




/*-----------------
	10. Rechnung an Kunde senden
-----------------------*/

    $('.js_rechnung_kunde_senden').click(function() {
        if(confirm('Sicher?') == false) return;

        Locker.lock(true);
            
        var data = {
            action          : "rechnung_kunde_senden",
            rechnung_id     : $(this).attr('data-id')
        };

        $.ajax({
            url: siteurl + "controllers/AJAX.php",
            type: "POST",
            data: data,
            success: function (success) {
                var obj = jQuery.parseJSON(success);
                if(obj.result == false) {
                    fehlermeldung(obj.message);
                } else if(obj.result == true) {
                    console.log(obj);
                    if(obj.smtp_response == 1) erfolgsmeldung('Email wurde gesendet');
                    else fehlermeldung();

                } else {
                    fehlermeldung();
                }
                Locker.lock(false);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                fehlermeldung();
                Locker.lock(false);
            }
        });

    });



/*-----------------
    11. Rechnung Zahlungserinnerung zeigen
-----------------------*/

    $(document).ready(function() { 
        if($('.js_rechnung_zahlungserinnerung_anzeigen').length == 0) return;

        $('.js_rechnung_zahlungserinnerung_anzeigen').click(function() { 
            Locker.lock(true);
            
            var data = {
                action          : "get_rechnung_zahlungserinnerung",
                rechnung_id     : $(this).attr('data-id')
            };

            $.ajax({
                url: siteurl + "controllers/AJAX.php",
                type: "POST",
                data: data,
                success: function (success) {
                    var obj = jQuery.parseJSON(success);
                    if(obj.result != null) {
                        $('.js_table_tbody_email_logs').html(obj.html);
                        $('#modal_email_logs').modal('show');
                    } else {
                        fehlermeldung();
                    }
                    Locker.lock(false);
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    fehlermeldung();
                    Locker.lock(false);
                }
            });
        });


    });


/*-----------------
    12. Rechnung drucken
-----------------------*/	

    $(document).ready(function() {

        if($('.js_rechnung_drucken').length == 0) return;

        $('.js_rechnung_drucken').click(function() { 

            var data = {
                action             : 'rechnung_gedruckt',
                rechnung_id        : $(this).attr('data-id')
            };

            $.ajax({
                url: siteurl + "controllers/AJAX.php",
                type: "POST",
                data: data,
                success: function (success) {
                    var obj = jQuery.parseJSON(success);
                    if(obj.result == false) {
                        Locker.lock(false);
                    }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    fehlermeldung();
                    Locker.lock(false);
                }
            });

            


        });


    });
    

/*-----------------
    13. Rechnung Vorschau PDF generieren
-----------------------*/	

    $('.js_button_vorschau').click(function(){

        var data = {
            action             : 'rechnung_vorschau_pdf_generieren',
            rechnung_id        : $('#rechnung_id').val()
        };

        $.ajax({
            url: siteurl + "controllers/AJAX.php",
            type: "POST",
            data: data,
            success: function (success) {
                var obj = jQuery.parseJSON(success);
                if(obj.result != false) {
                    var url = 'https://fitrix.inoya.cloud/pdf/rechnungen/' + obj.result.dateiname;
                    window.open(url, '_blank');
                }
                Locker.lock(false);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                fehlermeldung();
                Locker.lock(false);
            }
        });

    });