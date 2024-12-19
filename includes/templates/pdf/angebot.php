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
    <title>Angebot</title>
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
        <h1 class="invoice-title" style="float: left;">Angebot</h1>
        <div class="company-details">
            <img class="logo" src="https:<?php echo $c_einstellungen->get_foto_url($angebot['agentur_logo']); ?>" alt="Logo" />
            <h2><?php echo $angebot['agentur_firmen_name']; ?></h2>
            <div><?php echo $angebot['agentur_strasse']; ?></div>
            <div>
                <?php echo $angebot['agentur_plz']; ?>
                <?php echo $angebot['agentur_ort']; ?>
            </div>
            <div><?php echo $angebot['agentur_email']; ?></div>
            <div>Tel. <?php echo $angebot['agentur_telefon']; ?></div>
        </div>
    </div>

    <div class="invoice-info">
        <div class="invoice-info-agentur">
            <u>
                <?php echo $angebot['agentur_firmen_name']; ?>, 
                <?php echo $angebot['agentur_strasse']; ?>, 
                <?php echo $angebot['agentur_plz']; ?> <?php echo $angebot['agentur_ort']; ?>
            </u>
        </div>
        <div><strong><?php echo $angebot['kunde_firmen_name']; ?></strong></div>
        <div>
            <?php echo $angebot['kunde_strasse']; ?>
        </div>
        <div>
            <?php echo $angebot['kunde_plz']; ?>
            <?php echo $angebot['kunde_ort']; ?>
        </div>
    </div>

    <!-- Billing Details -->
    <table class="billing-details">
        <tr>
            <td>
                Angebotsdatum: <?php echo $c_helper->german_date_no_time($angebot['angebotsdatum']); ?> <br>
                Gültig bis: <?php echo $c_helper->german_date_no_time($angebot['faellig_am']); ?>
            </td>
            <td>
                Angebotsnummer: ddd <br>
                Kundennummer: ddd
            </td>
        </tr>
    </table>
    <?php if($angebot['positionen']) { ?>
        <table class="items">
                <tr>
                    <th>Pos</th>
                    <th>Angebotsdetails</th>
                    <th>Menge</th>
                    <th>Laufende<br>Kosten</th>
                    <th>Einmalige<br>Kosten</th>
                </tr>
            <tbody>
                <?php foreach($angebot['positionen'] AS $position) { 
                    $netto_gesamt += (intval($position['menge']) * floatval($position['netto_preis']));
                    $netto_gesamt += floatval($position['einrichtungsgebuehr']);    
                ?>
                    <tr>
                        <td>
                            <?php echo $position['artikel_name']; ?>
                        </td>
                        <td>
                            <?php echo $this->helper->escape_html($position['beschreibung']); ?>
                        </td>
                        <td>
                            <?php echo $position['menge']; ?>
                            <?php echo $position['einheit']; ?>
                        </td>
                        <td>
                            <?php echo $c_html->waehrung($position['netto_preis']); ?><br>
                            <small><?php echo $position['zyklus_bezeichnung']; ?></small>
                        </td>
                        <td>
                            <?php echo $c_html->waehrung($position['einrichtungsgebuehr']); ?>
                        </td>
                    </tr>
                <?php } ?>
                
                <tr class="total-row">
                    <td></td>
                    <td colspan="2" style="text-align:right;">Netto</td>
                    <td colspan="2" style="text-align:right;">
                        <?php echo $c_html->waehrung($netto_gesamt); ?>
                    </td>
                </tr>
                <tr class="total-row">
                    <td></td>
                    <td colspan="2" style="text-align:right;">MwSt (<?php echo $angebot['mwst_satz']; ?>%)</td>
                    <td colspan="2" style="text-align:right;">
                        <?php 
                            $mwst = $c_helper->get_mwst($netto_gesamt, $angebot['mwst_satz']);
                            echo $c_html->waehrung($mwst); 
                        ?>
                    </td> 
                </tr>
                <tr class="total-row">
                    <td></td>
                    <td colspan="2" style="text-align:right;">Gesamt</td>
                    <td colspan="2" style="text-align:right;">
                        <?php 
                            $brutto = $c_helper->get_brutto($netto_gesamt, $angebot['mwst_satz']); 
                            echo $c_html->waehrung($brutto);
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php } ?>

    <!-- Footer -->
    <div class="footer">
        <?php 
            echo $c_helper->clean_wysiwyg_html($angebot['bedingungen']); 
        ?>

        <?php if($angebot['zusatz_text'] != '') { ?>
            <div class="footer-zusatz-text">
                <?php echo $c_helper->clean_wysiwyg_html($angebot['zusatz_text']); ?>
            </div>
        <?php } ?>

    </div>
</div>

</body>
</html>


<?php
$html = ob_get_clean();
?>