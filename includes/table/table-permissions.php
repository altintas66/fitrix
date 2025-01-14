
<div class="table-responsive">
        <table class="table table-striped table-center mb-0">
            <thead>
                <tr>
                    <th>Rollen</th>
                    <?php foreach($rollen as $rolle)
                    {
                        echo('<th class="text-center">'.$rolle['name'].'</th>');
                    }?>

                </tr>
            </thead>
            <tbody>
                <?php foreach($permissions as $perm) {?>
                    <tr>
                        <td>
                            <?php echo $perm['label']; 
                                foreach($rollen as $rolle)
                                {
                                    if($c_permission->check_rolle_permission($rolle['rolle_id'], $perm['permission'])) $checked = 'checked';
                                    else $checked = '';
                                    echo('<td class="text-center"><input data-permission="'.$perm['id'].'" data-rolle-id="'.$rolle['rolle_id'].'" type="checkbox" id="vehicle1" name="vehicle1" value="Bike" '.$checked.'></td>');
                                }
                            ?>
                        </td>
                    </tr>
                    
                <?php $counter++;  } ?>
            </tbody>
        </table>
    </div>