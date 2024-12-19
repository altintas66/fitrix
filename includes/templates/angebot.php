    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="6">
                    <table>
                        <tr>
                            <td class="title">
                                <img
                                    src="<?php echo $c_einstellungen->get_foto_url($angebot['agentur_logo']); ?>"
                                    style="width: 100%; max-width: 200px"
                                />
                            </td>

                            <td class="text-right">
                                Angebotsnummer : <?php echo $angebot['angebotsnummer']; ?><br />
                                Angebotsdatum: <?php echo $this->helper->german_date_no_time($angebot['angebotsdatum']); ?><br />
                                Angelegt am: <?php echo $this->helper->german_date($angebot['angelegt_am']); ?>
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
                                <?php echo $angebot['kunde_firmen_name']; ?><br />
                                <?php echo $angebot['kunde_strasse']; ?><br />
                                <?php echo $angebot['kunde_plz']; ?>
                                <?php echo $angebot['kunde_ort']; ?>
                            </td>

                            <td class="text-right">
                                Steuernummer: <?php echo $angebot['agentur_steuernummer']; ?><br />
                                Umsatzsteuer-ID: <?php echo $angebot['agentur_umsatzsteuer_id']; ?> <br />
                                Bank: <?php echo $angebot['agentur_bank']; ?><br/>
                                IBAN: <?php echo $angebot['agentur_iban']; ?> <br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

           
            <?php if($angebot['positionen'] != null) { ?>
                <tr class="heading">
                    <td>Pos</td>
                    <td>Details</td>
                    <td>Menge</td>
                    <td>Laufende<br>Kosten</td>
                    <td>Einmalige<br>Kosten</td>
                    <td></td>
                </tr>

                <?php foreach($angebot['positionen'] AS $position) { 
                    $netto_gesamt += (intval($position['menge']) * floatval($position['netto_preis']));
                    $netto_gesamt += floatval($position['einrichtungsgebuehr']);
                ?>
                    <tr class="item">
                        <td>
                            <?php echo $position['artikel_name']; ?>
                        </td>
                        <td>
                            <?php echo $position['beschreibung']; ?>
                        </td>
                        <td>
                            <?php echo $position['menge']; ?>
                            <?php echo $position['einheit']; ?>
                        </td>
                        <td>
                            <?php echo $this->waehrung($position['netto_preis']); ?><br>
                            <span class="table-data-small"><?php echo $position['zyklus_bezeichnung']; ?></span>
                        </td>
                        <td>
                            <?php echo $this->waehrung($position['einrichtungsgebuehr']); ?>
                        </td>
                        <td>
                            <div class="button-row">
                                <?php 
                                    $c_button->button_angebot_position_bearbeiten(
                                        $position['angebot_position_id']
                                    );
                                    $c_button->button_angebot_position_loeschen(
                                        $position['angebot_position_id'] 
                                    );
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>

            <?php } ?>

            

            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right bold big-font">Gesamt: <?php echo $this->waehrung($netto_gesamt); ?></td>
            </tr>
        </table>
    </div>