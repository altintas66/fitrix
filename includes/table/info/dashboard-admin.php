
    <div class="table-responsive">
        <table class="table table-center text-center">
            <?php  
                $c_html->table_header(array(
                    array('title' => 'Anzahl User'),
                    array('title' => 'Anzahl API Schlüssel')
                ));
            ?>
            <tbody>
                <tr>
                    <td><?php echo $c_helper->get_size_of_array($user); ?></td>
                    <td><?php echo $c_helper->get_size_of_array($api_keys); ?></td>
                </tr>
            </tbody>
        </table>
    </div>