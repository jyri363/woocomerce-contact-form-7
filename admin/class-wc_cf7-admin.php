<?php
/**
 * WooCommerce and Contact Form 7 Admin
 *
 * @class       Wc_cf7
 * @author      Jüri-Joonas Kerem <jyri363@gmail.com>
 * @category    Admin
 * @package     woocomerce-contact-form-7
 * @subpackage	woocomerce-contact-form-7/admin
 * @since      	1.0.0
 */

class Wc_cf7_Admin {
	
	/**
	 * The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 */	 
	private $version;
	
	/**
	 * Constructor
	 */	 
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, WC_CF7_PLUGIN_DIR_URL . 'css/wc_cf7-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, WC_CF7_PLUGIN_DIR_URL . 'js/wc_cf7-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Create a WooCommerce and Contact Form 7 admin Settings menu
	 */
	public function add_plugin_admin_menu() {
		//create new top-level menu
		add_menu_page( 
			__( 'WooCommerce and Contact Form 7 Settings', $this->plugin_name ),
			'WC & CF7',
			'administrator',
			$this->plugin_name,
			array($this, 'wc_cf7_plugin_settings_page'),
			plugins_url($this->plugin_name.'/images/icon.png', $this->plugin_name),
			40
		); 
		//call register settings function
		//add_action( 'admin_init', 'register_wc_cf7_plugin_settings' );
	}
	
	/**
	* Add settings action link to the plugins page.
	*/
	public function add_action_links( $links ) {
	   $settings_link = array(
		'<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );
	}
	
	/**
	* validates
	**/
	public function validate($value) {
		// All inputs        
		$valid = array();
		$valid['jjk_cf7'] = $value['jjk_cf7'];
		$valid['jjk_position_cf7'] = $value['jjk_position_cf7'];
		return $valid;
	}
	/**
	 * Register settings/options
	 */
	public function options_update() {
		//register our settings
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}
	/**
	 * Display a WooCommerce and Contact Form 7 admin Settings page
	 */
	function wc_cf7_plugin_settings_page(){ 
		include_once( 'partials/wc_cf7-admin-display.php' );
	}
	/**/
	function woo_rename_tabs( $tabs ) {
		global $product;
		$subject    =   $product->post->post_title;
		$options = get_option($this->plugin_name);	
		$jjk_position_cf7 = $options['jjk_position_cf7'];
		if($jjk_position_cf7 != "before"){
			$tabs['test_tab']['title'] = __( $subject );			// Rename the tab
		}
		return $tabs;
	}
}
