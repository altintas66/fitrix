<?php 
    ob_start();
    global $einstellungen, $aktive_module, $c_angebot; 
    $netto_gesamt = $c_angebot->get_angebot_gesamt_netto_summe($angebot['positionen']);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angebot</title>
    <?php include 'includes/css.php'; ?>
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
                Angebotsnummer: <?php echo $angebot['angebotsnummer']; ?><br>
                Kundennummer: ddd
            </td>
        </tr>
    </table>
    <?php if($angebot['positionen']) { ?>


                <table class="items">
                    <?php 
                        $c_table_helper->get_angebot_table_positionen($angebot['positionen'], false);
                    ?>
                </table>

                <table>
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