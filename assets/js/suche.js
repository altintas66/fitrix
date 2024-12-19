/*
	Author       : INOYA
*/

/*============================
 [Table of JS]

1.  Freitextsuche
2.  Filter nach Status (Aufträge)
3.  Status Kunden Filter
4.  Status Angebot Filter
5.  Status Rechnung Filter
6. Status Artikel Filter
7. Status Abonnement Filter
8. Server Hostings Filter



========================================*/

		var search_input_elements = {
			'#search-input-kunde'       		  : 'table.js_table_kunden tbody tr',
			'#search-input-angebot'     		  : 'table.js_table_angebote tbody tr',
			'#search-input-rechnung'    		  : 'table.js_table_rechnungen tbody tr',
			'#search-input-artikel'     		  : 'table.js_table_artikel tbody tr',
			'#search-input-abonnement'  		  : 'table.js_table_abonnements tbody tr',
			'#search-input-hosting'  		      : 'table.js_table_hostings tbody tr'
		};


	$(document).ready(function () {

		/*-----------------
			1. Freitextsuche
		-----------------------*/

		$(Object.keys(search_input_elements).toString()).on('focus', function () {
			$('.js_result_freitextsuche_anzahl').html($('.js_table tbody tr').length);
		});

		$(Object.keys(search_input_elements).toString()).on('keyup', function () {

			var id = '#' + $(this).attr('id');
			var table = search_input_elements[id];
			var trs = $(table);
			var value = $(this).val().toLowerCase();
			var counter = 0;

			if(value == '') {
				reset_serach_input_freitext();
				return;
			}

			// Filter the table rows based on the filter value
			$(trs).each(function () {
				if ($(this).text().toLowerCase().indexOf(value) > -1) {
					$(this).show();
					counter++;
					if (value != '') {
						$(this).find('td').each(function () {
							if($(this).html().toLowerCase().includes(value)) $(this).addClass('highlight');
							else $(this).removeClass('highlight');
						});
					}
				}
				else {
					$(this).hide();

				}
				var anzahl = counter;
				$('.js_result_freitextsuche_anzahl').html(anzahl);
			});


		});

		function reset_serach_input_freitext() {
			
			$('.js_table tbody tr').show();
			$('.js_table tbody tr td').removeClass('highlight');
			$('.js_result_freitextsuche_anzahl').html($('.js_table tbody tr').length);
			
			$(search_input_elements).each(function (key, value) { 
				$(key).val('');
			});
			
		}

		

	});



	/*-----------------
		3. Status Kunden Filter
	-----------------------*/ 
		
	$(document).ready(function() {

		init_kunden_filter();
		

		function init_kunden_filter() { 
			Locker.lock(true);
			
			var anzahl_aktive_trs = $('.js_table_kunden tbody tr[data-status="aktiv"]').length;
			
			aktive_kunde_anzeigen(anzahl_aktive_trs);
			Locker.lock(false);
		}

		$('select[id="filter_status"]').change(function() {
			Locker.lock(true);
			
			var val = $('select[id="filter_status"] option:selected').val();
			if(val == 'aktiv') {
				var anzahl_aktive_trs = $('.js_table_kunden tbody tr[data-status="aktiv"]').length;
				aktive_kunde_anzeigen(anzahl_aktive_trs);
			}
			else if(val == 'deaktiv') {
				var anzahl_deaktive_trs = $('.js_table_kunden tbody tr[data-status="deaktiv"]').length;
				deaktive_kunde_anzeigen(anzahl_deaktive_trs);
			}
			else if(val == 'alle') {
				var anzahl = $('.js_table_kunden tbody tr').length;
			alle_kunde_anzeigen(anzahl);
			}

			Locker.lock(false);
		});


		function aktive_kunde_anzeigen(anzahl_aktive_trs) {
			$('.js_table_kunden tbody tr').hide();
			$('.js_table_kunden tbody tr[data-status="aktiv"]').show();
			$('.js_anzahl_kunde_tabelle').html(anzahl_aktive_trs);
		}

		function deaktive_kunde_anzeigen(anzahl_deaktive_trs) {
			$('.js_table_kunden tbody tr').hide();
			$('.js_table_kunden tbody tr[data-status="deaktiv"]').show();
			$('.js_anzahl_kunde_tabelle').html(anzahl_deaktive_trs);
		}

		function alle_kunde_anzeigen(anzahl) {
			$('.js_table_kunden tbody tr').show();
			$('.js_anzahl_kunde_tabelle').html(anzahl);
		}

	});



	/*-----------------
		4. Status Angebot Filter
	-----------------------*/ 
		
	$(document).ready(function() {

		init_angebote_filter();
		
	
		function init_angebote_filter() { 
			Locker.lock(true);
			
			var anzahl_offene_trs = $('.js_table_angebote tbody tr[data-status="offen"]').length;
			
			offene_angebot_anzeigen(anzahl_offene_trs);
			Locker.lock(false);
		}
	
		$('select[id="filter_status"]').change(function() {
			Locker.lock(true);
			
			var val = $('select[id="filter_status"] option:selected').val();
			if(val == 'offen') {
				var anzahl_offene_trs = $('.js_table_angebote tbody tr[data-status="offen"]').length;
				offene_angebot_anzeigen(anzahl_offene_trs);
			}
			else if(val == 'entwurf') {
				var anzahl_entwurf_trs = $('.js_table_angebote tbody tr[data-status="entwurf"]').length;
				entwurf_angebot_anzeigen(anzahl_entwurf_trs);
			}
			else if(val == 'storniert') {
				var anzahl_stornierte_trs = $('.js_table_angebote tbody tr[data-status="storniert"]').length;
				stornierte_angebot_anzeigen(anzahl_stornierte_trs);
			}
			else if(val == 'alle') {
				var anzahl = $('.js_table_angebote tbody tr').length;
			alle_angebot_anzeigen(anzahl);
			}
	
			Locker.lock(false);
		});
	
	
		function offene_angebot_anzeigen(anzahl_offene_trs) {
			$('.js_table_angebote tbody tr').hide();
			$('.js_table_angebote tbody tr[data-status="offen"]').show();
			$('.js_anzahl_angebot_tabelle').html(anzahl_offene_trs);
		}
	
		function entwurf_angebot_anzeigen(anzahl_entwurf_trs) {
			$('.js_table_angebote tbody tr').hide();
			$('.js_table_angebote tbody tr[data-status="entwurf"]').show();
			$('.js_anzahl_angebot_tabelle').html(anzahl_entwurf_trs);
		}

		function stornierte_angebot_anzeigen(anzahl_stornierte_trs) {
			$('.js_table_angebote tbody tr').hide();
			$('.js_table_angebote tbody tr[data-status="storniert"]').show();
			$('.js_anzahl_angebot_tabelle').html(anzahl_stornierte_trs);
		}
	
		function alle_angebot_anzeigen(anzahl) {
			$('.js_table_angebote tbody tr').show();
			$('.js_anzahl_angebot_tabelle').html(anzahl);
		}
	
	});



	/*-----------------
		5. Status Rechnung Filter
	-----------------------*/ 
		
	$(document).ready(function() {

		init_rechnungen_filter();
		
	
		function init_rechnungen_filter() { 
			Locker.lock(true);
			
			var anzahl_offene_trs = $('.js_table_rechnungen tbody tr[data-status="offen"]').length;
			
			offene_rechnung_anzeigen(anzahl_offene_trs);
			Locker.lock(false);
		}
	
		$('select[id="filter_status"]').change(function() {
			Locker.lock(true);
			
			var val = $('select[id="filter_status"] option:selected').val();
			if(val == 'offen') {
				var anzahl_offene_trs = $('.js_table_rechnungen tbody tr[data-status="offen"]').length;
				offene_rechnung_anzeigen(anzahl_offene_trs);
			}
			else if(val == 'entwurf') {
				var anzahl_entwurf_trs = $('.js_table_rechnungen tbody tr[data-status="entwurf"]').length;
				entwurf_rechnung_anzeigen(anzahl_entwurf_trs);
			}
			else if(val == 'storniert') {
				var anzahl_stornierte_trs = $('.js_table_rechnungen tbody tr[data-status="storniert"]').length;
				stornierte_rechnung_anzeigen(anzahl_stornierte_trs);
			}
			else if(val == 'bezahlt') {
				var anzahl_bezahlte_trs = $('.js_table_rechnungen tbody tr[data-status="bezahlt"]').length;
				bezahlte_rechnung_anzeigen(anzahl_bezahlte_trs);
			}
			else if(val == 'alle') {
				var anzahl = $('.js_table_rechnungen tbody tr').length;
			alle_rechnung_anzeigen(anzahl);
			}
	
			Locker.lock(false);
		});
	
	
		function offene_rechnung_anzeigen(anzahl_offene_trs) {
			$('.js_table_rechnungen tbody tr').hide();
			$('.js_table_rechnungen tbody tr[data-status="offen"]').show();
			$('.js_anzahl_rechnung_tabelle').html(anzahl_offene_trs);
		}
	
		function entwurf_rechnung_anzeigen(anzahl_entwurf_trs) {
			$('.js_table_rechnungen tbody tr').hide();
			$('.js_table_rechnungen tbody tr[data-status="entwurf"]').show();
			$('.js_anzahl_rechnung_tabelle').html(anzahl_entwurf_trs);
		}
	
		function stornierte_rechnung_anzeigen(anzahl_stornierte_trs) {
			$('.js_table_rechnungen tbody tr').hide();
			$('.js_table_rechnungen tbody tr[data-status="storniert"]').show();
			$('.js_anzahl_rechnung_tabelle').html(anzahl_stornierte_trs);
		}
	
		function bezahlte_rechnung_anzeigen(anzahl_bezahlte_trs) {
			$('.js_table_rechnungen tbody tr').hide();
			$('.js_table_rechnungen tbody tr[data-status="bezahlt"]').show();
			$('.js_anzahl_rechnung_tabelle').html(anzahl_bezahlte_trs);
		}
	
		function alle_rechnung_anzeigen(anzahl) {
			$('.js_table_rechnungen tbody tr').show();
			$('.js_anzahl_rechnung_tabelle').html(anzahl);
		}
	
	});
	


