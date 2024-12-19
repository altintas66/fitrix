    <?php if(NULL != $kunden) { ?>
        <div class="table-responsive">
            <table class="table table-striped table-center">
                <?php 
                    $c_html->table_header(array(
                        array('title' => 'Logo'),
                        array('title' => 'Firmenname'),
                        array('title' => 'Anzahl Rechnungen'),
                        array('title' => 'Gesamt Umsatz'),
                        array('title' => 'Gesamt Einnahmen'),
                        array('title' => 'Offene Rechnungen'),
                    ));
                ?>
                <tbody>
                    <?php foreach($kunden AS $buff) { 
                        $statistik = $c_rechnung->get_kunden_statistik($buff['kunde_id']);
                    ?>
                        <tr>
                            <td>
                                <?php echo $c_table_helper->get_kunde_logo($buff); ?>
                            </td>
                            <td>
                                <?php echo $buff['firmen_name']; ?> 
                            </td>
                            <td>
                                <?php echo $statistik['alle_rechnungen']; ?>
                            </td>
                            <td>
                                <?php echo $c_html->waehrung($statistik['gesamt_umsatz']); ?>
                            </td>
                            <td>
                                <?php echo $c_html->waehrung($statistik['gesamt_einnahmen']); ?>
                            </td>
                            <td>
                                <?php echo $statistik['offene_rechnungen']; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>