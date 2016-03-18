<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
<?php 
$options = get_option('woocomerce-contact-form-7');	
$jjk_cf7 = $options['jjk_cf7'];
$jjk_position_cf7 = $options['jjk_position_cf7'];
if($jjk_cf7 != "" && $jjk_position_cf7 == "before"): ?>
	<a class="button button_theme button_js popmake-2656" id="show_jjk" href="#" rel="nofollow"><span class="button_icon"><i class="icon-forward"></i></span><span class="button_label"><?php _e("Ask more"); ?></span></a>
	<!-- Element to pop up -->
	<div id="element_to_pop_up">
		<a class="b-close">x<a/>
		<?php echo do_shortcode($jjk_cf7); ?>
	</div>
<?php endif; ?>