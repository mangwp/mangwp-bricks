<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://mangwp.com
 * @since      1.0.0
 *
 * @package    Mangwp_Bricks
 * @subpackage Mangwp_Bricks/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mangwp_Bricks
 * @subpackage Mangwp_Bricks/includes
 * @author     Ivan Nugraha <ivan@mangwp.com>
 */
class Mangwp_Bricks_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mangwp-bricks',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
