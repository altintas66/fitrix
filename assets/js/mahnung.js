/*
	Author       : INOYA
*/

/*============================
 [Table of JS]


	1.  Mahnungslauf starten

========================================*/



/*-----------------
	1. Mahnungslauf starten
-----------------------*/


$(document).ready(function() { 
    if($('.js_mahnlauf_starten').length == 0) return;


    $('.js_mahnlauf_starten').click(function() { 

         //Validierung
         var mahnungen = [];
       
 
         $('.js_table_mahnungen input[name="js_checkbox_mahnungen"]').each(function () {
             if ($(this).is(':checked')) {
                mahnungen.push($(this).attr('data-id'));
             } 
         });
 
 
         if (mahnungen.length == 0) {
             fehlermeldung('Bitte wähle mindestens eine Position aus');
             return;
         }

         if(confirm('Es werden '+mahnungen.length+' Mahnungen versendet. Sind Sie sich Sicher?') == false) return;
        var data = {
            action  : "mahnlauf_starten",
            mahnungen : mahnungen
        };

        $.ajax({
            url: siteurl + "controllers/AJAX.php",
            type: "POST",
            data: data,
            success: function (success) {
                var obj = jQuery.parseJSON(success);
                if(obj.result != false){
                    erfolgsmeldung('Mahnungen wurden erfolgreich erstellt');
                }else {
                    fehlermeldung();
                }
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.error('Fehler, bitte Administrator kontaktieren');
            }
        });

        
    });
});