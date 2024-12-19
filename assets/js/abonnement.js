
/*============================
 [Table of JS]


	1.  Abonnement anlegen
	2.  Abonnement Vertrag anlegen
	3.  Abonnement Vertrag individuelle Position anlegen
	4.  Abonnement an Kunde senden
	5.  Abonnement Vertrag bearbeiten
	6.  Abonnement Vertrag löschen
	7.  Abonnement Vertrag Info
    8.  Abonnement anlegen Artikel Change


========================================*/




/*-----------------
	1. Abonnement anlegen
-----------------------*/

    $('.js_abonnement_anlegen').click(function() {
        $('#modal_abonnement_anlegen').modal('show');
    });


    $('#js_modal_abonnement_anlegen_submit').click(function() {
        var modal = '#modal_abonnement_anlegen';
        //Validierung
        var required_fields = [
            modal +' #kunde_id'
        ];
        
        var valid = check_required_fields(required_fields);

        if(valid == false) {
            fehlermeldung('Bitte alle Pflichtfelder eingeben');
            return;
        }

        ajax_abonnement_anlegen({
            'kunde_id' : $(required_fields[0]).val()
        })

    }); 

    function ajax_abonnement_anlegen(fields) {
        
        Locker.lock(true);
            
        var data = {
            action          : "insert_abonnement",
            kunde_id        : fields.kunde_id
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
	2. Abonnement Vertrag anlegen
-----------------------*/

    $('.js_abonnement_vertrag_anlegen').click(function() { 
        $('#modal_abonnement_vertrag_anlegen').modal('show');
    });

    $('#js_modal_abonnement_vertrag_anlegen_submit').click(function() { 
        
        var praefix = '#mava_';

        var required_fields = [
            praefix+'artikel_id',
            praefix+'artikel_menge',
            praefix+'start',
            praefix+'zyklus_id'

        ];

        var valid = check_required_fields(required_fields);

        if(valid == false) {
            fehlermeldung('Bitte alle Pflichtfelder eingeben');
            return;
        }

        ajax_abonnement_vertrag_anlegen({
            'artikel_id'            : $(required_fields[0]).val(),
            'artikel_menge'         : $(required_fields[1]).val(),
            'start'                 : $(required_fields[2]).val(),
            'ende'                  : $(praefix+'ende').val(),
            'zahlungsart_id'        : $(praefix+'zahlungsart_id').val(),
            'zyklus_id'             : $(required_fields[3]).val()
        });


    });

    function ajax_abonnement_vertrag_anlegen(fields) {
        Locker.lock(true);

        var data = {
            action                : "insert_abonnement_vertrag_artikel",
            abonnement_id         : $('#abonnement_id').val(),
            artikel_id            : fields.artikel_id,
            artikel_menge         : fields.artikel_menge,
            start                 : fields.start,
            ende                  : fields.ende,
            zahlungsart_id        : fields.zahlungsart_id,
            zyklus_id             : fields.zyklus_id
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
    3. Abonnement Vertrag individuelle Position anlegen
-----------------------*/

    $('#js_modal_abonnement_individuelle_position').click(function() { 
        $('#modal_abonnement_vertrag_anlegen').modal('hide');
        $('#modal_abonnement_vertrag_individuelle_position_anlegen').modal('show');
    });

    $('#js_modal_abonnement_vertrag_individuelle_position_anlegen_submit').click(function() { 

        var praefix = '#mavipa_';

        //Validierung
        var required_fields = [
            praefix +'artikel_name',
            praefix +'artikel_menge',
            praefix +'artikel_preis',
            praefix +'zahlungsart_id',
            praefix +'einheit_id',
            praefix +'artikel_typ_id',
            praefix +'zyklus_id',
            praefix +'start',
            praefix +'artikel_beschreibung',
        ];
        
        

        var valid = check_required_fields(required_fields);

        if(valid == false) {
            fehlermeldung('Bitte alle Pflichtfelder eingeben');
            return;
        }

        var beschreibung = get_wysiwyg_value($(praefix+'artikel_beschreibung'));

        if(validate_wyiswyg(beschreibung) == false) {
            fehlermeldung('Bitte alle Pflichtfelder eingeben');
            return;
        }

        ajax_abonnement_vertrag_individuelle_position_anlegen({
            'artikel_name'           : $(required_fields[0]).val(),
            'artikel_menge'          : $(required_fields[1]).val(),
            'artikel_preis'          : $(required_fields[2]).val(),
            'zahlungsart_id'         : $(required_fields[3]).val(),
            'einheit_id'             : $(required_fields[4]).val(),
            'artikel_typ_id'         : $(required_fields[5]).val(),
            'zyklus_id'              : $(required_fields[6]).val(),
            'start'                  : $(required_fields[7]).val(),
            'ende'                   : $(praefix +'ende').val(),
            'artikel_beschreibung'   : beschreibung,
        });

    });

    function ajax_abonnement_vertrag_individuelle_position_anlegen(fields) {
        Locker.lock(true);
            
        var data = {
            action                : "insert_abonnement_vertrag_individuelle_position",
            abonnement_id         : $('#abonnement_id').val(),
            artikel_name          : fields.artikel_name,
            artikel_menge         : fields.artikel_menge,
            artikel_preis         : fields.artikel_preis,
            zahlungsart_id        : fields.zahlungsart_id,
            einheit_id            : fields.einheit_id,
            artikel_typ_id        : fields.artikel_typ_id,
            zyklus_id          	  : fields.zyklus_id,
            start       		  : fields.start,
            ende       		      : fields.ende,
            artikel_beschreibung  : fields.artikel_beschreibung
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
	4. Abonnement an Kunde senden
-----------------------*/

    $('.js_abonnement_kunde_senden').click(function() {
        if(confirm('Sicher?') == false) return;

        Locker.lock(true);
            
        var data = {
            action          : "abonnement_kunde_senden",
            abonnement_id   : $(this).attr('data-id')
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
    5. Abonnement Vertrag bearbeiten
-----------------------*/

    var abonnement_vertrag_bearbeiten_id;

    $('.js_abonnement_vertrag_bearbeiten').click(function() { 

        Locker.lock(true);
        abonnement_vertrag_bearbeiten_id = $(this).attr('data-id');

        var data = {
            action               : "get_abonnement_vertrag",
            abonnement_vertrag_id  : $(this).attr('data-id')
        };

        $.ajax({
            url: siteurl + "controllers/AJAX.php",
            type: "POST",
            data: data,
            success: function (success) {
                var obj = jQuery.parseJSON(success);
                if(obj.result != false) {
                    modal_abonnement_vertrag_bearbeiten(obj.result);
                }
                Locker.lock(false);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                fehlermeldung();
                Locker.lock(false);
            }
        });

    });


    function modal_abonnement_vertrag_bearbeiten(vertrag) { 
        var modal = $('#modal_abonnement_vertrag_bearbeiten');
        var praefix = '#mavb_';

        if(vertrag.ende == null) vertrag.ende = '';

        $(modal).find(praefix+'artikel_name').val(vertrag.artikel_name);
        $(modal).find(praefix+'artikel_beschreibung').val(vertrag.artikel_beschreibung);
        $(modal).find(praefix+'artikel_menge').val(vertrag.artikel_menge);
        set_select2_value(praefix + 'einheit_id', vertrag.fk_einheit_id);
        set_select2_value(praefix + 'artikel_typ_id', vertrag.fk_artikel_typ_id);
        set_select2_value(praefix + 'zahlungsart_id', vertrag.fk_zahlungsart_id);
        set_waehrung_value(praefix+'artikel_preis', vertrag.artikel_preis);
        set_select2_value(praefix + 'zyklus_id', vertrag.fk_zyklus_id);
        $(modal).find(praefix+'start').val(vertrag.start);
        $(modal).find(praefix+'ende').val(vertrag.ende);




        $('#modal_abonnement_vertrag_bearbeiten').modal('show');


    }


    $('#js_modal_abonnement_vertrag_bearbeiten_submit').click(function() { 
        var praefix = '#mavb_';

        var required_fields = [
            praefix+'artikel_name',
            praefix+'artikel_beschreibung',
            praefix+'artikel_menge',
            praefix+'einheit_id',
            praefix+'artikel_typ_id',
            praefix+'artikel_preis',
            praefix+'zyklus_id',
            praefix+'start',
            praefix+'zahlungsart_id'
        ];

        var valid = check_required_fields(required_fields);

        if(valid == false) {
            fehlermeldung('Bitte alle Pflichtfelder eingeben');
            return;
        } 

        ajax_abonnement_vertrag_bearbeiten({
            'abonnement_vertrag_id'        : abonnement_vertrag_bearbeiten_id,
            'artikel_name'                 : $(required_fields[0]).val(),
            'artikel_beschreibung'         : $(required_fields[1]).val(),
            'artikel_menge'                : $(required_fields[2]).val(),
            'einheit_id'                   : $(required_fields[3]).val(),
            'artikel_typ_id'               : $(required_fields[4]).val(),
            'artikel_preis'                : $(required_fields[5]).val(),
            'zyklus_id'                    : $(required_fields[6]).val(),
            'start'                        : $(required_fields[7]).val(),
            'ende'                         : $(praefix+'ende').val(),
            'zahlungsart_id'               : $(required_fields[8]).val()
        });

    });

    function ajax_abonnement_vertrag_bearbeiten(vertrag) {
        Locker.lock(true);
            
        var data = {
            action                         : "update_abonnement_vertrag",
            abonnement_id                  : $('#abonnement_id').val(),
            abonnement_vertrag_id          : abonnement_vertrag_bearbeiten_id,
            artikel_name                   : vertrag.artikel_name,
            artikel_beschreibung           : vertrag.artikel_beschreibung,
            artikel_menge                  : vertrag.artikel_menge,
            einheit_id         		       : vertrag.einheit_id,
            artikel_typ_id 	               : vertrag.artikel_typ_id,
            artikel_preis                  : vertrag.artikel_preis,
            zyklus_id	                   : vertrag.zyklus_id,
            start                          : vertrag.start,
            ende                           : vertrag.ende,
            zahlungsart_id                 : vertrag.zahlungsart_id
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
    6. Abonnement Vertrag löschen
-----------------------*/

    $('.js_abonnement_vertrag_loeschen').click(function() { 
        if(confirm('Sicher') == false) return;

        Locker.lock(true);
            
        var data = {
            action                 : "delete_abonnement_vertrag",
            abonnement_id          : $('#abonnement_id').val(),
            abonnement_vertrag_id  : $(this).attr('data-id')
        };

        $.ajax({
            url: siteurl + "controllers/AJAX.php",
            type: "POST",
            data: data,
            success: function (success) {
                var obj = jQuery.parseJSON(success);
                if(obj.result != false) {
                    location.reload();
                } else {
                    fehlermeldung(obj.message);
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
	7. Abonnement Vertrag Info
-----------------------*/

    $(document).ready(function(){
        if($('.js_abonnement_vertrag_info').length == 0) return;

        $('.js_abonnement_vertrag_info').click(function() { 

            var data = {
                action                 : 'get_abonnement_vertrag_info',
                abonnement_vertrag_id  : $(this).attr('data-id')
            };

            Locker.lock(true);
            $.ajax({
                url: siteurl + "controllers/AJAX.php",
                type: "POST",
                data: data,
                success: function (success) {
                    var obj = jQuery.parseJSON(success);
                    if (obj.result != null) {
                        $('#modal_abonnement_vertrag_info .modal-body .table tbody').html(obj.html);
                        $('#modal_abonnement_vertrag_info').modal('show');
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
	8. Abonnement / Artikel / Rechnung anlegen Artikel Change
-----------------------*/

    $(document).ready(function() { 
        
        if(
            ($('#modal_abonnement_vertrag_anlegen').length == 0) &&
            ($('#modal_rechnung_position_hinzufuegen').length == 0) &&
            ($('#modal_angebot_position_hinzufuegen').length == 0)
        ) {
            return;
        }

        function get_artikel_zyklen(artikel_id) {
            
            var data = {
                action              : 'get_artikel_zyklen',
                artikel_id          : artikel_id
            };

            Locker.lock(true);
            
            $.ajax({
                url: siteurl + "controllers/AJAX.php",
                type: "POST",
                data: data,
                success: function (success) {
                    var obj = jQuery.parseJSON(success);
                    set_artikel_zyklen_options(obj);
                    Locker.lock(false);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    fehlermeldung();
                    Locker.lock(false);
                }
            });
        }

        function set_artikel_zyklen_options(obj) {
            if($('#mava_zyklus_id').length > 0) select2_reset_options('#mava_zyklus_id', obj.select_values);
            else if($('#mrph_zyklus_id').length > 0) select2_reset_options('#mrph_zyklus_id', obj.select_values);
            else if($('#maph_zyklus_id').length > 0) select2_reset_options('#maph_zyklus_id', obj.select_values);
        }

        $('#mava_artikel_id, #mrph_artikel_id, #maph_artikel_id').change(function() { 
            get_artikel_zyklen($(this).val());
        });

    });