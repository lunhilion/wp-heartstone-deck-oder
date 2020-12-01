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
	
	const ADMIN_PAGE_NAME = "new-deck";
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
		//$icon = include(plugin_dir_url( __FILE__ ) . '../resources/svg/admin_hs_deckoder.svg');
		add_menu_page( 'HS Deck-Oder', 'HS DeckOder', 'edit_posts', self::ADMIN_PAGE_NAME, array( $this, 'display_admin_page' ), 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1000 1000"><path fill="black" d="M990,493L805.2,380.9c0,0-8.4-32.7-42-72.8l33.6-123.3l-126,39.2c0,0-42-32.7-64.4-36.4L500,5.5L388,196c0,0-22.4,10.3-67.2,28l-117.6-50.4l36.4,131.7c0,0-30.8,43.9-36.4,78.4L10,493l187.6,109.3c0,0,15.9,49.5,33.6,72.9l-42,120.5L318,764.8c0,0,60.7,43,84,50.4l95.2,179.3l106.4-179.3c0,0,64.4-28,84-42l126,33.6l-39.2-128.9c0,0,33.6-54.2,44.8-81.2L990,493z M637.2,655.5c0,0-52.5,43.4-120.4,47.6c0,0-118.3,15.4-159.6-39.2l92.4-33.6c0,0,140.7-46.2,142.8-95.3c0,0,42.7-79.1-16.8-148.5l-5.6-14l-11.2,2.8c0,0-61.6-21-114.8,33.6c0,0-30.1,51.8,8.4,86.9c0,0,21,11.9,19.6-11.2l-5.6-30.8c0,0,85.4-40.6,86.8,89.7c0,0-69.3,68.6-142.8,25.2c0,0-93.1-82.7-75.6-148.5l-2.8-33.6l61.6-53.2l81.2-47.6l28,5.6l25.2-11.2l14,16.8l78.4,19.6c0,0,69.3,71.4,70,100.9C690.4,417.4,740.8,572.1,637.2,655.5z"/></svg>'));
		//add_menu_page( 'HS Deck-Oder', 'HS DeckOder', 'edit_posts', 'test-plugin', array( $this, 'display_admin_page' ));
	}

	public function display_admin_page() {
		require_once plugin_dir_path( __FILE__ ) . 'views/wp-heartstone-deck-oder-admin-page.php';
	}

	public function my_plugin_handler() {
    	if(isset($_POST['my_submit_smart'])) {
			$deck = Hs_Serializer::deserialize($_POST['deck-code']);
			$deck->set_format($_POST['deck-format']);
			$deck->set_server($_POST['deck-server']);
			$deck->set_rank($_POST['deck-rank']);
			$deck->set_author($_POST['deck-player-name']);
			$deck->set_archetype($_POST['deck-archetype']);
			self::insert_wordpress_deck($deck);
		}
	
		if(isset($_POST['my_submit_importlel'])) {
			$api = Hs_Api::get_instance();
			foreach($api->get_all_cards() as $card) {
				$content = "<img src=". $api->get_rendered_card($card["id"]) ."></img>";
				self::create_wordpress_post(self::create_slug($card["name"]), $card["name"], $content);
			}
		}	 	
	}

	public static function insert_wordpress_deck($deck) {
		$post_id = self::create_wordpress_post(self::create_slug($deck->generate_title()), $deck->generate_title(), $deck->html_render(), $deck->html_excerpt());
		$trimmed_hero = preg_replace('/\s/', '', $deck->get_hero());
		echo "EROE: " . $trimmed_hero;
		self::add_featured_image_to_post($trimmed_hero, $post_id);
	}

	public static function create_wordpress_post($slug, $title, $content, $excerpt) {	
		$post_id = -1;
		$author_id = get_current_user_id();
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
					'post_type'         =>   'post',
					'post_excerpt'		=>	 $excerpt
				)
			);
			return $post_id;

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

		public static function create_slug($value) {
			return str_replace(" ", "-", $value);
		}

		public static function create_combobox($label, $values, $selected) {
			$html = '<select name="deck-'. $label .'">';
			foreach($values->get_constants() as $key => $value) {
				if(strcmp($value, $selected) == 0) {
					$html .= '<option value="'. $value .'" selected>'. $key .'</option>';
				} else {
					$html .= '<option value="'. $value .'">'. $key .'</option>';
				}
			}
			$html .= '</select>';
			echo $html;
		}

		public static function create_admin_page($current_tab) {
			$tabs = array(
				'smart-import'   => 'Nuovo Mazzo', 
				'standard-import'  => 'Nuovo Mazzo [CUSTOM]'
			);
			if(empty($current_tab)) {
				$current_tab = key($tabs);
			}
			$html = '<h2 class="nav-tab-wrapper">';
			foreach( $tabs as $tab => $name ){
				$class = ( $tab == $current_tab ) ? 'nav-tab-active' : '';
				$html .= '<a class="nav-tab ' . $class . '" href="?page='. self::ADMIN_PAGE_NAME .'&tab=' . $tab . '">' . $name . '</a>';
			}
			$html .= '</h2>';
			echo $html;
			$page_url = "views/main-pages/". $current_tab .".php";
			include_once($page_url);
		}

		public static function add_featured_image_to_post($image_name, $post_id) {
			if(!empty($image_name)) {
				$query_images_args = array(
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'post_status'    => 'inherit',
					'posts_per_page' => - 1,
				);
				$query_images = new WP_Query($query_images_args);
				$image_id;
				$images = array();
				foreach ($query_images->posts as $image) {
					$image_url = wp_get_attachment_url($image->ID);
					$match = strpos($image_url, $image_name);
					if($match !== false) {
						$image_id = $image->ID;
						break;
					}
				}
				if(!empty($image_id)) {
					$thumbnail = set_post_thumbnail($post_id, $image_id);
				}
			}
		}
}
?>