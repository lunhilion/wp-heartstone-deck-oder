<?php

/**
 * @since      0.0.1
 * @package    Wp_Heartstone_Deck_Oder
 * @subpackage Wp_Heartstone_Deck_Oder/includes
 * @author     LunHilion <e.sanguin.92@gmail.com>
 */
class Hs_Deck {

	const MAX_CARDS = 30;
	const TITLE_PATTERN = "%s %s (%s) - #%d";
	const TITLE_PATTERN_NO_RANK = "%s %s (%s)";

	private $custom_title = '';
	private $hero;
	private $format;
	private $server;
	private $rank;
	private $archetype;
	private $author;
	private $total_dust = 0;
	private $cards_list = array();
	private $deckstring;
	private $render_column = 2;
	private $four_times_render = false;

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
		$dust_values = new Dust_Values(0); //TODO: da rivedere il costruttore
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
		return self::html_meta_header();
	}

	public function html_render() {
		$html = '<div class="hover-card-div"><img id="hover-card" src="#" style="display: none; top: 0px; left: 0; z-index: 3;"></div>';
		$html .= self::html_column_render($this->render_column);
		return $html;
	}

	private function html_deckstring_box_render($more_class) {
		$html = '<div class="deckstring-box '; 
		if(!empty($more_class)) {
			$html .= $more_class . '-box';
		}
		$html .= '"><input class="deckstring-text" type="text" value="'. $this->deckstring .'"><button class="btn-deck-copy ';
		if(!empty($more_class)) {
			$html .= $more_class . '-btn';
		}
		$html .='" id="deck-copy" data-deck-copy="'. $this->deckstring .'">Copy Deck!</button>
				</div>';

		return $html;
	}

	private function html_column_render($column) {
		$html = '';
		if($column == 1) {
			$d1 = $this->get_cards_list();
			if ($this->four_times_render == false) {
				$html .= '<div class="deck-one-col">';
			} else {
				$html .= '<div class="deck-one-col deck-four-times">';
			}
			$html .= '<div class="deck-metabox">' .
					self::html_meta_header() .
					'</div>';
			$html .= '<ul class="deck-list">';
			foreach($d1 as $card) {
				$html .= '<li dbfid="'. $card["art_id"] .'" class="card-frame ' . strtolower($card["rarity"]) . '-card">' .
							'<span class="card-cost">'. $card["cost"] . '</span>' .
							'<span class="card-name">'. $card["name"] . '</span>' .
							'<span class="card-quantity">'. $card["quantity"] . '</span>' .
							'<span class="card-image"><img src="'. $card["art_url"] . '"></span>' .
							'</li>';
			}
			$html .= '</ul>';
			$html .= self::html_deckstring_box_render('deck-list-one-col');
			$html .= '</div>';

		} else if($column == 2) {
			$d1 = $this->get_class_cards();
			$html .= '<div class="hsdeck">';
			$html .= '<div class="deck-metabox">' .
					self::html_meta_header() .
					'</div>';
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
			$html .= self::html_deckstring_box_render('');
		}
		return $html;

	}

	public function html_meta_header() { //TODO: Utilizzare un ciclo
		$html =
		'<strong>Class: </strong>' .
		'<strong class="meta-highlight">'. strtoupper($this->hero) .'</strong>' ;
		if(!empty($this->format)) {
			$html .= '<strong>  |  Format: </strong>' .
			'<strong class="meta-highlight">'. strtoupper($this->format) .'</strong>';
		}
		if(!empty($this->server)) {
			$html .= '<strong>  |  Server: </strong>' .
			'<strong class="meta-highlight">'. strtoupper($this->server) .'</strong>';
		}
		$html .= '<strong>  |  Dust cost: </strong>' .
		'<strong class="meta-highlight">'. strtoupper($this->total_dust) .'</strong>';
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

	public function get_custom_title() {
		return $this->custom_title;
	}

	public function set_custom_title($custom_title) {
		$this->custom_title = $custom_title;
	}

	public function get_cards_list() {
		return $this->cards_list;
	}

	public function get_hero() {
		return $this->hero;
	}

	public function set_hero($hero) {
		$heroes = new Heroes(0);
		foreach($heroes->get_constants() as $key => $value) {
			if(strcmp($key, $hero) == 0) {
				$this->hero =  $value;
			}
		}
	}

	public function get_deckstring() {
		return $this->deckstring;
	}
	
	public function set_deckstring($deckstring) {
		$this->deckstring = $deckstring;
	}

	public function get_total_dust() {
		return $this->format;
	}

	public function get_format() {
		return $this->format;
	}
	
	public function set_format($format) {
		$this->format = $format;
	}

	public function get_server() {
		return $this->server;
	}
	
	public function set_server($server) {
		$this->server = $server;
	}

	public function get_rank() {
		return $this->rank;
	}
	
	public function set_rank($rank) {
		$this->rank = $rank;
	}

	public function get_render_column() {
		return $this->render_column;
	}
	
	public function set_render_column($render_column) {
		$this->render_column = $render_column;
	}

	public function get_four_times_render() {
		return $this->four_times_render;
	}

	public function set_four_times_render($four_times_render) {
		$this->four_times_render = $four_times_render;
	}

	public function get_archetype() {
		return $this->archetype;
	}
	
	public function set_author($author) {
		$this->author = $author;
	}

	public function get_author() {
		return $this->author;
	}
	
	public function set_archetype($archetype) {
		$this->archetype = $archetype;
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

	public function generate_title() {
		if(empty($this->rank)) {
			return sprintf(self::TITLE_PATTERN_NO_RANK,
						$this->archetype,
						$this->hero,
						$this->author,
					);
		} else {
			return sprintf(self::TITLE_PATTERN,
						$this->archetype,
						$this->hero,
						$this->author,
						$this->rank
					);
		}
	}

	//Todo: aggiungere flag per contare 1 | 2 | all
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