<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Wc_cf7
 * @subpackage Wc_cf7/public
 * @author     Jüri-Joonas Kerem <jyri363@gmail.com>
 */
class Wc_cf7_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public side of the site.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc_cf7-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public side of the site.
	 */
	public function enqueue_scripts() { 
		wp_enqueue_script( $this->plugin_name.'-popup', plugin_dir_url( __FILE__ ) . 'js/jquery.bpopup.min.js', array( 'jquery' ), $this->version, true );	
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc_cf7-public.js', array( 'jquery' ), $this->version, true );					
	}
	public function add_scripts_action() {
		global $post, $product;
		$ID = $post->ID;
		$price = get_post_meta( $ID, '_regular_price', true);
		$sale = get_post_meta( $ID, '_sale_price', true);
		$script_vars = array(
             'title'    => get_the_title( $ID ),
			 'product slug'	=> $product,
             'url'      => get_permalink( $ID ),
			 'id'		=> $ID,
			 'price'	=> $price,
			 'sale'		=> $sale 
         );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( $this->plugin_name );
		wp_localize_script( $this->plugin_name, 'script_vars', $script_vars );
	}
	/**
	 * Add woocommerce template
	 */
	public function wc_cf7_woocommerce_locate_template( $template, $template_name, $template_path ) {
		global $woocommerce;

		$_template = $template;

		if ( ! $template_path ) {
			$template_path = $woocommerce->template_url;
		}
		$plugin_path  = WC_CF7_PLUGIN_DIR . '/woocommerce/';

		// Look within passed path within the theme - this is priority
		$template = locate_template(
			array(
				$template_path . $template_name,
				$template_name
			)
		);

		// Modification: Get the template from this plugin, if it exists
		if ( ! $template && file_exists( $plugin_path . $template_name ) ){
			$template = $plugin_path . $template_name;
		}

		// Use default template
		if ( ! $template ) {
			$template = $_template;
		}

		// Return what we found
		return $template;
	}
	
	/**
	 *  Adds woocommerce product tabs
	 **/	
	public function product_enquiry_tab( $tabs ) {
		$options = get_option($this->plugin_name);	
		$jjk_cf7 = $options['jjk_cf7'];
		$jjk_position_cf7 = $options['jjk_position_cf7'];
		if($jjk_cf7 != "" && $jjk_position_cf7 != "before"){
			$tabs['test_tab'] = array(
				'title'     => __( 'Enquire about Product', 'woocommerce' ),
				'priority'  => 50,
				'callback'  => array($this, 'product_enquiry_tab_form')
			);
			return $tabs;
		}
		return null;
	}
	
	/**
	 * Adds Contact Form 7 shortcode in woocommerce product page
	 **/
	public function product_enquiry_tab_form() {
		global $product;
		$options = get_option($this->plugin_name);	
		$jjk_cf7 = $options['jjk_cf7'];
		//If you want to have product ID also
		//$product_id = $product->id;
		//$subject    =   $product->post->post_title;
		/*?>
			<script>
				(function($){
					$(".jjk_product_name").val("aa123");
				})(jQuery);
			</script>   
			<?php */
		if($jjk_cf7 != ""){
			//echo "<h3>".$subject."</h3>";
			echo do_shortcode($jjk_cf7); //add your contact form shortcode here ..
			
		}
	}
	
}
