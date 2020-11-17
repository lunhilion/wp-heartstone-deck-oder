<?php

/**
 * @since      0.0.1
 * @package    Wp_Heartstone_Deck_Oder
 * @subpackage Wp_Heartstone_Deck_Oder/includes
 * @author     LunHilion <e.sanguin.92@gmail.com>
 */

 //TODO: defined( 'ABSPATH' )
 //TODO: aggiungere ricerda per lingua con builder pattern
class Hs_Api {

	const API_URL = "https://api.hearthstonejson.com/v1/latest/";
	const API_ART_URL = "https://art.hearthstonejson.com/v1/tiles/";
	const API_RENDER_URL = "https://art.hearthstonejson.com/v1/render/latest/";

	private static $instance;
	private $locale;
	private $json_cards;

	private function __construct() {
		$this->locale = "enUS";
		$this->json_cards = $this->retrive_all_cards();
	}

	public static function get_instance() {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function retrive_all_cards() {
		$response = wp_remote_get(self::API_URL . $this->locale .'/cards.collectible.json');
		return json_decode( wp_remote_retrieve_body($response), true );
	}
	
	public function get_all_cards() {
		return $this->json_cards;
	}

	public function get_card($dbfid) {
		foreach($this->json_cards as $card) {
			if(strcmp($card["dbfId"], $dbfid) == 0) {
				return $card;
			}
		}
	}

	public function get_hero($dbfid) {
		foreach($this->json_cards as $card) {
			if(strcmp($card["dbfId"], $dbfid) == 0) {
				return $card["cardClass"];
			}
		}
	}

	public function set_locale($locale) {
		$this->locale = $locale;
		return $this;

	}

	public function get_card_art_link($id) {
		return self::API_ART_URL . $id . ".png";

	}

	public function get_rendered_card($id) {
		return self::API_RENDER_URL . "enUS/256x/" . $id . ".png";

	}

}
?>