<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.0.1
 * @package    Wp_Heartstone_Deck_Oder
 * @subpackage Wp_Heartstone_Deck_Oder/includes
 * @author     LunHilion <e.sanguin.92@gmail.com>
 */
class Wp_Heartstone_Deck_Oder {

	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {
		if ( defined( 'WP_HEARTSTONE_DECK_ODER_VERSION' ) ) {
			$this->version = WP_HEARTSTONE_DECK_ODER_VERSION;
		} else {
			$this->version = '0.0.1';
		}
		$this->plugin_name = 'wp-heartstone-deck-oder';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-heartstone-deck-oder-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-heartstone-deck-oder-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-heartstone-deck-oder-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-heartstone-deck-oder-public.php';

		$this->loader = new Wp_Heartstone_Deck_Oder_Loader();

	}

	private function set_locale() {

		$plugin_i18n = new Wp_Heartstone_Deck_Oder_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_admin_hooks() {

		$plugin_admin = new Wp_Heartstone_Deck_Oder_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	private function define_public_hooks() {

		$plugin_public = new Wp_Heartstone_Deck_Oder_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
