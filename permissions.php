<?php
	include 'init.php';
    $c_permission->check_user_permission_redirect('RECHTE_VERWALTEN');
	$c_html->get_header();
	$c_html->get_breadcrumbs(array(array('Berechtigungen', '#')));

    $rollen       = $c_rolle->get_all();
    $permissions  = $c_permission->get_permissions();
    $counter = 0;

?>
    

    <?php if($permissions != NULL) { ?>
        <div class="row">
            <div class="col-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div id="permission-wrapper">
                            <?php include 'includes/table/table-permissions.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
   
<?php $c_html->get_footer(); ?>