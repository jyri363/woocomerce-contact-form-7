<?php
/**
 * This file primarily consist of admin HTML 
 *
 * @package    Wc_cf7
 * @subpackage Wc_cf7/admin/partials
 */
?>

<div class="wrap">
	<h2><?php echo esc_html(get_admin_page_title()); ?></h2>
	<form method="post" action="options.php"> 
		<?php 
		global $product;
		// Grab all top options
        $options = get_option($this->plugin_name);	
		// General Options
		$jjk_cf7 = $options['jjk_cf7'];
		$jjk_rename = $options['jjk_rename'];
		if(empty($jjk_rename) || $jjk_rename == ''){
			$jjk_rename = "Ask more";
		}
		$jjk_position_cf7 = $options['jjk_position_cf7'];
		if(empty($jjk_position_cf7)){
			$jjk_position_cf7 = "after";
		}
		$jjk_remove_add_to_cart = $options['jjk_remove_add_to_cart'];

		// Settings fields
		settings_fields($this->plugin_name); 
		do_settings_sections($this->plugin_name); 
		?>
			<!-- Contact Form 7 shortcode -->
			<h2><?php esc_attr_e( 'Contact Form 7 shortcode', 'wc_cf7_admin' ); ?></h2>
			<input type="text" name="<?php echo $this->plugin_name; ?>[jjk_cf7]" value='<?php if(!empty($jjk_cf7)) echo $jjk_cf7; ?>' />
			<span class="description"><?php esc_attr_e( 'Put here "Contact Form 7" shortcode e.g. [contact-form-7 id="10" title="Contact form 1"] and in "Edit Contact Form" put "class:product_name" e.g. [text your-subject class:product_name]', 'wc_cf7_admin' ); ?></span><br>
			<!-- Rename -->
			<h2><?php esc_attr_e( 'Rename', 'wc_cf7_admin' ); ?></h2>
			<input type="text" name="<?php echo $this->plugin_name; ?>[jjk_rename]" value='<?php if(!empty($jjk_rename)) echo $jjk_rename; ?>' />
			<span class="description"><?php esc_attr_e( 'Rename tab or button', 'wc_cf7_admin' ); ?></span><br>
			<!-- Contact Form 7 position -->
			<h2><?php esc_attr_e( 'Contact Form 7 position', 'wc_cf7_admin' ); ?></h2>
			<fieldset>
				<legend class="screen-reader-text"><span>Contact Form 7 position</span></legend>
				<label title='g:i a'>
					<input type="radio" name="<?php echo $this->plugin_name; ?>[jjk_position_cf7]" value="after" <?php if($jjk_position_cf7 == 'after') echo 'checked="checked"'; ?> />
					<span><?php esc_attr_e( 'In tabs', 'wc_cf7_admin' ); ?></span>
				</label><br>
				<label title='g:i a'>
					<input type="radio" name="<?php echo $this->plugin_name; ?>[jjk_position_cf7]" value="before" <?php if($jjk_position_cf7 == 'before') echo 'checked="checked"'; ?> />
					<span><?php esc_attr_e( 'In Add to Cart Button', 'wc_cf7_admin' ); ?></span>
				</label>
			</fieldset>
			<!-- Add to Cart Button -->
			<h2><?php esc_attr_e( 'Add to Cart Button', 'wc_cf7_admin' ); ?></h2>
			<fieldset>
				<legend class="screen-reader-text"><span>Add to Cart Button</span></legend>
				<label for="users_can_register">
					<input name="<?php echo $this->plugin_name; ?>[jjk_remove_add_to_cart]" type="checkbox" id="jjk_remove_add_to_cart" value="1" <?php checked($jjk_remove_add_to_cart, 1); ?> />
					<span><?php esc_attr_e( 'Remove Add to Cart Buttons from Product Page', 'wc_cf7_admin' ); ?></span>
				</label>
			</fieldset>
			<?php submit_button(); ?>
		</form>
</div>