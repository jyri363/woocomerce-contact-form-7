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
	 * Display cf7.
	 *
	 * @var string
	 */
	public $jjk_cf7;
	
	/**
	 * Position cf7
	 *
	 * @var string
	 */
	public $jjk_position_cf7;
	
	/**
	 * Display css.
	 *
	 * @var string
	 */
	public $jjk_css;
	
	/**
	 * Display js
	 *
	 * @var string
	 */
	public $jjk_js;
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->jjk_cf7 = get_option($this->plugin_name)['jjk_cf7'];
		$this->jjk_position_cf7 = get_option($this->plugin_name)['jjk_position_cf7'];
		$this->jjk_css = get_option($this->plugin_name.'_css_js')['jjk_css'];
		$this->jjk_js = get_option($this->plugin_name.'_css_js')['jjk_js'];
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
			 'product_slug'	=> $product,
             'url'      => get_permalink( $ID ),
			 'id'		=> $ID,
			 'price'	=> $price,
			 'sale'		=> $sale 
         );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( $this->plugin_name );
		wp_localize_script( $this->plugin_name, 'script_vars', $script_vars );
	}
	
	public function hook_css_box(){
		?>		
        <style type="text/css">
			<?php echo $this->jjk_css;?>
		</style>
        <?php
	}	

	public function hook_js_box(){
		?>
        <script type="text/javascript">
			/* <![CDATA[ */
			<?php echo $this->jjk_js;?>
			/* ]]> */
		</script>
        <?php
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
		if($this->jjk_cf7 != "" && $this->jjk_position_cf7 != "before"){
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
		if($this->jjk_cf7 != ""){
			//echo "<h3>".$subject."</h3>";
			echo do_shortcode($this->jjk_cf7); //add your contact form shortcode here ..
			
		}
	}
	/*
	* Adds Contact Form 7 button
	*/
	public function add_new_button() {
		global $product;
		if($this->jjk_cf7 != "" && $this->jjk_position_cf7 == "before"): ?>
			<a class="button button_theme button_js popmake-2656" id="show_jjk" href="#" rel="nofollow"><span class="button_icon"><i class="icon-forward"></i></span><span class="button_label"><?php _e("Ask more"); ?></span></a>
			<!-- Element to pop up -->
			<div id="element_to_pop_up">
				<span class="button b-close">x</span>
				<?php echo do_shortcode($this->jjk_cf7); ?>
			</div>
		<?php endif; 
	}
	/*
	* Remove Add to Cart button
	*/
	public function remove_add_to_cart_button(){
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
		remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );	
	}
	/*
	* Replace Add to Cart button
	*/
	public function replace_add_to_cart() {
		global $product;
		$link = $product->get_permalink();
		echo do_shortcode('<a href="'.$link.'" class="button addtocartbutton">View Product</a>');
	}
	// test is_purchasable
	public function my_woocommerce_is_purchasable($is_purchasable, $product) {
			return ($product->id == 37 ? false : $is_purchasable);
	}
}
