/*
	Author       : INOYA
*/

/*============================
 [Table of JS]

0.  Locker
1.  jQuery Plugins
	 1.1 Datepicker
	 1.2 Notebook Editor
	 1.3 Select2  
	 1.4 RICHTEXT EDITOR WYSIWYG
	 1.5 Colorpicker Spectrum
	 1.6 CSS Editor CodeMirror
	 1.7 HTML 5 Image Upload
	 1.8 Datetimepicker
	 1.9 Autonumeric (Input number für Währungen)
	 1.10 jQuery UI Tabs
	 1.11 DataTables
	 1.12 ToolTip
2.  Eigene Funktionen
3.  Beiträge Allgemeine Funktionen
4.  Beiträge laden
5.  Beiträge Posten
6.  Beitrag bearbeiten
7.  Beitrag löschen
8.  Kommentar hinzufügen
9.  Kommentar löschen
10. Kommentar bearbeiten
12. Vertical Tabs
13. Löschen von Einträgen
14. PDF drucken



========================================*/

/*-----------------
	0. Locker
-----------------------*/

var Locker;
var Locker_Top;

function createLocker() {
	Locker = {
		"locked": false,
		"locker": false,
		"lock": function (set, noSpinner) {
			if (set && this.locked) return false;
			if (null != set) {
				$(".locker > span").toggle(!noSpinner);
				this.locked = set;
				this.locker.css('display', this.locked ? 'block' : 'none');
			};
			return true;
		}
	};
	Locker.locker = $('<div class="locker"><span class="fa fa-refresh fa-spin"></span></div>');
	$("body").append(Locker.locker);
	$("<style type='text/css'> .locker { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 9999; padding-top: 200px; text-align: center; font-size: 35px; color: white; } </style>").appendTo("head");
}

function createLockerTop() {
	Locker_Top = {
		"locked": false,
		"locker": false,
		"lock": function(set, noSpinner) {
		if (set && this.locked) return false;
		if (null != set) {
			$(".locker > span").toggle(!noSpinner);
			this.locked = set;
			this.locker.css('display', this.locked ? 'block' : 'none');
		};
		return true;
		}
	};
	Locker_Top.locker = $('<div class="locker_top"><span class="fa fa-refresh fa-spin"></span></div>');
	$("body").append(Locker_Top.locker);
	$("<style type='text/css'> .locker_top { display: none; position: fixed; top: 20%; right: 10%; font-size: 65px; } </style>").appendTo("head");

	
}

createLocker();
createLockerTop();

/*-----------------
	1. jQuery Plugins
-----------------------*/

// 1.1 Datepicker

function datepicker_init() {
	if ($('.datepicker').length == 0) return;
	jQuery('.datepicker').datetimepicker({
		format: 'd.m.Y',
		changeMonth    : true,
		changeYear     : true,
		timepicker     : 0,
		dayOfWeekStart : 1,
		scrollInput    : 0,
		scrollMonth    : 0,
		scrollTime     : 0
	});
}

datepicker_init();

function geburtsdatum_init() {
	if ($('.geburtsdatum').length == 0) return;
	var today = new Date();
	$(document).on('click', '.geburtsdatum', function () {
		$(this).datepicker({
			startDate: '01/01/1950',
			changeMonth: true,
			changeYear: true,
			prevText: '&#x3c;zurück', prevStatus: '',
			prevJumpText: '&#x3c;&#x3c;', prevJumpStatus: '',
			nextText: 'Vor&#x3e;', nextStatus: '',
			nextJumpText: '&#x3e;&#x3e;', nextJumpStatus: '',
			currentText: 'heute', currentStatus: '',
			todayText: 'heute', todayStatus: '',
			clearText: '-', clearStatus: '',
			closeText: 'schließen', closeStatus: '',
			monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni',
				'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
			monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun',
				'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
			dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
			dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
			dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
			showMonthAfterYear: false,
			dateFormat: 'dd.mm.yy',
			dayOfWeekStart: 1,
			endDate: "today",
			maxDate: today
		}).focus();
		$(this).removeClass('geburtsdatum');
	});
}
geburtsdatum_init();

// 1.2 Notebook Editor


// 1.3 Select2    

