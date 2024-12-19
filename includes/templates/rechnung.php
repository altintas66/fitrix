
<?php 
    $netto_gesamt = 0;
?>

<div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="6">
                    <table>
                        <tr>
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
                    </table>
                </td>
            </tr>


            <tr class="information">
                <td colspan="6">
                    <table>
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
                </td>
            </tr>

           
            <?php if($rechnung['positionen'] != null) { ?>
                <tr class="heading">
                    <td>Leistung/Artikel</td>
                    <td>Beschreibung</td>
                    <td>Menge</td>
                    <td>E-Preis</td>
                    <td>G-Preis</td>
                    <td></td>
                </tr>

                <?php foreach($rechnung['positionen'] AS $position) { 
                    $g_preis = (intval($position['artikel_menge']) * floatval($position['artikel_preis']));
                ?>
                    <tr class="item">
                        <td>
                            <?php echo $position['artikel_name']; ?>
                        </td>
                        <td>
                            <?php echo $position['artikel_beschreibung']; ?>
                        </td>
                        <td>
                            <?php echo $position['artikel_menge']; ?>
                            <?php echo $position['artikel_einheit']; ?>
                        </td>
                        <td>
                            <?php echo $this->waehrung($position['artikel_preis']); ?> <br>
                            <span class="table-data-small"><?php echo $position['artikel_zyklus']; ?></span>
                        </td>
                        <td>
                            <?php echo $this->waehrung($g_preis); ?>
                        </td>
                        <td>
                            <div class="button-row">
                                <?php 
                                    $c_button->button_rechnung_position_bearbeiten(
                                        $position['rechnung_position_id']
                                    );
                                    $c_button->button_rechnung_position_loeschen(
                                        $position['rechnung_position_id']
                                    );
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>

            <?php } ?>

            <?php 
                $mwst   = $this->helper->get_mwst($netto_gesamt, $rechnung['mwst_satz']);
                $brutto = $this->helper->get_brutto($netto_gesamt, $rechnung['mwst_satz']);
            ?>

            

            <tr class="total total-first">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right bold big-font">
                    Netto: <?php echo $this->waehrung($rechnung['gesamt_netto']); ?>
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right bold big-font">
                    MwSt.: <?php echo $this->waehrung($rechnung['gesamt_mwst']); ?>
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right bold big-font">
                    Brutto: <?php echo $this->waehrung($rechnung['gesamt_brutto']); ?>
                </td>
            </tr>
        </table>
    </div>


    