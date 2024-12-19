


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
                    <?php foreach($positionen AS $buff) { ?>
                        <tr>
                            <td class="js_qhr_artikelname">
                                <?php echo $buff['artikelname']; ?>
                            </td>
                            <td class="js_qhr_anzahl">
                                <?php echo $buff['anzahl']; ?>
                            </td>
                            <td class="js_qhr_preis" data-preis="<?php echo $buff['preis']; ?>">
                                <?php echo $c_html->waehrung($buff['preis']); ?>
                            </td>
                            <td>
                                <?php echo $c_html->waehrung($buff['total']); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfooter>
                    <tr>
                        <td>
                            <a class="btn btn-sm btn-success">Rechnung anlegen</a>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
			    </tfooter>
            </table>
        </div>
  