<?php

/**
 * @since      0.0.1
 * @package    Wp_Heartstone_Deck_Oder
 * @subpackage Wp_Heartstone_Deck_Oder/includes
 * @author     LunHilion <e.sanguin.92@gmail.com>
 */
class Hs_Deck {

	private $deck_name;
	private $hero;
	private $format;
	private $cards_list = array();

	public function __construct() {}

	public function add_card($dbfid, $name, $quantity) {
		array_push($this->cards_list, array(
			'dbfId' => $dbfid,
			'name' => $name,
			'quantity' => $quantity
		));
	}

	public function get_single_cards() {
		$temp = array();
		foreach($this->cards_list as $card) {
			if($card["quantity"] == 1) {
				$temp[] = $card;
			}
		}
		return $temp;
	}

	public function get_double_cards() {
		$temp = array();
		foreach($this->cards_list as $card) {
			if($card["quantity"] == 2) {
				$temp[] = $card;
			}
		}
		return $temp;
	}

	public function html_render() {
		$html = '<div class="hsdeck">';
		/**
		if(isset($this->deck_name)) {
			$html .= '<p><b>'. $this->deck_name .'</b></p>';
		}
		*/
		$html .= '<p><b>Classe: </b>'. $this->hero .'</p>';
		$html .= '<ul>';
		foreach($this->get_cards_list() as $card) {
			$html .= '<li>'. $card["name"] . ' | ' . $card["quantity"] . '</li>';
		}
		$html .= '</ul></div>';
		return $html;
	}

	public function get_deck_name() {
		return $this->deck_name;
	}

	public function set_deck_name($deck_name) {
		$this->deck_name = $deck_name;
	}

	public function get_cards_list() {
		return $this->cards_list;
	}

	public function get_hero() {
		return $this->hero;
	}
	
	public function set_hero($hero) {
		$this->hero = $hero;
	}

	public function get_format() {
		return $this->format;
	}
	
	public function set_format($format) {
		$this->format = $format;
	}
}

?>