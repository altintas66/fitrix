<?php
	include 'init.php';
	$c_permission->check_user_permission_redirect('RECHNUNGEN_VERWALTEN');

    $c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Quality Hosting Rechnung anlegen', '#')));

	$kunden = $c_kunde->get_qualityhosting_kunden();
	$submitted = false;

	if(isset($_POST['btn_qualityhosting_kunde_submit'])) {
		$result_file_upload = $c_file_upload->upload_file('qualityhosting_csv_datei', $_FILES);
		$submitted = true;
		if($result_file_upload['result'] == true) {
			$rechnungsvorlagen = $c_quality_hosting_csv_rechnung->get_rechnungsvorlagen($kunden, $result_file_upload['dateiname']);
		}
	}

?>
	<?php if($submitted == false) { ?>
		<div class="card">
			<?php $c_html->card_header('CSV Datei hochladen'); ?>
			<div class="card-body">
				<form enctype="multipart/form-data" method="POST" action="">
					<?php 
						$c_form->input_file(
							'CSV Datei hier hochladen', 
							'qualityhosting_csv_datei', 
							'', 
							true
						);
						$c_form->button_submit(
							'btn_qualityhosting_kunde_submit', 
							'hochladen', 
							'btn btn-primary',
							true
						);
					?>
				</form>
			</div>
		</div>
	<?php } ?>

	<?php 
		if((isset($rechnungsvorlagen)) &&  ($rechnungsvorlagen['result'] == false)) {
			$c_helper->__message($rechnungsvorlagen['message'], 'danger');
		} else if((isset($rechnungsvorlagen)) &&  ($rechnungsvorlagen['result'] == true)) { ?>
			<?php foreach($rechnungsvorlagen['rechnungsvorlagen'] AS $reseller_customer_id => $positionen) { ?>
				<div class="row">
					<div class="col-md-12">
						<div class="card card-table">
							<?php $c_html->card_header('Rechnungsvorlag für ('.$reseller_customer_id.') '.$c_kunde->get_firmenname_by_qualityhosting_reseller_customer_id($reseller_customer_id)); ?> 
							<div class="card-body">
								<?php include 'includes/table/table-qualityhosting-rechnungsvorlagen.php'; ?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php 
		}
	?> 


	<?php if($submitted == false) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-table">
					<?php $c_html->card_header('Kunden'); ?> 
					<div class="card-body">
						<?php include 'includes/table/table-qualityhosting-kunden.php'; ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
 
	
<?php
	$c_html->get_footer();
?>	
	
 