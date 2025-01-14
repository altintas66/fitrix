<div class="table-responsive">
    <table class="table table-striped table-center">
        <?php 
            $this->html->table_header(array(
                array('title' => 'Rechnungsnummer'),
                array('title' => 'Gesamt (brutto)'),
                array('title' => 'Link zur Rechnung'),
                array('title' => 'Der Rechnung hinzufügen')
            ));
        ?>
        <tbody class="js_table_quality_hosting_rechnungen">
        </tbody>
        <tfooter>
            <tr>
                <td>
                    <a class="btn text-white btn-sm btn-success js_qualityhost_rechnung_neue_rechnung_anlegen ">neue Rechnung anlegen</a>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
		</tfooter>
    </table>
</div>