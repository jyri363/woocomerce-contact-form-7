<?php
/**
 * @since      1.0.0
 * @package    Wc_cf7
 * @subpackage Wc_cf7/includes
 * @author     Jüri-Joonas Kerem <jyri363@gmail.com>
 */
class Wc_cf7_Deactivator {

	/**
	 * Short Description
	 */
	public static function deactivate() {
		$option_name = WC_CF7_PLUGIN_NAME;
		delete_option( $option_name );
	}

}
