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

	public function create_menu() {
		$icon = file_get_contents(plugin_dir_url( __FILE__ ) . '../resources/svg/admin_hs_deckoder.svg');
		add_menu_page( 'HS Deck-Oder', 'HS DeckOder', 'manage_options', 'test-plugin', array( $this, 'display_admin_page' ), 'data:image/svg+xml;base64,' . base64_encode($icon));
	}

	public function display_admin_page() {
		require_once plugin_dir_path( __FILE__ ) . 'views/wp-heartstone-deck-oder-admin-page.php';
	}

	public function my_plugin_handler() {
    	if(isset($_POST['my_submit'])) {
			$val_a = $_POST['deck-name'];
			$val_b = $_POST['deck-code'];

			$deck = Hs_Serializer::deserialize($val_b);
			$deck->set_deck_name($val_a);

			self::create_wordpress_post("prova-insert2", $deck->get_deck_name(), $deck->html_render());
		}		 	
	}

	public static function create_wordpress_post($slug, $title, $content) {	
     
		$post_id = -1;
	 
		$author_id = 1;
		//$slug = 'prova-insert';
		if( !self::post_exists_by_slug( $slug ) ) {
			$post_id = wp_insert_post(
				array(
					'comment_status'    =>   'closed',
					'ping_status'       =>   'closed',
					'post_author'       =>   $author_id,
					'post_name'         =>   $slug,
					'post_title'        =>   $title,
					'post_content'      =>   $content,
					'post_status'       =>   'publish',
					'post_type'         =>   'post'
				)
			);
		} else {
			$post_id = -2;
		}
	}
	public static function post_exists_by_slug( $post_slug ) {
		$args_posts = array(
			'post_type'      => 'post',
			'post_status'    => 'any',
			'name'           => $post_slug,
			'posts_per_page' => 1,
		);
		$loop_posts = new WP_Query( $args_posts );
		if ( ! $loop_posts->have_posts() ) {
			return false;
		} else {
			$loop_posts->the_post();
			return $loop_posts->post->ID;
		}
		}
}
?>