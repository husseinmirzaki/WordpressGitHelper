<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://husseinmirzaki.ir
 * @since      0.0.1
 *
 * @package    Mirzaki
 * @subpackage Mirzaki/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.0.1
 * @package    Mirzaki
 * @subpackage Mirzaki/includes
 * @author     Seyed Hussein Mirzaki <husseinmirzaki@gmail.com>
 */
class Mirzaki_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.0.1
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mirzaki',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
