<?php
	global $c_form, $config, $einstellungen, $c_helper, $c_url;
?>
				</div>			
			</div>
        </div>
		
		<div id="config"
			data-site-url="<?php echo $config['siteurl']; ?>"
			data-upload-path="<?php echo $c_helper->get_upload_path(''); ?>"
		></div>

		<?php 
			$c_form->modal_delete(); 
			$this->get_javascript();
		?>
		
    </body>
</html> 