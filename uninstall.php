<?php
/**
 * WooCommerce and Contact Form 7 Uninstall
 *
 * @package     Wc_cf7
 * @version     1.0.0
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( WC_CF7_PLUGIN_NAME );
delete_option( WC_CF7_PLUGIN_NAME.'_css_js' );