/*
	Author       : INOYA
*/

/*============================
 [Table of JS]


	1.  Angebot anlegen
	2.  Angebot Position anlegen 
	3.  Angebot Position bearbeiten
	4.  Angebot Position löschen
	5.  Angebot an Kunde senden

========================================*/


/*-----------------
	1. Angebot anlegen
-----------------------*/

$(document).ready(function() { 
    if($('.js_angebot_anlegen').length == 0) return;


    $('.js_angebot_anlegen').click(function() { 

        var data = {
            action         : "get_angebotsnummer"
        };

        $.ajax({
            url: siteurl + "controllers/AJAX.php",
            type: "POST",
            data: data,
            success: function (success) {
                var obj = jQuery.parseJSON(success);
                $('#modal_angebot_anlegen #angebotsnummer').val(obj.angebotsnummer);
                $('#modal_angebot_anlegen').modal('show');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                fehlermeldung();
            }
        });

        
    });

    $('.js_modal_angebot_anlegen_submit').click(function() { 
        $('#modal_angebot_anlegen').modal('show');
    });

    $('#js_modal_angebot_anlegen_submit').click(function() { 

        var required_fields = [
            '#kunde_id',
            '#angebotsdatum',
            '#faellig_am'
        ];

        var modal = '#modal_angebot_anlegen';

        var valid = true;

        $(required_fields).each(function(index, id) {
            if($(modal).find(id).val() == '') valid = false;
        });

        if(valid == false) {
            fehlermeldung('Bitte alle Pflichtfelder eingeben');
            return;
        }

        ajax_angebot_anlegen({
            'kunde_id'       : $(modal).find(required_fields[0]).val(),
            'angebotsdatum'  : $(modal).find(required_fields[1]).val(),
            'faellig_am'     : $(modal).find(required_fields[2]).val(),
        });


    });

    function ajax_angebot_anlegen(fields) {
        
        Locker.lock(true);
        
        var data = {
            action         : "insert_angebot",
            kunde_id       : fields.kunde_id,
            angebotsdatum  : fields.angebotsdatum,
            faellig_am     : fields.faellig_am
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
2. Angebot Position anlegen
-----------------------*/

$('.js_angebot_position_hinzufuegen').click(function() { 
    $('#modal_angebot_position_hinzufuegen').modal('show');
});

$('#js_modal_angebot_position_anlegen_submit').click(function() { 
    
    var praefix = '#maph_';

    var required_fields = [
        praefix + 'artikel_id',
        praefix + 'menge',
        praefix + 'zyklus_id'
    ];

    var valid = check_required_fields(required_fields);

    if(valid == false) {
        fehlermeldung('Bitte alle Pflichtfelder eingeben');
        return;
    }

    ajax_position_anlegen({ 
        'artikel_id'               : $(required_fields[0]).val(),
        'menge'                    : $(required_fields[1]).val(),
        'zyklus_id'                : $(required_fields[2]).val(),
        'fahrzeug_marke'           : $(praefix + 'fahrzeug_marke').val(),
        'fahrzeug_modell'          : $(praefix + 'fahrzeug_modell').val(),
        'fahrzeug_kennzeichen'     : $(praefix + 'fahrzeug_kennzeichen').val(),
        'fahrzeug_fin'             : $(praefix + 'fahrzeug_fin').val(),
        'teppichreinigung_laenge'  : $(praefix + 'teppichreinigung_laenge').val(),
        'teppichreinigung_breite'  : $(praefix + 'teppichreinigung_breite').val()
    });

});

function ajax_position_anlegen(fields) {
    Locker.lock(true);
        
    var data = {
        action                   : "insert_angebot_position",
        angebot_id               : $('#angebot_id').val(),
        artikel_id               : fields.artikel_id,
        menge                    : fields.menge,
        zyklus_id                : fields.zyklus_id,
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

$('#js_modal_angebot_position_individuelle_position').click(function() {
    $('#modal_angebot_position_hinzufuegen').modal('hide');
    $('#modal_angebot_individuelle_position_hinzufuegen').modal('show');
});

$('#js_modal_angebot_individuelle_position_anlegen_submit').click(function() { 

    var modal = '#modal_angebot_individuelle_position_hinzufuegen';
    var praefix = '#maiph_'

    //Validierung
    var required_fields = [
        praefix +'artikel_name',
        praefix +'einheit_id',
        praefix +'menge',
        praefix +'artikel_typ_id',
        praefix +'zyklus_id',
        praefix +'netto_preis',
        praefix +'beschreibung'
    ];
    
    

    var valid = check_required_fields(required_fields);

    if(valid == false) {
        fehlermeldung('Bitte alle Pflichtfelder eingeben');
        return;
    }

    ajax_angebot_individuelle_position_anlegen({
        'artikel_name'         : $(required_fields[0]).val(),
        'einheit_id'           : $(required_fields[1]).val(),
        'menge'                : $(required_fields[2]).val(),
        'artikel_typ_id'       : $(required_fields[3]).val(),
        'zyklus_id'            : $(required_fields[4]).val(),
        'einrichtungsgebuehr'  : $(praefix+'einrichtungsgebuehr').val(),
        'netto_preis'          : $(required_fields[5]).val(),
        'beschreibung'         : $(required_fields[6]).val()
    });

});


function ajax_angebot_individuelle_position_anlegen(fields) {
    Locker.lock(true);
        
    var data = {
        action              : "insert_angebot_individuelle_position",
        angebot_id          : $('#angebot_id').val(),
        artikel_name        : fields.artikel_name,
        einheit_id          : fields.einheit_id,
        menge               : fields.menge,
        artikel_typ_id      : fields.artikel_typ_id,
        zyklus_id           : fields.zyklus_id,
        einrichtungsgebuehr : fields.einrichtungsgebuehr,
        netto_preis         : fields.netto_preis,
        beschreibung        : fields.beschreibung
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
3. Angebot Position bearbeiten
-----------------------*/

var angebot_position_bearbeiten_id;

$('.js_angebot_position_bearbeiten').click(function() { 

    Locker.lock(true);
        
    var data = {
        action               : "get_angebot_position",
        angebot_position_id  : $(this).attr('data-id')
    };

    $.ajax({
        url: siteurl + "controllers/AJAX.php",
        type: "POST",
        data: data,
        success: function (success) {
            var obj = jQuery.parseJSON(success);
            if(obj.result != false) {
                modal_angebot_position_bearbeiten(obj.result);
            }
            Locker.lock(false);
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            fehlermeldung();
            Locker.lock(false);
        }
    });

});


function modal_angebot_position_bearbeiten(position) {
    var modal = $('#modal_angebot_position_bearbeiten');
    var praefix = '#mapb_';


    $(modal).find(praefix+'artikel_name').val(position.artikel_name);
    $(modal).find(praefix+'menge').val(position.menge);
    set_waehrung_value(praefix+'einrichtungsgebuehr', position.einrichtungsgebuehr);
    set_waehrung_value(praefix+'netto_preis', position.netto_preis);
    
    set_select2_value(praefix + 'einheit_id', position.fk_einheit_id);
    set_select2_value(praefix + 'zyklus_id', position.fk_zyklus_id);
    set_select2_value(praefix + 'artikel_typ_id', position.fk_artikel_typ_id);

    $(praefix+'beschreibung').val(position.beschreibung);

    fill_optionale_felder(modal, praefix, position);


    $('#modal_angebot_position_bearbeiten').modal('show');
    angebot_position_bearbeiten_id = position.angebot_position_id;

}


$('#js_modal_angebot_position_bearbeiten_submit').click(function() { 
    var modal = $('#modal_angebot_position_bearbeiten');
    var praefix = '#mapb_';

    var required_fields = [
        praefix+'artikel_name',
        praefix+'menge',
        praefix+'einrichtungsgebuehr',
        praefix+'netto_preis',
        praefix+'artikel_typ_id',
        praefix+'einheit_id',
        praefix+'zyklus_id'
    ];

    var valid = check_required_fields(required_fields);

    if(valid == false) {
        fehlermeldung('Bitte alle Pflichtfelder eingeben');
        return;
    }

    ajax_angebot_position_bearbeiten({
        'angebot_position_id'     : angebot_position_bearbeiten_id,
        'artikel_name'            : $(required_fields[0]).val(),
        'menge'                   : $(required_fields[1]).val(),
        'einrichtungsgebuehr'     : $(required_fields[2]).val(),
        'netto_preis'             : $(required_fields[3]).val(),
        'artikel_typ_id'          : $(required_fields[4]).val(),
        'einheit_id'              : $(required_fields[5]).val(),
        'zyklus_id'               : $(required_fields[6]).val(),
        'beschreibung'            : $(praefix+'beschreibung').val(),
        'fahrzeug_marke'          : $(praefix+'fahrzeug_marke').val(),
        'fahrzeug_modell'         : $(praefix+'fahrzeug_modell').val(),
        'fahrzeug_kennzeichen'    : $(praefix+'fahrzeug_kennzeichen').val(),
        'fahrzeug_fin'            : $(praefix+'fahrzeug_fin').val(),
        'teppichreinigung_laenge' : $(praefix+'teppichreinigung_laenge').val(),
        'teppichreinigung_breite' : $(praefix+'teppichreinigung_breite').val()

    });

});

function ajax_angebot_position_bearbeiten(position) {
    Locker.lock(true);
        
    var data = {
        action                  : "update_angebot_position",
        angebot_id              : $('#angebot_id').val(),
        angebot_position_id     : angebot_position_bearbeiten_id,
        artikel_name            : position.artikel_name,
        menge                   : position.menge,
        einrichtungsgebuehr     : position.einrichtungsgebuehr,
        netto_preis             : position.netto_preis,
        beschreibung            : position.beschreibung,
        artikel_typ_id          : position.artikel_typ_id,
        einheit_id              : position.einheit_id,
        zyklus_id               : position.zyklus_id,
        fahrzeug_marke          : position.fahrzeug_marke,
        fahrzeug_modell         : position.fahrzeug_modell,
        fahrzeug_kennzeichen    : position.fahrzeug_kennzeichen,
        fahrzeug_fin            : position.fahrzeug_fin,
        teppichreinigung_laenge : position.teppichreinigung_laenge,
        teppichreinigung_breite : position.teppichreinigung_breite
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
4. Angebot Position löschen
-----------------------*/

var angebot_position_loeschen_id;

$('.js_angebot_position_loeschen').click(function() { 
    angebot_position_loeschen_id = $(this).attr('data-id');
    if(confirm('Sicher?') == false) return;

    ajax_angebot_position_loeschen(angebot_position_loeschen_id);
});

function ajax_angebot_position_loeschen(id) {
    
    Locker.lock(true);
        
    var data = {
        action               : "delete_angebot_position",
        angebot_id           : $('#angebot_id').val(),
        angebot_position_id  : id
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
5. Angebot an Kunde senden
-----------------------*/

$('.js_angebot_kunde_senden').click(function() {
    if(confirm('Sicher?') == false) return;

    Locker.lock(true);
        
    var data = {
        action          : "angebot_kunde_senden",
        angebot_id      : $(this).attr('data-id')
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