/*-----------------
		6. Status Artikel Filter
	-----------------------*/ 
		
	$(document).ready(function() {

		init_artikel_filter();
		

		function init_artikel_filter() { 
			Locker.lock(true);
			
			var anzahl_aktive_trs = $('.js_table_artikel tbody tr[data-status="aktiv"]').length;
			
			aktive_artikel_anzeigen(anzahl_aktive_trs);
			Locker.lock(false);
		}

		$('select[id="filter_status"]').change(function() {
			Locker.lock(true);
			
			var val = $('select[id="filter_status"] option:selected').val();
			if(val == 'aktiv') {
				var anzahl_aktive_trs = $('.js_table_artikel tbody tr[data-status="aktiv"]').length;
				aktive_artikel_anzeigen(anzahl_aktive_trs);
			}
			else if(val == 'deaktiv') {
				var anzahl_deaktive_trs = $('.js_table_artikel tbody tr[data-status="deaktiv"]').length;
				deaktive_artikel_anzeigen(anzahl_deaktive_trs);
			}
			else if(val == 'alle') {
				var anzahl = $('.js_table_artikel tbody tr').length;
			alle_artikel_anzeigen(anzahl);
			}

			Locker.lock(false);
		});


		function aktive_artikel_anzeigen(anzahl_aktive_trs) {
			$('.js_table_artikel tbody tr').hide();
			$('.js_table_artikel tbody tr[data-status="aktiv"]').show();
			$('.js_anzahl_artikel_tabelle').html(anzahl_aktive_trs);
		}

		function deaktive_artikel_anzeigen(anzahl_deaktive_trs) {
			$('.js_table_artikel tbody tr').hide();
			$('.js_table_artikel tbody tr[data-status="deaktiv"]').show();
			$('.js_anzahl_artikel_tabelle').html(anzahl_deaktive_trs);
		}

		function alle_artikel_anzeigen(anzahl) {
			$('.js_table_artikel tbody tr').show();
			$('.js_anzahl_artikel_tabelle').html(anzahl);
		}

	});

	
	
