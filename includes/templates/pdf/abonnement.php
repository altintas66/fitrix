<?php 
    ob_start();
    global $einstellungen; 
    $netto_gesamt = 0;
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonnement</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        } 
        .invoice-header {
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .company-details {
            text-align: right;
        }
        .company-details div {
            font-size: 14px;
            line-height: 20px;
        }
        .company-details h2 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #333;
            line-height: 34px;
        }
        .invoice-title {
            font-size: 29px;
            font-weight: 500;
            color: #333;
            margin: 0;
        }
        .invoice-info {
            margin-top: 10px;
        }
        .invoice-info div {
            font-size: 14px;
            color: #333;
            line-height: 24px;
        }
        .billing-details, .items {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .billing-details th, .billing-details td {
            padding: 10px 10px 10px 0;
            text-align: left;
        }
        .items th, .items td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .billing-details td {
            font-size: 14px;
            line-height: 24px;
            font-weight: normal;
            color: #333;
        }
        .items th {
            font-size: 14px;
            font-weight: bold;
            border-width: 0 0 thin 0;
            border-color: #333
        }
        .items td {
            font-size: 14px;
            color: #333;
            border-width: 0;
        }
        .items tbody tr:nth-child(even) {
            background: #f6f8f9; 
        }
        .items .total-row {
            font-weight: bold;
            background: #fff!important;
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #333;
        }
        .footer-zusatz-text {
            margin-top: 30px;
        }
        .logo {
            width: 160px;
            margin-bottom: 30px;
        }
        .items tbody tr td ul li {
            font-size: 14px;
            line-height: 20px;
        }
        .invoice-info-agentur {
            margin-bottom: 20px;
        }
        .invoice-info-agentur u {
            font-size: 12px!important;
        }
    </style>
</head>
<body>

<div class="invoice-container">
    <div class="invoice-header">
        <h1 class="invoice-title" style="float: left;">Abonnement</h1>
        <div class="company-details">
            <img class="logo" src="https:<?php echo $c_einstellungen->get_foto_url($abonnement['agentur_logo']); ?>" alt="Logo" />
            <h2><?php echo $abonnement['agentur_firmen_name']; ?></h2>
            <div><?php echo $abonnement['agentur_strasse']; ?></div>
            <div>
                <?php echo $abonnement['agentur_plz']; ?>
                <?php echo $abonnement['agentur_ort']; ?>
            </div>
            <div><?php echo $abonnement['agentur_email']; ?></div>
            <div>Tel. <?php echo $abonnement['agentur_telefon']; ?></div>
        </div>
    </div>

    <div class="invoice-info">
        <div class="invoice-info-agentur">
            <u>
                <?php echo $abonnement['agentur_firmen_name']; ?>, 
                <?php echo $abonnement['agentur_strasse']; ?>, 
                <?php echo $abonnement['agentur_plz']; ?> <?php echo $abonnement['agentur_ort']; ?>
            </u>
        </div>
        <div><strong><?php echo $abonnement['kunde_firmen_name']; ?></strong></div>
        <div>
            <?php echo $abonnement['kunde_strasse']; ?>
        </div>
        <div>
            <?php echo $abonnement['kunde_plz']; ?>
            <?php echo $abonnement['kunde_ort']; ?>
        </div>
    </div>

    <!-- Billing Details -->
    <table class="billing-details">
        <tr>
            <td>
                Abonnement-Nummer: <?php echo $abonnement['abonnementnummer']; ?> 
            </td>
            <td>
                Zuletzt bearbeitet: <?php echo $c_helper->german_date($abonnement['bearbeitet_am'], false); ?> 
            </td>
        </tr>
    </table>
    <?php if($abonnement['vertraege']) { ?>
        <table class="items">
                <tr>
                    <th>Verträge</th>
                    <th>Vertragdetails</th>
                    <th>Menge</th>
                    <th>Laufende<br>Kosten</th>
                    <th>Status</th>
                </tr>
            <tbody>
                <?php foreach($abonnement['vertraege'] AS $vertrag) {    
                ?>
                    <tr>
                        <td>
                            <?php echo $vertrag['artikel_name']; ?>
                        </td>
                        <td>
                            <?php echo $this->helper->escape_html($vertrag['artikel_beschreibung']); ?>
                        </td>
                        <td>
                            <?php echo $vertrag['artikel_menge']; ?>
                            <?php echo $vertrag['einheit_bezeichnung']; ?>
                        </td>
                        <td>
                            <?php echo $c_html->waehrung($vertrag['artikel_preis']); ?><br>
                            <?php echo $vertrag['zyklus_bezeichnung']; ?>
                        </td>
                        <td>
                            <?php echo $vertrag['status']; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

    <!-- Footer -->
    <div class="footer">
        <?php 
            //echo $c_helper->clean_wysiwyg_html($abonnement['bedingungen']); 
        ?>
    </div>
</div>

</body>
</html>


<?php
$html = ob_get_clean();
?>