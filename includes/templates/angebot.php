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
        </table>

           
        <table>
            <?php 
                if($angebot['positionen'] != null) { 
                    $c_table_helper->get_angebot_table_positionen($angebot['positionen'], true);
                }
                
            ?>
        </table>
 
        <table>
            <tr class="total">
                <td class="text-right bold big-font">
                    Gesamt: <?php echo $this->waehrung($c_angebot->get_angebot_gesamt_netto_summe($angebot['positionen'])); ?>
                </td>
            </tr>
        </table>

    </div>