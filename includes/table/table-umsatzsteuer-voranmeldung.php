   
    
    <div class="table-responsive">
		<table class="table table-striped table-center">
			<?php 
                $c_html->table_header(array(
					array('title' => 'Bemessungsgrundlage ohne Umsatzsteuer (Euro)'),
					array('title' => 'ohne Umsatzsteuer volle EUR (Elster NR 81)'),
					array('title' => 'Steuer')
                ));
            ?>
			<tbody>
                <tr>
                    <td>24 Steuerfreie Umsätze ohne Vorsteuerabzug</td>
                    <td><b>800,00 €</b><br>(48)</td>
                    <td></td>
                </tr>
                <tr>
                    <td>25 Steuerpflichtige Umsätze</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>26 zum Steuersatz von 19 %</td>
                    <td><b><?php echo $c_html->waehrung($gesamt_netto) ?></b><br>(81)</td>
                    <td><b><?php echo $c_html->waehrung($gesamt_mwst) ?></b></td>
                </tr>
                <tr>
                    <td>28 zu anderen Steuersätzen</td>
                    <td><b>0,00€</b><br>(35)</td>
                    <td><b>0,00€</b><br>(36)</td>
                </tr>
                <tr>
                    <td>53 Vorsteuerbeträge aus Rechnungen von anderen Unternehmern</td>
                    <td></td>
                    <td><b>0,00€</b><br>(66)</td>
                </tr>
                <tr>
                    <td>64 Umsatzsteuer-Vorauszahlung / Überschuss (Steuer)</td>
                    <td></td>
                    <td><b><?php echo $c_html->waehrung($gesamt_mwst) ?></b></td>
                </tr>
            </tbody>
		</table>
	</div>