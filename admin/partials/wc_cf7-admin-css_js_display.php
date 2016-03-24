<div class="wrap">
	<h2><?php echo esc_html(get_admin_page_title()) ?></h2>
	<form method="post" action="options.php">
	<?php 
		// Grab all options
        $options = get_option($this->plugin_name.'_css_js');	
		// Custom CSS & JS
		$jjk_css = $options['jjk_css'];
		$jjk_js = $options['jjk_js'];
		if($jjk_css == '') {
			$jjk_css = '
#element_to_pop_up { 
	background-color:#fff;
	border-radius:15px;
	color:#000;
	display:none; 
	padding:20px;
	min-width:1000px;
	min-height: 180px;
}
.b-close {
    background-color: #2b91af;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    border-radius: 7px 7px 7px 7px;
    box-shadow: none;
    font: bold 131% sans-serif;
    padding: 0 6px 2px;
    position: absolute;
    right: -7px;
    top: -7px;
    text-align: center;
    text-decoration: none;
}
/* */
@media screen and (max-width : 1024px) {
	#element_to_pop_up { 
		min-width:400px;
	}
}
/* */
@media screen and (max-width : 600px) {
	#element_to_pop_up { 
		padding: 6px;	
		min-width:200px;
	}
}
/* */
@media screen and (max-width : 480px) {
	#element_to_pop_up { 
		padding: 4px;
		min-width:200px;
			left: 1px !important;
	}
	.b-close {
		right:0px;
		top:0px;
	}
}';
		}
		if($jjk_js == '') {
			$jjk_js = "
(function( $ ) {
  'use strict';
  $('.jjk_product_name').val(script_vars.title); 
	$(function() {
		$('#show_jjk').bind('click', function(e) {
			e.preventDefault();
			$('#element_to_pop_up').bPopup();
		});
	});
})( jQuery );";
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
		<?php submit_button(); ?>
	</form>	
</div>