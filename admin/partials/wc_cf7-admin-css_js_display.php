<div class="wrap">
	<h2><?php echo esc_html(get_admin_page_title()) ?></h2>
	<form method="post" action="options.php">
	<?php 
		require_once('wc_cf7-admin-css_js_default.php');
		// Grab all options
        $options = get_option($this->plugin_name.'_css_js');	
		// Custom CSS & JS
		$jjk_css = $options['jjk_css'];
		$jjk_js = $options['jjk_js'];
		if($jjk_css == '') {			
			$jjk_css = jjk_default_css();
		}
		if($jjk_js == '') {
			$jjk_js = jjk_default_js();
		}
		//Settings fields
		settings_fields($this->plugin_name.'_css_js'); 
		do_settings_sections($this->plugin_name.'_css_js'); 
		?>
		<h2><?php esc_attr_e( 'Custom CSS', 'wp_admin_style' ); ?></h2>
		<textarea id="jjk_css" name="<?php echo $this->plugin_name.'_css_js'; ?>[jjk_css]" cols="80" rows="10" class="large-text"><?php echo $jjk_css; ?></textarea>
		<br>
		<h2><?php esc_attr_e( 'Custom JS', 'wp_admin_style' ); ?></h2>
		<textarea id="jjk_js" name="<?php echo $this->plugin_name.'_css_js'; ?>[jjk_js]" cols="80" rows="10" class="large-text"><?php echo $jjk_js; ?></textarea>
		<?php submit_button(); submit_button( __('Reset'), 'secondary', 'reset', false); ?>		
	</form>	
</div>