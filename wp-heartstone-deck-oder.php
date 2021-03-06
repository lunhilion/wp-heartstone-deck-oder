<?php

/**
 * @link              https://github.com/lunhilion/
 * @since             0.0.1
 * @package           Wp_Heartstone_Deck_Oder
 *
 * @wordpress-plugin
 * Plugin Name:       Heartstone Deck-Oder
 * Plugin URI:        https://github.com/lunhilion/wp-heartstone-deck-oder
 * Description:       A deck-code importer for Wordpress.
 * Version:           0.2.1
 * Author:            LunHilion
 * Author URI:        https://github.com/lunhilion/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-heartstone-deck-oder
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP_HEARTSTONE_DECK_ODER_VERSION', '0.2.1' );

function activate_wp_heartstone_deck_oder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-heartstone-deck-oder-activator.php';
	Wp_Heartstone_Deck_Oder_Activator::activate();
}

function deactivate_wp_heartstone_deck_oder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-heartstone-deck-oder-deactivator.php';
	Wp_Heartstone_Deck_Oder_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_heartstone_deck_oder' );
register_deactivation_hook( __FILE__, 'deactivate_wp_heartstone_deck_oder' );

require plugin_dir_path( __FILE__ ) . 'includes/class-wp-heartstone-deck-oder.php';

function run_wp_heartstone_deck_oder() {

	$plugin = new Wp_Heartstone_Deck_Oder();
	$plugin->run();

}
run_wp_heartstone_deck_oder();
