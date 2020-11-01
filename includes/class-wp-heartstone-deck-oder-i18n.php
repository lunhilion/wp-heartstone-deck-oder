<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.0.1
 * @package    Wp_Heartstone_Deck_Oder
 * @subpackage Wp_Heartstone_Deck_Oder/includes
 * @author     LunHilion <e.sanguin.92@gmail.com>
 */
class Wp_Heartstone_Deck_Oder_i18n {

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-heartstone-deck-oder',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}
