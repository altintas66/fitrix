


        <div class="table-responsive">
            <table class="table table-striped table-center">
                <?php 
                    $c_html->table_header(array(
                        array('title' => 'Artikelname'),
                        array('title' => 'Anzahl'),
                        array('title' => 'Preis'),
                        array('title' => 'Total')
                    ));
                ?>
                <tbody>
                    <?php 
                        foreach($positionen AS $buff) { 
                        $preis = $c_rechnung_position->berechne_preis_aus_einkaufspreis($buff['preis']);
                        $total = $preis * $buff['anzahl'];
                    ?>
                        <tr class="<?php echo $reseller_customer_id; ?>">
                            <td class="js_qhr_csv_dateiname" style="display: none;">
                                <?php echo $rechnungsvorlagen['dateiname']; ?>
                            </td>
                            <td class="js_qhr_artikelname">
                                <?php echo $buff['artikelname']; ?>
                            </td>
                            <td class="js_qhr_anzahl">
                                <?php echo $buff['anzahl']; ?>
                            </td>
                            <td class="js_qhr_preis" data-preis="<?php echo $buff['preis']; ?>">
                                <?php echo $c_html->waehrung($preis); ?>
                            </td>
                            <td>
                                <?php echo $c_html->waehrung($total); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfooter>
                    <tr>
                        <td>
                            <a class="btn text-white btn-sm btn-success js_qualityhost_rechnung_anlegen " data-id ="<?php echo $reseller_customer_id ; ?>">Rechnung anlegen</a>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
			    </tfooter>
            </table>
        </div>
  