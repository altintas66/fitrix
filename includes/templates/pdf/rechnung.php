<?php 
    ob_start();
    global $einstellungen, $helper, $aktive_module; 

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechnung</title>
    <?php include 'includes/css.php'; ?>
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

    <?php if($rechnung['positionen'] != null) { ?>
        <table class="items">
            <?php 
                $c_table_helper->get_rechnung_table_positionen($rechnung['positionen'], false);
            ?>
        </table>

        <table class="width-100 totals">
            <tr class="total-row first-row">
                <td class="text-right">Nettosumme</td>
                <td class="text-right">
                    <?php echo $c_html->waehrung($rechnung['gesamt_netto']); ?>
                </td>
            </tr>
            <tr class="total-row">
                <td class="text-right">+ MwSt (<?php echo $rechnung['mwst_satz']; ?>%)</td>
                <td class="text-right">
                    <?php 
                        echo $c_html->waehrung($rechnung['gesamt_mwst']); 
                    ?>
                </td>
            </tr>
            <tr class="total-row">
                <td class="text-right">Zu zahlender Betrag</td>
                <td class="text-right">
                    <?php 
                        echo $c_html->waehrung($rechnung['gesamt_brutto']);
                    ?>
                </td>
            </tr>
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