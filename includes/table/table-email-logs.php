
<div class="table-responsive">
    <table class="table table-striped table-center">
        <?php 
            $this->html->table_header(array(
                array('title' => 'Gesendet am'),
                array('title' => 'Empfänger'),
                array('title' => 'Betreff'),
                array('title' => 'Text'),
                array('title' => 'SMTP Response')
            ));
        ?>
        <tbody data-id="<?php echo $id; ?>" data-eintrag-typ="<?php echo $eintrag_typ; ?>" class="js_table_tbody_email_logs">
        </tbody>
    </table>
</div>