/*-----------------
		7. Status Abonnement Filter
	-----------------------*/ 
		
	
	$(document).ready(function() {

		init_abonnements_filter();
		
	
		function init_abonnements_filter() { 
			Locker.lock(true);
			
			var anzahl_aktive_trs = $('.js_table_abonnements tbody tr[data-status="aktiv"]').length;
			
			aktive_abonnement_anzeigen(anzahl_aktive_trs);
			Locker.lock(false);
		}
	
		$('select[id="filter_status"]').change(function() {
			Locker.lock(true);
			
			var val = $('select[id="filter_status"] option:selected').val();
			if(val == 'aktiv') {
				var anzahl_aktive_trs = $('.js_table_abonnements tbody tr[data-status="aktiv"]').length;
				aktive_abonnement_anzeigen(anzahl_aktive_trs);
			}
			else if(val == 'deaktiv') {
				var anzahl_deaktive_trs = $('.js_table_abonnements tbody tr[data-status="deaktiv"]').length;
				deaktive_abonnement_anzeigen(anzahl_deaktive_trs);
			}
			else if(val == 'alle') {
				var anzahl = $('.js_table_abonnements tbody tr').length;
				alle_abonnement_anzeigen(anzahl);
			}
	
			Locker.lock(false);
		});
	
	
		function aktive_abonnement_anzeigen(anzahl_aktive_trs) {
			$('.js_table_abonnements tbody tr').hide();
			$('.js_table_abonnements tbody tr[data-status="aktiv"]').show();
			$('.js_anzahl_abonnement_tabelle').html(anzahl_aktive_trs);
		}
	
		function deaktive_abonnement_anzeigen(anzahl_deaktive_trs) {
			$('.js_table_abonnements tbody tr').hide();
			$('.js_table_abonnements tbody tr[data-status="deaktiv"]').show();
			$('.js_anzahl_abonnement_tabelle').html(anzahl_deaktive_trs);
		}
	
		function alle_abonnement_anzeigen(anzahl) {
			$('.js_table_abonnements tbody tr').show();
			$('.js_anzahl_abonnement_tabelle').html(anzahl);
		}

	
	});


