<?php
/**
 * Plugin Name: WooCommerce and Contact Form 7
 * Plugin URI: http://imwebsolutions.eu
 * Description: Additional Tab Product Inquiry.
 * Author: Jüri-Joonas Kerem
 * Author URI: http://imwebsolutions.eu
 * Version: 0.1
 * Tested up to: 4.4.2
 *
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package     
 * @author      Jüri-Joonas Kerem
 * @category    Plugin
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

define("ADMIN", "wc_cf7-plugin-settings");
define("ADMINURL", "admin.php?page=".ADMIN);

/**
 * Exit if accessed directly
 **/
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Activate plugin
 * This action is documented in includes/class-wc_cf7-activator.php
 */
function activate_wc_cf7() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc_cf7-activator.php';
	Wc_cf7_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_wc_cf7' );

/**
 * Create a WooCommerce and Contact Form 7 Settings menu
 */
add_action( 'admin_menu', 'create_wc_cf7_plugin_menu_page' );
 
function create_wc_cf7_plugin_menu_page(){
	//create new top-level menu
    add_menu_page( 
        __( 'WooCommerce and Contact Form 7 Settings', 'wc_cf7' ),
        'WC & CF7',
        'administrator',
        __FILE__,
        'wc_cf7_plugin_settings_page',
        plugins_url('/images/icon.png', __FILE__),
        40
    ); 
	//call register settings function
	add_action( 'admin_init', 'register_wc_cf7_plugin_settings' );
}

/**
 * Register settings
 */
function register_wc_cf7_plugin_settings() {
	//register our settings
	register_setting( 'wc-cf7-plugin-settings-group', 'cf7_shortcode' );
}
 
/**
 * Display a WooCommerce and Contact Form 7 Settings page
 */
function wc_cf7_plugin_settings_page(){ 

?>
		
	<div class="wrap">
		<h2><?php echo esc_html(get_admin_page_title()); ?></h2>
		<form method="post" action="options.php"> 
			<?php settings_fields( 'wc-cf7-plugin-settings-group' ); ?>
			<?php do_settings_sections( 'wc-cf7-plugin-settings-group' ); ?>
			<input type="text" name="cf7_shortcode" value="<?php echo esc_attr( get_option('cf7_shortcode') ); ?>" />
			<?php _e('Put here "Contact Form 7" shortcode e.g. [contact-form-7 id="10" title="Contact form 1"] and in "Edit Contact Form" put "class:product_name" e.g. [text your-subject <span style="color:red;">class:product_name</span>]', 'wc_cf7'); ?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php

}
/**
 *  Adds product tab
 **/
 
add_filter( 'woocommerce_product_tabs', 'product_enquiry_tab' );
function product_enquiry_tab( $tabs ) {
	if(get_option('cf7_shortcode') != ""){
		$tabs['test_tab'] = array(
			'title'     => __( 'Enquire about Product', 'woocommerce' ),
			'priority'  => 50,
			'callback'  => 'product_enquiry_tab_form'
		);
		return $tabs;
	}
    return null;
}

/**
 * Adds Contact Form 7 shortcode in product page
 **/
function product_enquiry_tab_form() {
    global $product;
    //If you want to have product ID also
    //$product_id = $product->id;
    $subject    =   $product->post->post_title;
	if(get_option('cf7_shortcode') != ""){
		echo "<h3>".$subject."</h3>";
		echo do_shortcode(get_option('cf7_shortcode')); //add your contact form shortcode here ..

		?>

		<script>
		(function($){
			$(".product_name").val("<?php echo $subject; ?>");
		})(jQuery);
		</script>   
		<?php 
	}
}

?>