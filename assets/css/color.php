<?php 
    

    $mode = $_GET['mode'];

    if($mode == 'dark') {
        $body_bg_color = '#181f39';
        $color1 = '#181f39';
        $text_color = '#fff';
        $color2 = '#1e2746';
        $bg_color_modal_card = '#1e2746';
        $border = '#333a54';
        $thead_bg = '#181f39';
        $table_tr_bg = 'rgba(235, 235, 235, 0.1);';
        $input_bg_color = '#181f39';
        $input_border_color = '#333a54';
        $table_suchergebniss_bg_color = '#ec671a';
        $tabs_nav_bg_color = '#ec671a';
    } else {
        $body_bg_color = '#ededed';
        $color1 = '#F9FAFB';
        $text_color = '#333';
        $color2 = '#212326';
        $bg_color_modal_card = '#fff';
        $border = '#F9FAFB';
        $thead_bg = '#f0f4f7';
        $table_tr_bg = '#fff';
        $input_bg_color = '#fcfcfc';
        $input_border_color = '#E6E6E6';
        $table_suchergebniss_bg_color = '#ffc38d';
        $tabs_nav_bg_color = '#ec671a';
    }

    header("Content-type: text/css"); 
?>


body {
    background-color: <?php echo $body_bg_color; ?>;
    color: <?php echo $text_color; ?>;
}

.sidebar {
    background-color: #1e2746;
}

.sidebar-menu > ul > li > a {
	color: <?php echo $text_color; ?>;
    font-size: 18px;
}

.card {
    border: 1px solid <?php echo $border; ?>;
}


.modal-header,
.card .card-header {
    background-color: <?php echo $bg_color_modal_card; ?>;
    color: <?php echo $text_color; ?>;
    border-bottom: 1px solid <?php echo $border; ?>;
}

.card .card-body,
.modal .modal-body {
    background-color: <?php echo $bg_color_modal_card; ?>;
}

.card .card-body a.link {
    color: <?php echo $text_color; ?>;
    text-decoration: underline;
}

.card .card-body a.link:hover {
    text-decoration: none;
}

.header {
	background: #fff;
	border-bottom: 1px solid #f0f0f0;
}

.page-title,
.page-header .breadcrumb a {
    color: <?php echo $text_color; ?>;
}

.table tr td,
.table tr th {
    color: <?php echo $text_color; ?>;
}

.table thead {
	border-bottom: 1px solid <?php echo $border; ?>;
    background-color: <?php echo $thead_bg; ?>
}

.table tfoot { 
    background-color: <?php echo $thead_bg; ?>
}

.digital-clock {
    background: linear-gradient(90deg, #333, #333);
    border: 2px solid #333;
}


.card-footer {
	background-color: #fff;
	border-top: 1px solid #e6e6e6;
}

.card-table .table td, .card-table .table th { 
    border-top: 1px solid <?php echo $border; ?>;
}

.select2-container--default .select2-selection--single{
    background-color: <?php echo $color1; ?>;
    border-radius: 3px;
}

.select2-container .select2-selection--single {
	border: 1px solid <?php echo $border; ?>;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
	border-color: <?php echo $border; ?> transparent transparent;
}

.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
	border-color: transparent transparent <?php $border; ?>;
}

.select2-dropdown{
    background-color: <?php echo $color1; ?>;
    border:1px solid <?php echo $border; ?>;
}

.select2-container--default .select2-selection--single{
    border:1px solid <?php echo $border; ?>;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
	color: <?php echo $text_color; ?>;
}

.bg-success,
.badge-success {
	color: <?php echo $text_color; ?>;
}


span.required {
	color: #A7232B !important;
}

.form-control {
    background-color: <?php echo $input_bg_color; ?>;
    border: 1px solid <?php echo $input_border_color?>;
    color: <?php echo $text_color; ?>;
    border-radius: 5px!important;
}

.form-control:disabled,
.note-editor.note-frame .note-editing-area .note-editable {
    background-color: <?php echo $input_bg_color; ?>;
}

.form-control:focus  {
    background-color: #FFFFF5!important;

}

.ui-tabs .ui-tabs-nav .ui-tabs-anchor {
    background-color: #f7f7f7;
    color: #333;
}

.sticky-footer {
    background: <?php echo $color1; ?>;
    box-shadow: 7px 7px 30px rgba(0, 0, 0, .4)
}

.beitrag-area {
	background-color: rgba(255,255,255,0.3);
}

.text-muted {
    color: #757575 !important;
}

.text-secondary {
    color: #b8bdc1!important;
}

.tab button {
	color: <?php echo $text_color; ?>;
}

.tabs_header {
	background-color: rgba(0, 0, 0, .03);
}

.table-files {
	background-color: #fff;
}

ul.tab {
	border: 1px solid <?php echo $border; ?>;
	background-color: <?php echo $bg_color_modal_card; ?>;
}

ul.tab li { 
	border-top: 1px solid #ddd;
}

.select2-container--default .select2-selection--multiple {
	border: 1px solid #ddd;
}

.select2-container--default .select2-selection--multiple{
    background-color: <?php echo $color1; ?>;
    border: 1px solid #333a54;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice{
    background-color: <?php echo $color1; ?>; 
    border: 1px solid #333a54;
}

.user-header {
    background-color: #f9f9f9;
    display: flex;
    padding: 10px 15px;
}

.user-menu .dropdown-menu .dropdown-item {
    border-top: 1px solid #e3e3e3;
}

.user-menu .dropdown-menu .dropdown-item:hover {
	color: <?php echo $text_color; ?>;
    background: #e2a606;
}

.dropdown-menu {
	border: 1px solid rgba(0, 0, 0, 0.1);
	background-color: #fff;
}

.dropdown-item.active, .dropdown-item:active {
    background-color: #e2a606;
}

.navbar-nav .open .dropdown-menu {
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
	background-color: #fff;
}

.noti-details {
	color: #989c9e;
}

.noti-title {
	color: #333;
}

.notifications ul.notification-list > li a:hover {
	background-color: #fafafa;
}

.notifications ul.notification-list > li{
	border-bottom: 1px solid #f5f5f5;
}

.topnav-dropdown-footer {
	border-top: 1px solid #eee;
}

.topnav-dropdown-footer a {
	color: #333;
}

.richText{
    background-color: #fafafa;
    border: #efefef solid 1px;
}

.richText .richText-toolbar ul li a {
    border-right: #efefef solid 1px;
}

.richText .richText-editor{
    background-color: #fff;
    border-left: #fff solid 2px;
}

.modal-content{
    background-color: #fff;
}

.sidebar .sidebar-menu > ul > li > a span {
    color: #fff;
}

.table-striped tbody tr {
	background-color: <?php echo $table_tr_bg; ?>!important;
}


.a_link {
	color: <?php echo $text_color; ?>;
}

[class^=note-icon]:before, [class*=" note-icon"]:before {
    color: <?php echo $text_color; ?>!important;
}

.note-editor.note-frame .note-statusbar,
.note-editor .note-toolbar {
	background-color: <?php echo $color1; ?>;
}

.note-editor.note-frame {
	border: 1px solid <?php echo $border; ?>;
	box-shadow: inherit;
}

table tr td.highlight {
	background-color: <?php echo $table_suchergebniss_bg_color; ?>;
}

.ui-tabs .ui-tabs-nav li.ui-tabs-active a {
    background-color: <?php echo $tabs_nav_bg_color; ?>!important;
}