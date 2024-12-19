<?php 
    ob_start();
    global $einstellungen; 
    global $helper;
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechnung</title>
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
            font-size: 13px;
            line-height: 20px;
        }
        .invoice-top-details {
            margin-top: 20px;
            font-size: 13px;
            line-height: 20px;
            text-align: right;
        }
        .company-details h2 {
            margin: 0 0 10px 0;
            font-size: 13px;
            color: #333;
            line-height: 20px;
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
        .items .first-row td{
            padding-top: 30px;
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
        <h1 class="invoice-title" style="float: left;">Rechnung</h1>
        <div class="company-details">
            <img class="logo" src="https:<?php echo $c_einstellungen->get_foto_url($rechnung['agentur_logo']); ?>" alt="Logo" />
            <h2><?php echo $rechnung['agentur_firmen_name']; ?></h2>
        </div>
        <div class="invoice-top-details">
            Rechnungsnummer: <?php echo $rechnung['rechnungsnummer']; ?><br>
            Rechnungsdatum: <?php echo $c_helper->german_date_no_time($rechnung['rechnungsdatum']); ?> <br>
            Gültig bis: <?php echo $c_helper->german_date_no_time($rechnung['faellig_am']); ?>
        </div>
    </div>

    <div class="invoice-info">
        <div class="invoice-info-agentur">
            <u>
                <?php echo $rechnung['agentur_firmen_name_kurz']; ?>, 
                <?php echo $rechnung['agentur_strasse']; ?>, 
                <?php echo $rechnung['agentur_plz']; ?> <?php echo $rechnung['agentur_ort']; ?>
            </u>
        </div>
        <div><strong><?php echo $rechnung['rg_kunde_firmen_name']; ?></strong></div>
        <div>
            <?php echo $rechnung['rg_kunde_strasse']; ?>
        </div>
        <div>
            <?php echo $rechnung['rg_kunde_plz']; ?>
            <?php echo $rechnung['rg_kunde_ort']; ?>
        </div>
    </div>
    <?php if($rechnung['positionen'] != null) { 
        ?>
        <table class="items">
                <tr>
                    <th>Leistung/Artikel</th>
                    <th>Beschreibung</th>
                    <th>Menge</th>
                    <th>E-Preis</th>
                    <th>G-Preis</th>
                </tr>
            <tbody>
                <?php foreach($rechnung['positionen'] AS $position) { 
                    $preis_gesamt = (intval($position['artikel_menge']) * floatval($position['artikel_preis']));
                ?>
                    <tr>
                        <td>
                            <?php echo $position['artikel_name']; ?>
                        </td>
                        <td>
                            <?php echo $this->helper->escape_html($position['artikel_beschreibung']); ?>
                        </td>
                        <td>
                            <?php echo $position['artikel_menge']; ?>
                            <?php echo $position['artikel_einheit']; ?>
                        </td>
                        <td>
                            <?php echo $c_html->waehrung($position['artikel_preis']); ?><br>
                            <small><?php echo $position['artikel_zyklus']; ?></small>
                        </td>
                        <td>
                            <?php echo $c_html->waehrung($preis_gesamt); ?>
                        </td>
                    </tr>
                <?php } ?>
  
                <tr class="total-row first-row">
                    <td></td>
                    <td colspan="2" style="text-align:right;">Netto</td>
                    <td colspan="2" style="text-align:right;">
                        <?php echo $c_html->waehrung($rechnung['gesamt_netto']); ?>
                    </td>
                </tr>
                <tr class="total-row">
                    <td></td>
                    <td colspan="2" style="text-align:right;">MwSt (<?php echo $rechnung['mwst_satz']; ?>%)</td>
                    <td colspan="2" style="text-align:right;">
                        <?php 
                            echo $c_html->waehrung($rechnung['gesamt_mwst']); 
                        ?>
                    </td>
                </tr>
                <tr class="total-row">
                    <td></td>
                    <td colspan="2" style="text-align:right;">Gesamt</td>
                    <td colspan="2" style="text-align:right;">
                        <?php 
                            echo $c_html->waehrung($rechnung['gesamt_brutto']);
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php } ?>

    <!-- Footer -->
    <div class="footer">
        <?php 
            echo $c_helper->clean_wysiwyg_html($rechnung['bedingungen']); 
        ?>

        <?php if($rechnung['zusatz_text'] != '') { ?>
            <div class="footer-zusatz-text">
                <?php echo $c_helper->clean_wysiwyg_html($rechnung['zusatz_text']); ?>
            </div>
        <?php } ?>

    </div>
</div>

</body>
</html>


<?php
$html = ob_get_clean();
?>