/*-----------------
		8. Server Hostings Filter
	-----------------------*/ 

	$(document).ready(function() {

		init_hostings_filter();

		function init_hostings_filter() {
			Locker.lock(true);
			
			var anzahl_alle_trs = $('.js_table_hostings tbody tr').length;
			alle_hostings_anzeigen(anzahl_alle_trs);

			Locker.lock(false);
		 }

		 $('select[id="filter_server"]').change(function() {
			Locker.lock(true);

				var val = $('select[id="filter_server"] option:selected').val();

				if(val == 'alle'){
					var anzahl_alle_trs = $('.js_table_hostings tbody tr').length;
					alle_hostings_anzeigen(anzahl_alle_trs);
				}else{
					var anzahl_bestimmte_trs = $('.js_table_hostings tbody tr[data-server="'+ val +'"]').length;
					bestimmte_hostings_anzeigen(anzahl_bestimmte_trs, val);
				}

			Locker.lock(false);
		});
		
		 function alle_hostings_anzeigen(anzahl) {
			$('.js_table_hostings tbody tr').show();
			$('.js_anzahl_hostings_tabelle').html(anzahl);
		}

		function bestimmte_hostings_anzeigen(anzahl, server) {
			$('.js_table_hostings tbody tr').hide();
			$('.js_table_hostings tbody tr[data-server="'+ server +'"]').show();
			$('.js_anzahl_hostings_tabelle').html(anzahl);
		}

	});