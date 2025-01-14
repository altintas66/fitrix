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
6.  Status Artikel Filter
7.  Status Abonnement Filter
8.  Server Hostings Filter



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
			alle_kunden_anzeigen();
			Locker.lock(false);
		}
	
		$('select[id="filter_status"]').change(function() {
			Locker.lock(true);

			var val = $('select[id="filter_status"] option:selected').val();

			if(val == 'alle') {
				alle_kunden_anzeigen();
			} else {
				var trs = $('.js_table_kunden tbody tr[data-status="'+val+'"]').length;
				kunden_anzeigen(trs, val);
			}
	
			Locker.lock(false);
		});

		function kunden_anzeigen(trs, status) {
			$('.js_table_kunden tbody tr').hide();
			$('.js_table_kunden tbody tr[data-status="'+status+'"]').show();
			$('.js_anzahl_kunde_tabelle').html(trs);
		}
	
		function alle_kunden_anzeigen() {
			$('.js_table_kunden tbody tr').show();
			$('.js_anzahl_kunde_tabelle').html($('.js_table_kunden tbody tr').length);
		}
	
	});



	/*-----------------
		4. Status Angebot Filter
	-----------------------*/ 
		
	$(document).ready(function() {

		init_angebote_filter();
		
	
		function init_angebote_filter() { 
			Locker.lock(true);
			alle_angebote_anzeigen();
			Locker.lock(false);
		}
	
		$('select[id="filter_status"]').change(function() {
			Locker.lock(true);

			var val = $('select[id="filter_status"] option:selected').val();

			if(val == 'alle') {
				alle_angebote_anzeigen();
			} else {
				var trs = $('.js_table_angebote tbody tr[data-status="'+val+'"]').length;
				angebote_anzeigen(trs, val);
			}
	
			Locker.lock(false);
		});

		function angebote_anzeigen(trs, status) {
			$('.js_table_angebote tbody tr').hide();
			$('.js_table_angebote tbody tr[data-status="'+status+'"]').show();
			$('.js_anzahl_angebot_tabelle').html(trs);
		}
	
		function alle_angebote_anzeigen() {
			$('.js_table_angebote tbody tr').show();
			$('.js_anzahl_angebot_tabelle').html($('.js_table_angebote tbody tr').length);
		}
	
	});



	/*-----------------
		5. Status Rechnung Filter
	-----------------------*/ 
		
	$(document).ready(function() {

		init_rechnungen_filter();
		
	
		function init_rechnungen_filter() { 
			Locker.lock(true);
			
			
			alle_rechnung_anzeigen();
			Locker.lock(false);
		}
	
		$('select[id="filter_status"]').change(function() {
			Locker.lock(true);
			

			var val = $('select[id="filter_status"] option:selected').val();

			if(val == 'alle') {
				alle_rechnung_anzeigen();
			} else {
				var trs = $('.js_table_rechnungen tbody tr[data-status="'+val+'"]').length;
				rechnungen_anzeigen(trs, val);
			}
			
			Locker.lock(false);
		});
	
	
		function rechnungen_anzeigen(trs, status) {
			$('.js_table_rechnungen tbody tr').hide();
			$('.js_table_rechnungen tbody tr[data-status="'+status+'"]').show();
			$('.js_anzahl_rechnung_tabelle').html(trs);
		}
	
		function alle_rechnung_anzeigen() {
			$('.js_table_rechnungen tbody tr').show();
			$('.js_anzahl_rechnung_tabelle').html($('.js_table_rechnungen tbody tr').length);
		}
	
	});
	


/*-----------------
		6. Status Artikel Filter
	-----------------------*/ 
		

	$(document).ready(function() {

		init_artikel_filter();
		
	
		function init_artikel_filter() { 
			Locker.lock(true);
			
			
			alle_artikel_anzeigen();
			Locker.lock(false);
		}
	
		$('select[id="filter_status"]').change(function() {
			Locker.lock(true);
			

			var val = $('select[id="filter_status"] option:selected').val();

			if(val == 'alle') {
				alle_artikel_anzeigen();
			} else {
				var trs = $('.js_table_artikel tbody tr[data-status="'+val+'"]').length;
				artikel_anzeigen(trs, val);
			}
			
			Locker.lock(false);
		});
	
	
		function artikel_anzeigen(trs, status) {
			$('.js_table_artikel tbody tr').hide();
			$('.js_table_artikel tbody tr[data-status="'+status+'"]').show();
			$('.js_anzahl_artikel_tabelle').html(trs);
		}
	
		function alle_artikel_anzeigen() {
			$('.js_table_artikel tbody tr').show();
			$('.js_anzahl_artikel_tabelle').html($('.js_table_artikel tbody tr').length);
		}
	
	});

	
	
/*-----------------
		7. Status Abonnement Filter
	-----------------------*/ 
		

	$(document).ready(function() {

		init_abonnements_filter();
		
	
		function init_abonnements_filter() { 
			Locker.lock(true);
			
			
			alle_abonnement_anzeigen();
			Locker.lock(false);
		}
	
		$('select[id="filter_status"]').change(function() {
			Locker.lock(true);
			

			var val = $('select[id="filter_status"] option:selected').val();

			if(val == 'alle') {
				alle_abonnement_anzeigen();
			} else {
				var trs = $('.js_table_abonnements tbody tr[data-status="'+val+'"]').length;
				abonnement_anzeigen(trs, val);
			}
			
			Locker.lock(false);
		});
	
	
		function abonnement_anzeigen(trs, status) {
			$('.js_table_abonnements tbody tr').hide();
			$('.js_table_abonnements tbody tr[data-status="'+status+'"]').show();
			$('.js_anzahl_abonnement_tabelle').html(trs);
		}
	
		function alle_abonnement_anzeigen() {
			$('.js_table_abonnements tbody tr').show();
			$('.js_anzahl_abonnement_tabelle').html($('.js_table_abonnements tbody tr').length);
		}
	
	});


/*-----------------
		8. Server Hostings Filter
	-----------------------*/ 

	$(document).ready(function() {

		init_hostings_filter();

		function init_hostings_filter() {
			Locker.lock(true);
			alle_hostings_anzeigen();
			Locker.lock(false);
		 }

		 $('select[id="filter_server"]').change(function() {
			Locker.lock(true);

				var val = $('select[id="filter_server"] option:selected').val();

				if(val == 'alle'){
					alle_hostings_anzeigen();
				}else{
					var anzahl_bestimmte_trs = $('.js_table_hostings tbody tr[data-server="'+ val +'"]').length;
					bestimmte_hostings_anzeigen(anzahl_bestimmte_trs, val);
				}

			Locker.lock(false);
		});
		
		 function alle_hostings_anzeigen() {
			$('.js_table_hostings tbody tr').show();
			$('.js_anzahl_hostings_tabelle').html($('.js_table_hostings tbody tr').length);
		}

		function bestimmte_hostings_anzeigen(anzahl, server) {
			$('.js_table_hostings tbody tr').hide();
			$('.js_table_hostings tbody tr[data-server="'+ server +'"]').show();
			$('.js_anzahl_hostings_tabelle').html(anzahl);
		}

	});