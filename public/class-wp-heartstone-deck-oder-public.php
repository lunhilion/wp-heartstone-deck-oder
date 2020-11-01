<?php

/**
 * @link       https://github.com/lunhilion/
 * @since      1.0.0
 *
 * @package    Wp_Heartstone_Deck_Oder
 * @subpackage Wp_Heartstone_Deck_Oder/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Heartstone_Deck_Oder
 * @subpackage Wp_Heartstone_Deck_Oder/public
 * @author     LunHilion <e.sanguin.92@gmail.com>
 */
class Wp_Heartstone_Deck_Oder_Public {

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-heartstone-deck-oder-public.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-heartstone-deck-oder-public.js', array( 'jquery' ), $this->version, false );
	}

}
