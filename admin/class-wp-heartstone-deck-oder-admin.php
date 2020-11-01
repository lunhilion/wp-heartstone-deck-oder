<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Heartstone_Deck_Oder
 * @subpackage Wp_Heartstone_Deck_Oder/admin
 * @author     LunHilion <e.sanguin.92@gmail.com>
 */
class Wp_Heartstone_Deck_Oder_Admin {

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-heartstone-deck-oder-admin.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-heartstone-deck-oder-admin.js', array( 'jquery' ), $this->version, false );

	}

}
