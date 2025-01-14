
<?php 
    $netto_gesamt = 0;

?>

<div class="invoice-box">
        
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td class="title">
                    <img
                        src="<?php echo $c_einstellungen->get_foto_url($rechnung['agentur_logo']); ?>"
                        style="width: 100%; max-width: 200px"
                    />
                </td>

                <td class="text-right">
                    Rechnungsnummer : <?php echo $rechnung['rechnungsnummer']; ?><br />
                    Rechnungsdatum: <?php echo $this->helper->german_date_no_time($rechnung['rechnungsdatum']); ?><br />
                    Angelegt am: <?php echo $this->helper->german_date($rechnung['angelegt_am']); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $rechnung['rg_kunde_firmen_name']; ?><br />
                    <?php echo $rechnung['rg_kunde_strasse']; ?><br />
                    <?php echo $rechnung['rg_kunde_plz']; ?>
                    <?php echo $rechnung['rg_kunde_ort']; ?>
                </td>

                <td class="text-right">
                    Steuernummer: <?php echo $rechnung['agentur_steuernummer']; ?><br />
                    Umsatzsteuer-ID: <?php echo $rechnung['agentur_umsatzsteuer_id']; ?> <br />
                    Bank: <?php echo $rechnung['agentur_bank']; ?><br/>
                    IBAN: <?php echo $rechnung['agentur_iban']; ?> <br />
                </td>
            </tr>
        </table>
        
        <table cellpadding="0" cellspacing="0" class="table_positionen">


            <?php if($rechnung['positionen'] != null) { ?>
                <?php 
                    $c_table_helper->get_rechnung_table_positionen($rechnung['positionen'], true);    
                ?>
            <?php } ?>

            <?php 
                $mwst   = $this->helper->get_mwst($netto_gesamt, $rechnung['mwst_satz']);
                $brutto = $this->helper->get_brutto($netto_gesamt, $rechnung['mwst_satz']);
            ?>
        </table>

        <table cellpadding="0" cellspacing="0">
            <tr class="total total-first">
                <td class="text-right bold big-font">
                    Netto: <?php echo $this->waehrung($rechnung['gesamt_netto']); ?>
                </td>
            </tr>
            <tr class="total">
                <td class="text-right bold big-font">
                    MwSt.: <?php echo $this->waehrung($rechnung['gesamt_mwst']); ?>
                </td>
            </tr>
            <tr class="total">
                <td class="text-right bold big-font">
                    Brutto: <?php echo $this->waehrung($rechnung['gesamt_brutto']); ?>
                </td>
            </tr>
        </table>

    </div>


    