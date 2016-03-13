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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc_cf7-public.js', array( 'jquery' ), $this->version, false );
	}
	
	/**
	 *  Adds product tabs
	 **/	
	public function product_enquiry_tab( $tabs ) {
		if(get_option($this->plugin_name) != ""){
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
	 * Adds Contact Form 7 shortcode in product page
	 **/
	public function product_enquiry_tab_form() {
		global $product;
		//If you want to have product ID also
		//$product_id = $product->id;
		$subject    =   $product->post->post_title;
		if(get_option($this->plugin_name) != ""){
			echo "<h3>".$subject."</h3>";
			echo do_shortcode(get_option($this->plugin_name)); //add your contact form shortcode here ..

			?>

			<script>
				(function($){
					$(".product_name").val("<?php echo $subject; ?>");
				})(jQuery);
			</script>   
			<?php 
		}
	}

}
