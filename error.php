<?php

	include "init.php";

	
?>

<!DOCTYPE html>
<html lang="de">
    <?php $c_html->get_head(); ?>
    <body>
        <div class="main-wrapper login-body">
            <div class="login-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <?php $c_html->card_header('Fehler'); ?>
                                <div class="card-body">
                                    <?php 
                                        $c_helper->__message(
                                            'Es ist ein Fehler aufgetreten. Bitte kontaktieren Sie uns',
                                            'danger'
                                        )
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php $c_html->get_javascript(); ?>
    </body>
</html>