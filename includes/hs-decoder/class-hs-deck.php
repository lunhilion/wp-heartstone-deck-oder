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
	private $total_dust;
	private $cards_list = array();
	private $deckstring;

	public function __construct() {}

	public function add_card($dbfid, $name, $quantity, $cost, $rarity, $art_url, $card_class, $art_id) {
		array_push($this->cards_list, array(
			'dbfId' => $dbfid,
			'name' => $name,
			'quantity' => $quantity,
			'cost' => $cost,
			'rarity' => $rarity,
			'art_url' => $art_url,
			'cardClass' => $card_class,
			'art_id' => $art_id
		));
		$dust_values = new Dust_Values();
		foreach($dust_values->get_constants() as $k => $v) {
			if(strcmp($rarity, $k) == 0) {
				if($quantity == 1) {
					$this->total_dust += $v;
				} else {
					$this->total_dust += $v * 2;
				}
			}
		}
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

	public function html_excerpt() {
		$html = '<strong>Class: </strong>' .
		'<strong class="meta-highlight">'. $this->hero .'</strong>' .
		'<strong>  |  Format: </strong>' .
		'<strong class="meta-highlight">'. $this->format .'</strong>' .
		'<strong>  |  Dust cost: </strong>' .
		'<strong class="meta-highlight">'. $this->total_dust .'</strong>';
		return $html;
	}

	public function html_render() {
		$html = '<div class="hover-card-div"><img id="hover-card" src="#" style="display: none; top: 0px; left: 0; z-index: 3;"></div>';
		$html .= '<div class="hsdeck">';
		$html .= '<div class="deck-metabox">' .
					'<strong>Class: </strong>' .
					'<strong class="meta-highlight">'. $this->hero .'</strong>' .
					'<strong>  |  Format: </strong>' .
					'<strong class="meta-highlight">'. $this->format .'</strong>' .
					'<strong>  |  Dust cost: </strong>' .
					'<strong class="meta-highlight">'. $this->total_dust .'</strong>' .
					'</div>';

		//$html .= '<p><b>Classe: </b>'. $this->hero .'</p>';
		$d1 = $this->get_class_cards();
		$html .= '<div class="deck-col">';
		$html .= '<div class="deck-header">
					<div class="dh-name">
					<strong>Class ('. self::count_cards($d1) .')</strong>
					</div></div>';
		$html .= '<ul class="deck-list">';
		foreach($d1 as $card) {
			$html .= '<li dbfid="'. $card["art_id"] .'" class="card-frame ' . strtolower($card["rarity"]) . '-card">' .
						'<span class="card-cost">'. $card["cost"] . '</span>' .
						'<span class="card-name">'. $card["name"] . '</span>' .
						'<span class="card-quantity">'. $card["quantity"] . '</span>' .
						'<span class="card-image"><img src="'. $card["art_url"] . '"></span>' .
						'</li>';
		}
		$html .= '</div>';
		$d2 = $this->get_neutral_cards();
		$html .= '<div class="deck-col">';
		$html .= '<div class="deck-header">
					<div class="dh-name">
					<strong>Neutral ('. self::count_cards($d2) .')</strong>
					</div></div>';
		$html .= '<ul class="deck-list">';
		foreach($d2 as $card) {
			$html .= '<li dbfid="'. $card["art_id"] .'" class="card-frame ' . strtolower($card["rarity"]) . '-card">' .
						'<span class="card-cost">'. $card["cost"] . '</span>' .
						'<span class="card-name">'. $card["name"] . '</span>' .
						'<span class="card-quantity">'. $card["quantity"] . '</span>' .
						'<span class="card-image"><img src="'. $card["art_url"] . '"></span>' .
						'</li>';
		}
		$html .= '</div>';
		$html .= '</ul>';
		$html .= '</div>';

		$html .= '<div class="deckstring-box">
					<input class="deckstring-text" type="text" value="'. $this->deckstring .'">
					<button class="btn-deck-copy" id="deck-copy" data-deck-copy="'. $this->deckstring .'">Copia il deck!</button>';

		// Last content div
		$html .= '</div>';
		

		return $html;
	}

	public function get_class_cards() {
		$temp = array();
		foreach($this->get_cards_list() as $card) {
			if($card["cardClass"] != "NEUTRAL") {
				$temp[] = $card;
			}
		}
		return $temp;
	}

	public function get_neutral_cards() {
		$temp = array();
		foreach($this->get_cards_list() as $card) {
			if($card["cardClass"] == "NEUTRAL") {
				$temp[] = $card;
			}
		}
		return $temp;
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
	
	public function set_deckstring($string) {
		$this->deckstring = $string;
	}

	public function get_deckstring() {
		return $this->deckstring;
	}

	public function set_hero($hero) {
		$this->hero = $hero;
	}

	public function get_format() {
		return $this->format;
	}

	public function get_total_dust() {
		return $this->format;
	}
	
	public function set_format($format) {
		$this->format = $format;
	}

	public function set_order($order) {
		if($order != "") {
			$cost = array_column($this->cards_list, 'cost');
			if($order == "ASC") {
				array_multisort($cost, SORT_ASC, $this->cards_list);
			} else if($order == "DESC"){
				array_multisort($cost, SORT_DESC, $this->cards_list);
			}
		}
	}

	public static function count_cards($array) {
		$count = 0;
		foreach($array as $card) {
			if($card["quantity"] == 2) {
				$count += 2;
			} else {
				$count++;
			}
		}
		return $count;
	}
}

?>