(function ($) {
	if ($('.select2').length == 0) return;
	$('.select2').each(function () {
		$(this).select2({
			"language": "de-DE"
		});
	});

})(jQuery);


// 1.4 RICHTEXT EDITOR WYSIWYG

(function ($) {
	if ($('.wysiwyg').length == 0) return;
	$('.wysiwyg').each(function () {
		$(this).summernote({
			theme: 'monokai',
			height: 300 
		});
	});

})(jQuery);




// 1.5 Colorpicker Spectrum



// 1.6 CSS Editor CodeMirror


//1.7 HTML 5 Image Upload

$('#retrievingfilename').html5imageupload({
	onAfterProcessImage: function () {
		$('#filename').val($(this.element).data('name'));
	},
	onAfterCancel: function () {
		$('#filename').val('');
	}
});

(function ($) {
	if ($('.dropzone').length == 0) return;
	$('.dropzone').html5imageupload();
})(jQuery);

//1.8 Datetimepicker

(function ($) {
	if ($('.datetimepicker').length == 0) return;
	jQuery('.datetimepicker').datetimepicker({
		format: 'd.m.Y H:i'
	});
})(jQuery);

//1.9 Autonumeric (Input number für Währungen)

(function ($) {
	if ($('.autonumeric').length == 0) return;
	init_autonumeric();
})(jQuery);

function init_autonumeric() {
	jQuery('.autonumeric').autoNumeric();
}


//1.10 jQuery UI Tabs

(function ($) {
	if ($('.tabs').length == 0) return;
	jQuery('.tabs').tabs();
})(jQuery);

//1.11 DataTables

$(document).ready(function() {

	if($('.datatable').length == 0) return;

	$.fn.dataTable.moment( 'd.m.Y' );

	var options = {
		"bInfo" : false,
		"language": {
			"lengthMenu": "Zeige _MENU_ Einträge pro Seite",
			"search": "Suche:"
		},
		"pageLength": 100,
		"lengthMenu": [ [100, 200, 500, -1], [100, 200, 500, "Alle"] ]
	};


	$('.datatable').dataTable(options);
	document.querySelector('.dt-search').style.display = 'none';

	if($('.js_table_auftraege.datatable').length > 0) {
		Locker.lock(true);
		$('.dt-orderable-desc[data-dt-column="1"]').click();
		$('.dt-orderable-desc[data-dt-column="1"]').click();
		$('.dt-orderable-desc[data-dt-column="1"]').click();
		Locker.lock(false);
	}


});

//1.12 Tooltip

$(function () {
	$('[data-toggle="tooltip"]').tooltip();
});



/*-----------------
	2. Eigene Funktionen
-----------------------*/

function get_toggle_value(element) {
	if ($(element).prop('checked')) return '1';
	else return '0';
}

function update_toggle_value(element_id, value) {
	if (value == '1') $(element_id).prop('checked', true);
	else $(element_id).prop('checked', false);
}

function checkIfHigher() {
	const table = document.querySelector('table');
	const rows = table.getElementsByTagName('tr');

	for (let i = 0; i < rows.length; i++) {
		const cells = rows[i].getElementsByTagName('td');

		for (let j = 1; j < cells.length; j++) {
			const inputField = cells[j].querySelector('.waren_anzahl');

			if (inputField) {
				const currentValue = parseInt(inputField.value);
				const leftValue = parseInt(cells[j - 1].textContent);

				if (currentValue > leftValue) {
					// call a function when value is higher
					return true;
				}
			}
		}
	}
	return false;
}

function changeButtonText(newText, buttonClass) {
	const $button = jQuery(`#${buttonClass}`);

	if ($button.length) {
		$button.text(newText);
	}
}

function change_to_draft() {
	if (checkIfHigher()) {
		changeButtonText('Lieferschein Entwurf anelegen', 'submit_lieferschein_anlegen');
		toastr.error('Lieferschein kann nur noch als Entwurf erstellt werden');
		jQuery('#entwurf').val("true");
	}
	else {
		changeButtonText('Lieferschein anlegen', 'submit_lieferschein_anlegen');
		jQuery('#entwurf').val("false");
	}
}


