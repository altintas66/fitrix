    
   <div class="row">
        <div class="col-md-8">

            <div class="card">
                <?php $c_html->card_header('Allgemein'); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php 
                                $c_form->input_text(
                                    'Artikelname', 
                                    'artikel_name', 
                                    isset($buff['artikel_name']) ? $buff['artikel_name'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                                if(isset($buff['artikel_nummer'])) $artikel_nummer = $buff['artikel_nummer'];
                                else $artikel_nummer = $c_artikel->get_neue_artikel_nummer();

                                $c_form->input_number(
                                    'Artikelnummer', 
                                    'artikel_nummer', 
                                    $artikel_nummer, 
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?php 
                                $c_form->input_waehrung(
                                    'Preis', 
                                    'preis', 
                                    isset($buff['preis']) ? $buff['preis'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php 
                                $c_form->input_waehrung(
                                    'Einrichtungsgebühr', 
                                    'einrichtungsgebuehr', 
                                    isset($buff['einrichtungsgebuehr']) ? $buff['einrichtungsgebuehr'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php 
                                $c_form->artikel_typ(
                                    true,
                                    isset($buff['fk_artikel_typ_id']) ? $buff['fk_artikel_typ_id'] : ''
                                ); 
                            ?>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <?php 
                                $c_form->input_toggle(
                                    'Vertragslaufzeit',
                                    'vertragslaufzeit',
                                    isset($buff['vertragslaufzeit']) ? $buff['vertragslaufzeit'] : '0', 
                                );
                            ?>
                        </div>
                        <div class="col-md-4 js_vertragslaufzeit_input">
                            <?php 
                                $c_form->input_text(
                                    'Vertragslaufzeit Monate', 
                                    'vertragslaufzeit_monate', 
                                    isset($buff['vertragslaufzeit_monate']) ? $buff['vertragslaufzeit_monate'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                        <div class="col-md-4 js_vertragslaufzeit_input">
                            <?php 
                                $c_form->input_text(
                                    'Vertragslaufzeit Kündigungsfrist', 
                                    'vertragslaufzeit_kuendigungsfrist', 
                                    isset($buff['vertragslaufzeit_kuendigungsfrist']) ? $buff['vertragslaufzeit_kuendigungsfrist'] : '',
                                    '', 
                                    true
                                ); 
                            ?>
                        </div>
                    
                    </div>

                
                    <div class="row">
                        <div class="col-md-12">
                            <?php 
                                $c_form->textarea(
                                    'Artikel Beschreibung', 
                                    'artikel_beschreibung', 
                                    isset($buff['artikel_beschreibung']) ? $buff['artikel_beschreibung'] : '',
                                    false
                                ); 
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <?php 
                                $c_form->textarea(
                                    'Artikel Beschreibung im Angebot', 
                                    'artikel_beschreibung_angebot', 
                                    isset($buff['artikel_beschreibung_angebot']) ? $buff['artikel_beschreibung_angebot'] : '',
                                    false
                                ); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <?php include 'artikel-sidebar.php'; ?>
    </div>
    
    
    
    


    
    
    
    







