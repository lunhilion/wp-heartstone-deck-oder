<?php

/**
 * @since      0.0.1
 * @package    Wp_Heartstone_Deck_Oder
 * @subpackage Wp_Heartstone_Deck_Oder/includes
 * @author     LunHilion <e.sanguin.92@gmail.com>
 */
class Hs_Serializer {

	public static function deserialize($deckstring) {
		$array = self::base64_to_int($deckstring);
		$deck = self::build_deck($array);
		$deck->set_deckstring($deckstring);
		$deck->set_order("ASC");
		return $deck;
	}

	private static function build_deck($decoded_array) {
		$api = Hs_Api::get_instance();
		$deck = new Hs_deck();
		$deck->set_hero($api->get_hero($decoded_array[DeckString_Positions::HEROES]));
		$single_cards = $decoded_array[DeckString_Positions::SINGLE_CARDS_BIT];
		$double_cards = $decoded_array[DeckString_Positions::SINGLE_CARDS_BIT + $single_cards + 1];
		$index = DeckString_Positions::SINGLE_CARDS_BIT + 1;
		for($i = 0; $i < $single_cards; $i++) {
			$temp_card = $api->get_card($decoded_array[$index]);
			$deck->add_card($temp_card["dbfId"], $temp_card["name"], "1", $temp_card["cost"], $temp_card["rarity"], $api->get_card_art_link($temp_card["id"]), $temp_card["cardClass"], $temp_card["id"]);
			$index++;
		}
		$index++;
		for($i = 0; $i < $double_cards ; $i++) {
			$temp_card = $api->get_card($decoded_array[$index]);
			$deck->add_card($temp_card["dbfId"], $temp_card["name"], "2", $temp_card["cost"], $temp_card["rarity"], $api->get_card_art_link($temp_card["id"]), $temp_card["cardClass"], $temp_card["id"]);
			$index++;
		}
		return $deck;
	}

	private static function base64_to_int($base64_string) {
		//return self::varint_decode(self::to_binary(base64_decode($base64_string)));
		return self::binary_to_int(self::varint_decode(self::to_binary(base64_decode($base64_string))));
	}

	private static function to_binary($decoded_base64) {
		$temp = array();
		foreach(str_split($decoded_base64) as $c)
    		$temp[] = sprintf("%08b", ord($c));
		return $temp;
	}

	private static function binary_to_int($binary_array) {
		$temp = array();
		foreach($binary_array as $binary) {
			$temp[] = (int) bindec($binary);
		}
		return $temp;
	}

	private static function varint_decode($array) {
		$temp = array();
		$value = '';
		$i = 0;
		while($i < count($array)) {
			if(substr($array[$i], 0, 1) == 1) {
				$value = substr($array[$i], 1);
				$i++;
				while(substr($array[$i], 0, 1) == 1) {
					$value = substr($array[$i], 1) . $value;
					$i++;
				}
				$value = substr($array[$i], 1) . $value;
				$temp[] = $value;
				$value = '';
				$i++;
			} else {
				$temp[] = substr($array[$i], 1);
				$i++;
			}

		}
		return $temp;
	}
	
}
?>