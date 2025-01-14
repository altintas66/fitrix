/*
	Author       : INOYA
*/

/*============================
 [Table of JS]

	1.  Allgemein
	2.  DIV Gleiche Höhe
	3.  Update Status
	4.  Menü einklappen
	5.  User anlegen
	6.  Permissions
	7.  Artikel anlegen
	8.  E-Mail Logs aufrufen
	9.  Ansprechpartner anlegen / bearbeiten
	10. Artikel bearbeiten
	11. Kunde bearbeiten / anlegen Zammad Organisations ID change
	12. Update Theme Mode
	13. Sortierungsfunktion
	14. Artikel Preis anlegen 
	15. Tabelle sortieren	
	16. Quality Hosting Rechnung anlegen
	17. Backup erstellen
	18. Backup löschen




========================================*/

/*-----------------
	1. Allgemein
-----------------------*/

	var siteurl = $('#config').attr('data-site-url');
	var action = '';

	function parse_date(input, format) {
		return moment(input, "YYYY-MM-DD HH:mm:ss").format("DD.MM.YYY HH:mm:ss")
	}

	function fehlermeldung(meldung = '') {
		if (meldung != '') meldung = meldung;
		else meldung = 'Fehler. Bitte Administrator kontaktieren!';
		toastr.error(meldung);
	}

	function erfolgsmeldung(meldung = '') {
		toastr.success(meldung);
	}

	function location_reload() {
		window.location = window.location.href.split("?")[0];
	}

	function german_date(datum, labeling = true) {
		if (datum == '') return '';
		var buff1 = moment(datum).format('DD.MM.YYYY');
		var buff2 = moment(datum).format('HH:mm:ss');
		var gestern = moment().subtract(1, 'day').format('DD.MM.YYYY');

		if (labeling) {
			if (buff1 == moment().format('DD.MM.YYYY')) buff1 = 'Heute';
			else if (buff1 == gestern) buff1 = 'Gestern';
		}

		var datumuhrzeit = buff1 + ' ' + buff2;
		return datumuhrzeit;
	}

	function alert_message(text,  z_class = '', class_name = 'success') {
		return '<div class="'+z_class+' alert alert-'+class_name+'">'+text+'</div>';
	}

	function check_required_fields(required_fields) {
		var valid = true;
		$(required_fields).each(function(index, id) {
			if($(id).attr('required') == 'required') {
				if($(id).val() == '') valid = false;
			}
		});

		return valid;
	}

/*-----------------
	2.  DIV Gleiche Höhe
-----------------------*/


	$(document).ready(function() {
		if ($('.same-height').length == 0) return;

		function same_height_columns() {
			$('.row').each(function () {
				var highestBox = 0;
				$('.same-height', this).each(function () {
					if ($(this).parent().height() > highestBox) {
						highestBox = $(this).height();
					}
				});
				$('.same-height', this).height(highestBox);
			});
		}

		$(document).ready(function () {
			same_height_columns();
		});

		$(window).on("resize", function () {
			same_height_columns();
		});

	});

