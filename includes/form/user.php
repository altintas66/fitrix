    
   
    <div class="row mt-20">
        <div class="col-md-12">
            <?php $c_form->input_file('Foto anpassen', 'foto', '', false); ?>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-md-4">
            <?php 
                $c_form->input_disabled(
                    isset($buff['username']) ? $buff['username'] : '', 
                    'Username',
                    'username'
                ); 
            ?>
        </div>
        <div class="col-md-4">
            <?php 
                $c_form->input_text(
                    'Vorname', 
                    'vorname', 
                    isset($buff['vorname']) ? $buff['vorname'] : '', 
                    '', 
                    true
                ); 
            ?>
        </div>
        <div class="col-md-4">
            <?php 
                $c_form->input_text(
                    'Nachname', 
                    'nachname', 
                    isset($buff['nachname']) ? $buff['nachname'] : '',
                    '', 
                    true
                ); 
            ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <?php 
                $c_form->input_email(
                    'E-Mail', 
                    'email', 
                    isset($buff['email']) ? $buff['email'] : '',
                    '', 
                    false
                ); 
            ?>
        </div>
        <div class="col-md-6">
            <?php 
                $c_form->input_text(
                    'Mobil', 
                    'mobil', 
                    isset($buff['mobil']) ? $buff['mobil'] : '',
                    '', 
                    false
                ); 
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php 
                $c_form->rolle(
                    true,
                    isset($buff['rolle_id']) ? $buff['rolle_id'] : '',
                );
            ?>
        </div>
        <div class="col-md-6">    
            <?php 
                $c_form->geschlecht(
                    true,
                    isset($buff['geschlecht']) ? $buff['geschlecht'] : ''
                ); 
            ?>
        </div>
        
    </div>


    <div class="row">
        <div class="col-md-12">
            <?php 
                $c_form->textarea(
                    'Bemerkung', 
                    'bemerkung', 
                    isset($buff['bemerkung']) ? $buff['bemerkung'] : '',
                    false
                ); 
            ?>
        </div>
    </div>







