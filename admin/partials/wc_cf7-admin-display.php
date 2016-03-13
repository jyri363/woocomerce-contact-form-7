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
		<?php settings_fields($this->plugin_name); ?>
		<?php do_settings_sections($this->plugin_name); ?>
		<input type="text" name="<?php echo $this->plugin_name; ?>" value="<?php echo esc_attr( get_option($this->plugin_name) ); ?>" />
		<?php _e('Put here "Contact Form 7" shortcode e.g. [contact-form-7 id="10" title="Contact form 1"] and in "Edit Contact Form" put "class:product_name" e.g. [text your-subject <span style="color:red;">class:product_name</span>]', 'wc_cf7'); ?>
		<?php submit_button(); ?>
	</form>
</div>