/*-----------------
	3. Update Status	
-----------------------*/


	$(document).ready(function () {
		if ($('.js_status_change').length == 0) return;

		$(".js_status_change").change(function () {
			var id = $(this).attr('data-id');
			var table = $(this).attr('data-table');

			if ($(this).prop("checked") == true) {
				update_status(id, table, 'aktiv');
			} else {
				update_status(id, table, 'deaktiv');
			}
		});


	});

	function update_status(id, table, status, reload = false) {

		var data = {
			action: 'update_status',
			id: id,
			table: table,
			status: status
		};

		$.ajax({
			url: siteurl + "controllers/AJAX.php",
			type: "POST",
			data: data,
			success: function (success) {
				var obj = jQuery.parseJSON(success);

				if (obj.result == "true") {
					toastr.success('Status erfolgreich angepasst', 'Status Update!');
					if (reload == true) location.reload();
				} else {
					fehlermeldung();
					if (reload == true) location.reload();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				fehlermeldung();
			}
		});
	}


/*-----------------
	4. Menü einklappen	
-----------------------*/

	$('#toggle_btn').click(function (e) {
		e.preventDefault();
		Locker.lock(true);
		var value = '';

		if ($('body').attr('class') == 'mini-sidebar') value = '0';
		else value = '1';

		var data = {
			action: 'menue_toggle',
			value: value
		};

		$.ajax({
			url: siteurl + "controllers/AJAX.php",
			type: "POST",
			data: data,
			success: function (success) {
				var obj = jQuery.parseJSON(success);
				if (obj.result == "true") {
					Locker.lock(false);
				} else {
					fehlermeldung();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				fehlermeldung();
				Locker.lock(false);
			}
		});
	});



/*-----------------
	5. User anlegen
-----------------------*/

	$(document).ready(function () {

		if (($('.js_user_anlegen_wrapper').length == 0) && ($('.js_user_bearbeiten_wrapper').length == 0)) return;

		$('.js_user_anlegen_wrapper #vorname, .js_user_anlegen_wrapper #nachname, .js_user_bearbeiten_wrapper #vorname, .js_user_bearbeiten_wrapper #nachname').change(function () {
			var vorname = $('#vorname').val();
			var nachname = $('#nachname').val();

			if (vorname == '') return;
			if (nachname == '') return;

			Locker.lock(true);

			var data = {
				action: 'get_username',
				vorname: vorname,
				nachname: nachname
			};

			$.ajax({
				url: siteurl + "controllers/AJAX.php",
				data: data,
				type: 'POST',
				success: function (success) {
					var obj = jQuery.parseJSON(success);
					if (obj.result == true) {
						$('#username').val(obj.username);
						Locker.lock(false);
						$("#username").effect("shake");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					fehlermeldung();
				}
			});

		});


	});

/*-----------------
	6. Permissions
-----------------------*/

	$(document).ready(function () {

		if ($('#permission-wrapper').length == 0) return;
		$('#permission-wrapper input[type="checkbox"]').on('change', function () {
			
			
			var data = {
				action         : "update_permission",
				permission_id  : $(this).data('permission'),
				rolle_id       : $(this).data('rolle-id'),
				checked        : $(this).is(':checked')
			};
	
			$.ajax({
				url: siteurl + "controllers/AJAX.php",
				type: "POST",
				data: data,
				success: function (success) {
					var obj = jQuery.parseJSON(success);
					if (obj.result == true) {
						toastr.success('Änderung erfolgreich gespeichert');
					} else {
						toastr.success('Achtung! Fehler!');
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					fehlermeldung();
				}
			});
		});
	});


/*-----------------
	7. Artikel anlegen
-----------------------*/

	$(document).ready(function() { 
		if($('.js_artikel_anlegen_wrapper').length == 0) return;

		vertragslaufzeit_changed();

		$('#vertragslaufzeit').change(function() { 
			vertragslaufzeit_changed();
		});

		function vertragslaufzeit_changed() {
			if($('#vertragslaufzeit').is(':checked')) {
				$('.js_vertragslaufzeit_input').show('slow');
				$('.js_vertragslaufzeit_input input').attr('required', true);
			} else {
				$('.js_vertragslaufzeit_input').hide();
				$('.js_vertragslaufzeit_input input').attr('required', false);
			}
		}

	});



/*-----------------
	8. E-Mail Logs aufrufen
-----------------------*/

	$('.js_email_logs_anzeigen').click(function() { 

		Locker.lock(true);

		var data = {
			action      : "get_email_logs",
			eintrag_typ : $('.js_table_tbody_email_logs').attr('data-eintrag-typ'),
			id          : $('.js_table_tbody_email_logs').attr('data-id')
		};
		console.log(data);

		$.ajax({
			url: siteurl + "controllers/AJAX.php",
			type: "POST",
			data: data,
			success: function (success) {
				var obj = jQuery.parseJSON(success);
				if(obj.eintraege == null) {
					fehlermeldung(obj.message);
				} else {
					$('.js_table_tbody_email_logs').html(obj.html);
					$('#modal_email_logs').modal('show');
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
	9. Ansprechpartner anlegen / bearbeiten
-----------------------*/
	var ansprechpartner_modal_modus;
	var ansprechpartner_bearbeiten_id;

	$('.js_ansprechpartner_anlegen').click(function() { 
		$('#modal_ansprechpartner_anlegen .modal-header .modal-title span').html('anlegen');
		$('#js_modal_ansprechpartner_anlegen_submit').html('anlegen');
		$('#modal_ansprechpartner_anlegen').modal('show');
		ansprechpartner_modal_modus = 'anlegen';
	});

	$('#js_modal_ansprechpartner_anlegen_submit').click(function() { 
		
		var praefix = '#maa_';

		var required_fields = [
			praefix+'anrede',
			praefix+'vorname',
			praefix+'nachname'
		];

		var valid = check_required_fields(required_fields);

		if(valid == false) {
			fehlermeldung('Bitte alle Pflichtfelder eingeben');
			return;
		}

		ajax_ansprechpartner_anlegen_bearbeiten({ 
			'anrede'      : $(required_fields[0]).val(),
			'vorname'     : $(required_fields[1]).val(),
			'nachname'    : $(required_fields[2]).val(),
			'email'       : $(praefix+'email').val(),
			'mobilnummer' : $(praefix+'mobilnummer').val(),
			'bemerkung'   : $(praefix+'bemerkung').val(),
			'whatsapp'    : $(praefix+'whatsapp').is(':checked'),
		});

	});
	

	$('.js_ansprechpartner_bearbeiten').click(function() { 

		ansprechpartner_bearbeiten_id = $(this).attr('data-id');
		Locker.lock(true);
			
		var data = {
			action   : "get_ansprechpartner",
			id       : ansprechpartner_bearbeiten_id
		};

		$.ajax({
			url: siteurl + "controllers/AJAX.php",
			type: "POST",
			data: data,
			success: function (success) {
				var obj = jQuery.parseJSON(success);
				if(obj.result == null) fehlermeldung();
				else ansprechpartner_modal_ausfuellen(obj.result); 

				Locker.lock(false);
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				fehlermeldung();
				Locker.lock(false);
			}
		});

	});

	function ansprechpartner_modal_ausfuellen(ansprechpartner) {
		
		var praefix = '#maa_';

		$(praefix+'anrede').val(ansprechpartner.anrede);
		$(praefix+'vorname').val(ansprechpartner.vorname);
		$(praefix+'nachname').val(ansprechpartner.nachname);
		$(praefix+'email').val(ansprechpartner.email);
		$(praefix+'mobilnummer').val(ansprechpartner.mobilnummer);
		$(praefix+'bemerkung').val(ansprechpartner.bemerkung);
		update_toggle_value(praefix+'whatsapp', ansprechpartner.whatsapp);

		$('#js_modal_ansprechpartner_anlegen_submit').html('speichern');
		$('#modal_ansprechpartner_anlegen .modal-header .modal-title span').html('bearbeiten');
		$('#modal_ansprechpartner_anlegen').modal('show');
		ansprechpartner_modal_modus = 'bearbeiten';
		 
	}

	function ajax_ansprechpartner_anlegen_bearbeiten(fields) {
		
		Locker.lock(true);
		var action;

		if(ansprechpartner_modal_modus == 'anlegen') action = 'insert_ansprechpartner';
		else action = 'update_ansprechpartner';
			
		var data = {
			action             : action,
			kunde_id           : $('#kunde_id').val(),
			id                 : ansprechpartner_bearbeiten_id,
			anrede             : fields.anrede,
			vorname            : fields.vorname,
			nachname           : fields.nachname,
			email              : fields.email,
			mobilnummer        : fields.mobilnummer,
			whatsapp           : fields.whatsapp,
			bemerkung          : fields.bemerkung
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
	10. Artikel bearbeiten
-----------------------*/	

	$(document).ready(function() { 
		if($('.js_artikel_bearbeiten_wrapper').length == 0) return;
		Locker.lock(true);
		$('#artikel_nummer').attr('disabled', 'disabled');
		Locker.lock(false);
	});

	
/*-----------------
	11. Kunde bearbeiten / anlegen Zammad Organisations ID change
-----------------------*/	

	$(document).ready(function(){
		if($('.js_kunde_wrapper').length == 0) return;
		if($('#zammad_organization_id').length == 0) return;
		zammad_organisation_id_changed();

		$('#zammad_organization_id').change(function(){ 
			zammad_organisation_id_changed();
		});

		function zammad_organisation_id_changed() {
			var val = $('#zammad_organization_id').val();

			if(val == '') {
				$('#btn_kunde_submit').show();
				return;
			}

			var data = {
				action               : "validate_zammad_organisation_id",
				organisation_id      : val
			};

			Locker.lock(true);

			$.ajax({
				url: siteurl + "controllers/AJAX.php",
				type: "POST",
				data: data,
				success: function (success) {
					var obj = jQuery.parseJSON(success);
					if(obj.valid == false) {
						fehlermeldung('Diese Organisationsnummer ist nicht vorhanden. Speichern nicht möglich!');
						$('#btn_kunde_submit').hide('slow');
					} else {
						$('#btn_kunde_submit').show();
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
	12. Update Theme Mode
-----------------------*/

	$(document).ready(function(){
		if($('.js_profil_wrapper').length == 0) return;
		
		$('#theme_mode').change(function(){ 
			theme_mode_changed();
		});

		function theme_mode_changed() {
			var val = $('#theme_mode').val();

			var data = {
				action          : "update_theme_mode",
				theme_mode      : val
			};

			Locker.lock(true);

			$.ajax({
				url: siteurl + "controllers/AJAX.php",
				type: "POST",
				data: data,
				success: function (success) {
					var obj = jQuery.parseJSON(success);
					if(obj.result == true) {
						location.reload();
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


		}

	});



/*-----------------
	13. Sortierungsfunktion	
-----------------------*/

$(function () {
	if ($('.sort').length == 0) return;
	$(".sort").sortable({
		stop: function (evt, ui) {
			setTimeout(
				function () {
					sort_rows();
				}, 200
			)
		}
	});

	$(".sort").disableSelection(); 
 
	function sort_rows() {
		if ($('.sort').attr('data-table') === undefined) return;
		var rows = [];
		$('.sort tr').each(function (index) {
			var row = {
				id: $(this).attr('data-id'),
				sort: index
			};
			rows.push(row);

		}); 

		var data = {
			action: 'sort',
			rows: rows,
			table: $('.sort').attr('data-table')
		};

		Locker.lock(true);
		$.ajax({
			url: siteurl + "controllers/AJAX.php",
			type: "POST",
			data: data,
			success: function (success) {
				var obj = jQuery.parseJSON(success);
				if (obj.result == "true") {
					toastr.success('Sortierung erfolgreich angepasst', 'Sortierung!');
					Locker.lock(false);
				} else {
					toastr.error('Fehler, bitte Administrator kontaktieren');
					location.reload();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				toastr.error('Fehler, bitte Administrator kontaktieren');
				Locker.lock(false);
			}
		});

	}
});


/*-----------------
	14. Artikel Preis anlegen
-----------------------*/

	$(document).ready(function() { 
		if($('.js_artikel_preis_anlegen').length == 0) return;

		ajax_get_artikel_preise();

		$('.js_artikel_preis_anlegen').click(function() { 
			$('#modal_artikel_preis_anlegen').modal('show');
		});



		$('#js_modal_artikel_preis_anlegen_submit').click(function() { 

			var praefix = '#mapa_';

			var required_fields = [
				praefix+'zyklus_id',
				praefix+'artikel_preis'
			];

			var valid = check_required_fields(required_fields);

			if(valid == false) {
				fehlermeldung('Bitte alle Pflichtfelder eingeben');
				return;
			} 
			
			ajax_artikel_preis_anlegen({
				'zyklus_id'     : $(required_fields[0]).val(),
				'artikel_preis' : $(required_fields[1]).val()
			});
		});

		function ajax_artikel_preis_anlegen(fields)
		{
			var data = {
				action          : "insert_artikel_preis",
				artikel_id      : $('#artikel_id').val(),
				zyklus_id       : fields.zyklus_id,
				artikel_preis   : fields.artikel_preis
			};

			Locker.lock(true);

			$.ajax({
				url: siteurl + "controllers/AJAX.php",
				type: "POST",
				data: data,
				success: function (success) {
					var obj = jQuery.parseJSON(success);
					if(obj.result == false) {
						fehlermeldung(obj.message);
					} else {
						update_table_artikel_preise(obj.html);
					}
					Locker.lock(false);
					
				},
				error: function (xhr, ajaxOptions, thrownError) {
					fehlermeldung();
					Locker.lock(false);
				}
			});
		}

		function ajax_get_artikel_preise() {
			
			var data = {
				action          : "get_artikel_preise",
				artikel_id      : $('#artikel_id').val()
			};

			Locker.lock(true);

			$.ajax({
				url: siteurl + "controllers/AJAX.php",
				type: "POST",
				data: data,
				success: function (success) {
					var obj = jQuery.parseJSON(success);
					update_table_artikel_preise(obj.html);
					Locker.lock(false);
					
				},
				error: function (xhr, ajaxOptions, thrownError) {
					fehlermeldung();
					Locker.lock(false);
				}
			});
		}

	});

	function delete_artikel_preis(element) {
		if(confirm('Sicher?') == false) return;
		var data = {
			action            : "delete_artikel_preis",
			artikel_id        : $('#artikel_id').val(),
			artikel_preis_id  : $(element).attr('data-id')
		};

		Locker.lock(true);

		$.ajax({
			url: siteurl + "controllers/AJAX.php",
			type: "POST",
			data: data,
			success: function (success) {
				var obj = jQuery.parseJSON(success);
				if(obj.result != false) {
					update_table_artikel_preise(obj.html);
				} 
				Locker.lock(false);
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				fehlermeldung();
				Locker.lock(false);
			}
		});
	}

	function update_table_artikel_preise(html) {
		
		if(html == '') $('.js_table_artikel_preise').hide();
		else $('.js_table_artikel_preise').show();
		
		$('.js_table_artikel_preise tbody').html(html);
	}


	
/*-----------------
	15. Tabelle sortieren	
-----------------------*/

$(document).ready(function() {
	if($('.sortable-table	').length == 0) return;
    const table = document.getElementsByClassName("sortable-table")[0];
    const headers = table.querySelectorAll("th");
    const tbody = table.querySelector("tbody");
    let isAscending = true; // Wird verwendet, um die Sortierreihenfolge zu verfolgen

    // Funktion zum Sortieren der Tabelle
    function sortTable(columnIndex) {

		
		insert_sortable_icon(columnIndex);

        const rows = Array.from(tbody.querySelectorAll("tr")); // Alle Zeilen, außer der Header
        rows.sort((rowA, rowB) => {
            const cellA = rowA.cells[columnIndex].textContent.trim();
            const cellB = rowB.cells[columnIndex].textContent.trim();

            // Zahlen als Zahlen vergleichen
            const a = isNaN(cellA) ? cellA : parseFloat(cellA);
            const b = isNaN(cellB) ? cellB : parseFloat(cellB);

            if (a < b) return isAscending ? -1 : 1;
            if (a > b) return isAscending ? 1 : -1;
            return 0;
        });

        // Zeilen neu anordnen
        rows.forEach(row => table.querySelector("tbody").appendChild(row));

        // Reihenfolge umkehren für die nächste Sortierung
        isAscending = !isAscending;
    }

	function insert_sortable_icon(columnIndex) {
		const th = $('.sortable-table thead tr th:nth-child('+(columnIndex + 1)+')');
		const title = $(th).html();
		$('.sortable-table thead tr th .js_sortable_filter').remove();
		if($(th).find('.js_sortable_filter').length == 0) {
			$(th).html(title + ' <i class="js_sortable_filter fa fa-filter"></i>');
		}
		
	}

    // Event Listener für das Klicken auf die Spaltenüberschriften
    headers.forEach((header, index) => {
        header.addEventListener("click", () => {
            sortTable(index);
        });
    });
});


/*-----------------
	16. Quality Hosting Rechnung anlegen
-----------------------*/

	var quality_hosting_reseller_id;
	var quality_hosting_positionen;

	$('.js_qualityhost_rechnung_anlegen').click(function() 
	{ 
		quality_hosting_reseller_id = $(this).attr('data-id');
		quality_hosting_positionen = $('.' + quality_hosting_reseller_id.replace(/\./g, '\\.'));

		var data = {
			action                  : "get_rechnungen_fuer_quality_hosting_rechnung",
			reseller_customer_id    : quality_hosting_reseller_id
		};

		Locker.lock(true);

		$.ajax({
			url: siteurl + "controllers/AJAX.php",
			type: "POST",
			data: data,
			success: function (success) {
				var obj = jQuery.parseJSON(success);
				if(obj.vorhanden == true) {
					$('#modal_quality_hosting_rechnung_anlegen_rechnung_auswahl .js_table_quality_hosting_rechnungen').html(obj.html);
					$('#modal_quality_hosting_rechnung_anlegen_rechnung_auswahl').modal('show');
				} else {
					qualityhost_rechnung_anlegen(quality_hosting_reseller_id, quality_hosting_positionen, 0);
				}
				Locker.lock(false);
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				fehlermeldung();
				Locker.lock(false);
			}
		});

	});
	$(document).on('click', '.js_qualityhost_positionen_rechnung_hinzufuegen', function(event) {
	
		event.preventDefault(); 
	 if (confirm('Die Positionen werden der vorhandeenn Rechnung hinzugefügt. Sicher?') == false) return;

		var rechnung_id = $(this).attr('data-rechnung-id');

		qualityhost_rechnung_anlegen(quality_hosting_reseller_id, quality_hosting_positionen, rechnung_id);
	});

	$('.js_qualityhost_rechnung_neue_rechnung_anlegen').click(function() 
	{ 
		qualityhost_rechnung_anlegen(quality_hosting_reseller_id, quality_hosting_positionen, 0);
	});


	function qualityhost_rechnung_anlegen(id, positionen, rechnung_id) {
			
		var tableData = [];

		// Iteriere über alle Zeilen (z. B. <tr>-Elemente)
		positionen.each(function() {
			// `this` bezieht sich auf die aktuelle Zeile
			var row = $(this);

			var rowData = {
				artikel_name: row.find('.js_qhr_artikelname').text().trim(),       // Artikelname
				artikel_menge: row.find('.js_qhr_anzahl').text().trim(),           // Anzahl
				artikel_preis: row.find('.js_qhr_preis').text().trim(),            // Preis
				csv_dateiname: row.find('.js_qhr_csv_dateiname').text().trim(),    // CSV-Dateiname
			};
			// Füge das Array mit den Werten der Zeile in das Haupt-Array ein
			tableData.push(rowData);
		});

		var data = {
			action                  : "quality_hosting_rechnung_anlegen",
			reseller_customer_id    : id,
			positionen              : tableData,
			csv_dateiname           : tableData[0]['csv_dateiname'],
			rechnung_id             : rechnung_id
		};

		Locker.lock(true);

		$.ajax({
			url: siteurl + "controllers/AJAX.php",
			type: "POST",
			data: data,
			success: function (success) {
				var obj = jQuery.parseJSON(success);
				if(obj.result != false) {
					$('#modal_quality_hosting_rechnung_anlegen_rechnung_auswahl').modal('hide');
					$('.js-card-' + id).hide();
					erfolgsmeldung('Erfolgreich hinzugefügt');
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
	17. Backup erstellen
-----------------------*/

	$('.js_backup_erstellen').click(function() 
	{ 
		var data = {
			action     : "datenback_backup_erstellen"
		};

		Locker.lock(true);

		$.ajax({
			url: siteurl + "controllers/AJAX.php",
			type: "POST",
			data: data,
			success: function (success) {
				var obj = jQuery.parseJSON(success);
				if(obj.result != false) {
					location.reload();
				} else {
					toastr.error('Backup fehlgeschlagen');
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
    18. Backup löschen
-----------------------*/

	var backup_loeschen_id;

	$('.js_backup_loeschen').click(function() { 
		backup_loeschen_id = $(this).attr('data-id');
		if(confirm('Sicher?') == false) return;

		ajax_backup_loeschen(backup_loeschen_id);
	});

	function ajax_backup_loeschen(id) {
		
		Locker.lock(true);
			
		var data = {
			action      : "delete_backup",
			backup_id	: id
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