/*----string kürzen nach x zeichen----*/
function wordwrap(str, cut, width, brk) {
	brk = brk || '<br>';
	width = width || 60;
	cut = cut || false;

	if (!str) { return str; }

	var regex = '.{1,' + width + '}(\\s|$)' + (cut ? '|.{' + width + '}|.+$' : '|\\S+?(\\s|$)');

	return str.match(RegExp(regex, 'g')).join(brk);
}


/*-----------------
	3.  Beiträge Allgemeine Funktionen
-----------------------*/

function get_typ() {
	if ($('#kunde_id').length > 0) return [$('#kunde_id').val(), 'kunde'];
	else if ($('#angebot_id').length > 0) return [$('#angebot_id').val(), 'angebot'];
	else if ($('#abonnement_id').length > 0) return [$('#abonnement_id').val(), 'abonnement'];
	else if ($('#artikel_id').length > 0) return [$('#artikel_id').val(), 'artikel'];
	else if ($('#mahnung_id').length > 0) return [$('#mahnung_id').val(), 'mahnung'];
}

function update_beitraege_html(html) {
	$('.js_beitraege_list').html(html);
}

function set_wysiwyg_value(id, value) {
	$(id).val(value);
	$(id).summernote("code", value);
}

function get_wysiwyg_value(id) {
	return $(id).summernote("code");
}

function set_waehrung_value(id, value) {
	value = value.replace('.', ",");
	$(id).val(value);
	$(id).autoNumeric('set', value);
	$(id).trigger("change");
}

function validate_wyiswyg(val) {
	if ((val == '') || (val == '<p><br></p>')) {
		fehlermeldung('Das Textfeld darf nicht leer sein');
		return false;
	}
	else return true;
}

function set_select2_multi_value(element, values) {
	if (values == null) return;
	var selected = [];

	$(values).each(function (index, value) {
		selected.push(value.mitarbeiter_id);
	});

	$(element).val(selected);
	$(element).trigger('change');

}

function get_bool_as_non_string(string) {
	if (string == 'true') return true;
	else return false;
}

function get_select2_value(element) {
	var text = $(element).find("option:selected").text();
	text = text.replaceAll('\t', '');
	text = text.replaceAll('\n', '');

	return text;
}

function set_select2_value(id, value) {
	$(id).val(value);
	$(id).trigger('change');
}

function reset_select2(id) {
	$(id).val('');
	$(id).select2('val', '');
	$(id).select2();
}

function add_select2_value(element_id, element_key, element_value) {
	var newOption = new Option(element_value, element_key, false, true);
	$(element_id).append(newOption).trigger('change');
}

function select2_reset_options(id, html) {
	$(id+' option').remove();
	$(id).trigger('change');
	$(id).html(html);
	$(id).trigger('change');
}



/*-----------------
	4. Beiträge laden
-----------------------*/

$(document).ready(function () {
	if ($('.js_beitraege_list').length == 0) return;
	beitraege_laden();
});

function beitraege_laden() {

	var typ_obj = get_typ();

	var data = {
		action: 'get_beitrage',
		typ_id: typ_obj[0],
		typ: typ_obj[1],
		disabled: $('.js_beitraege_list').attr('data-disabled')
	};

	$.ajax({
		url: siteurl + "controllers/AJAX.php",
		type: "POST",
		data: data,
		success: function (success) {
			var obj = jQuery.parseJSON(success);
			if (obj.beitraege != null) update_beitraege_html(obj.beitraege_html);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			fehlermeldung();
		}
	});

}

/*-----------------
	5. Beiträge posten
-----------------------*/

$('#js_btn_beitrag_submit').click(function (e) {
	e.preventDefault();
	var val = $('textarea[name="js_beitrag_posten"]').val();
	var valid = validate_wyiswyg(val);
	if (valid == false) return;

	var data = {
		action : 'insert_beitrag',
		typ_id : $(this).attr('data-id'),
		typ    : $(this).attr('data-typ'),
		text   : val
	};

	$.ajax({
		url: siteurl + "controllers/AJAX.php",
		type: "POST",
		data: data,
		success: function (success) {
			var obj = jQuery.parseJSON(success);
			update_beitraege_html(obj.beitraege_html);
			ausgabemeldung('Beitrag wurde erfolgreich gespeichert');
			var typ_obj = get_typ();
			set_wysiwyg_value('#' + typ_obj[0], '');
		},
		error: function (xhr, ajaxOptions, thrownError) {
			fehlermeldung();
		}
	});

});


/*-----------------
	6. Beitrag bearbeiten
-----------------------*/

function get_beitrag(element) {

	var data = {
		action: 'get_beitrag',
		beitrag_id: $(element).attr('data-beitrag-id')
	};

	$.ajax({
		url: siteurl + "controllers/AJAX.php",
		type: "POST",
		data: data,
		success: function (success) {
			var obj = jQuery.parseJSON(success);
			if (obj.result == false) {
				fehlermeldung(obj.message);
			} else {
				set_wysiwyg_value('#wysiwyg_beitrag_bearbeiten', obj.beitrag.text);
				$('#modal_beitrag_bearbeiten_id').val(obj.beitrag.beitrag_id);
				$('#modal_beitrag_bearbeiten').modal('show');
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			fehlermeldung();
		}
	});

}


$('#js_modal_beitrag_bearbeiten_submit').click(function (e) {
	e.preventDefault();
	Locker.lock(true);
	var typ_obj = get_typ();

	var data = {
		action: 'update_beitrag',
		beitrag_id: $('#modal_beitrag_bearbeiten_id').val(),
		typ_id: typ_obj[0],
		typ: typ_obj[1],
		text: $('#wysiwyg_beitrag_bearbeiten').val()
	};

	$.ajax({
		url: siteurl + "controllers/AJAX.php",
		type: "POST",
		data: data,
		success: function (success) {
			var obj = jQuery.parseJSON(success);
			if (obj.result == true) {
				toastr.success('Änderungen erfolgreich gespeichert');
				$('#modal_beitrag_bearbeiten').modal('hide');
				update_beitraege_html(obj.beitraege_html);
			} else {
				fehlermeldung();
			}
			Locker.lock(false);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			fehlermeldung();
		}
	});

});

/*-----------------
	7. Beitrag löschen
-----------------------*/

function delete_beitrag(element) {

	if (confirm("Wollen Sie Ihren Beitrag löschen?") != true) return;

	var typ_obj = get_typ();

	var data = {
		action     : 'delete_beitrag',
		beitrag_id : $(element).attr('data-beitrag-id'),
		typ_id     : typ_obj[0],
		typ        : typ_obj[1]
	};

	$.ajax({
		url: siteurl + "controllers/AJAX.php",
		type: "POST",
		data: data,
		success: function (success) {
			var obj = jQuery.parseJSON(success);
			if (obj.result == true) {
				toastr.success('Beitrag wurde gelöscht');
				update_beitraege_html(obj.beitraege_html);
			} else if (obj.result == false) {
				toastr.error(obj.message);
			} else fehlermeldung();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			fehlermeldung();
		}
	});
}


/*-----------------
	8. Kommentar hinzufügen
-----------------------*/

function insert_beitrag_kommentar(element) {

	$('#modal_kommentar_beitrag_id').val($(element).attr('data-beitrag-id'));
	$('#modal_beitrag_kommentar .modal-title').html('Kommentar hinzufügen');
	$('#modal_kommentar_action').val('insert_kommentar');
	$('#js_modal_beitrag_kommentar_submit').html('Kommentar hinzufügen');
	$('#modal_beitrag_kommentar').modal('show');
}


$('#js_modal_beitrag_kommentar_submit').click(function (e) {
	e.preventDefault();

	var val = $('#wysiwyg_beitrag_kommentar').val();
	var valid = validate_wyiswyg(val);
	if (valid == false) return;


	Locker.lock(true);
	var typ_obj = get_typ();


	var data = {
		action: $('#modal_kommentar_action').val(),
		beitrag_id: $('#modal_kommentar_beitrag_id').val(),
		kommentar_id: $('#modal_kommentar_id').val(),
		typ_id: typ_obj[0],
		typ: typ_obj[1],
		text: val
	};

	$.ajax({
		url: siteurl + "controllers/AJAX.php",
		type: "POST",
		data: data,
		success: function (success) {
			var obj = jQuery.parseJSON(success);
			if (obj.result == false) {
				fehlermeldung();
			} else {
				toastr.success('Änderungen wurden gespeichert');
				$('#modal_beitrag_kommentar').modal('hide');
				update_beitraege_html(obj.beitraege_html);
			}
			Locker.lock(false);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			fehlermeldung();
		}
	});

});


/*-----------------
	9. Kommentar löschen
-----------------------*/

function delete_kommentar(element) {

	if (confirm("Wollen Sie Ihren Kommentar löschen?") != true) return;

	var typ_obj = get_typ();

	var data = {
		action: 'delete_kommentar',
		kommentar_id: $(element).attr('data-kommentar-id'),
		typ_id: typ_obj[0],
		typ: typ_obj[1],

	};

	$.ajax({
		url: siteurl + "controllers/AJAX.php",
		type: "POST",
		data: data,
		success: function (success) {
			var obj = jQuery.parseJSON(success);
			if (obj.result == true) {
				toastr.success('Kommentar wurde gelöscht');
				update_beitraege_html(obj.beitraege_html);
			} else {
				fehlermeldung(obj.message);
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			fehlermeldung();
		}
	});

}


/*-----------------
	10. Kommentar bearbeiten
-----------------------*/

function get_kommentar(element) {

	var data = {
		action: 'get_kommentar',
		kommentar_id: $(element).attr('data-kommentar-id')
	};

	$.ajax({
		url: siteurl + "controllers/AJAX.php",
		type: "POST",
		data: data,
		success: function (success) {
			var obj = jQuery.parseJSON(success);
			if (obj.result == false) {
				fehlermeldung(obj.message);
			} else {
				set_wysiwyg_value('#wysiwyg_beitrag_kommentar', obj.kommentar.text);
				$('#modal_kommentar_id').val(obj.kommentar.kommentar_id);
				$('#modal_beitrag_kommentar .modal-title').html('Kommentar bearbeiten');
				$('#modal_kommentar_action').val('update_kommentar');
				$('#js_modal_beitrag_kommentar_submit').html('Änderungen speichern');
				$('#modal_beitrag_kommentar').modal('show');
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			fehlermeldung();
		}
	});

}



/*-----------------
	12. Vertical Tabs
-----------------------*/

function openCity(evt, cityName) {
	evt.preventDefault();
	// Declare all variables
	var i, tabcontent, tablinks;

	// Get all elements with class="tabcontent" and hide them
	tabcontent = document.getElementsByClassName("tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}

	// Get all elements with class="tablinks" and remove the class "active"
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}

	// Show the current tab, and add an "active" class to the link that opened the tab
	document.getElementById(cityName).style.display = "block";
	evt.currentTarget.className += " active";
}

 


/*-----------------
	13. Löschen von Einträgen	
-----------------------*/

var deleted_id;
var deleted_table;

$(document).ready(function () {
	if ($('.js_delete_entry').length == 0) return;

	$('.js_delete_entry').click(function (e) {
		deleted_id = $(this).attr('data-id');
		deleted_table = $(this).attr('data-table');
	});

	$('#save_modal_delete').click(function (e) {
		Locker.lock(true);
		var data = {
			action    : 'delete_entry',
			id        : deleted_id,
			table     : deleted_table
		};

		$.ajax({
			url: siteurl + "controllers/AJAX.php",
			type: "POST",
			data: data,
			success: function (success) {
				var obj = jQuery.parseJSON(success);
				if (obj.result == "true") {
					location.reload();
				} else if (obj.result == "false") {
					fehlermeldung(obj.message);
				} else {
					fehlermeldung();
				}
				Locker.lock(false);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				toastr.error('Fehler, bitte Administrator kontaktieren');
				Locker.lock(false);
			}
		});
	});
});

/*-----------------
	14. PDF drucken
-----------------------*/

function printPDF() {
	const iframe = document.getElementById('pdf-frame');

	// Zugriff auf das Fensterobjekt des iframe und den Druckdialog auslösen
	if (iframe.contentWindow) {
		iframe.contentWindow.focus(); // Den Fokus auf das iframe legen
		iframe.contentWindow.print(); // Druckdialog auslösen
	} else {
		alert('Das PDF konnte nicht gedruckt werden!');
	}
}