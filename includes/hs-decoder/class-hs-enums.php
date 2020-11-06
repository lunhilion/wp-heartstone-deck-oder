<?php

/**
 * @since      0.0.1
 * @package    Wp_Heartstone_Deck_Oder
 * @subpackage Wp_Heartstone_Deck_Oder/includes
 * @author     LunHilion <e.sanguin.92@gmail.com>
 */

class Base_Enum {
	private $key;
	private $value;

	public function __construct($i)
    {
        $my_class = new ReflectionClass(get_class($this));
        $constants = $my_class->getConstants();
        foreach($constants as $k=>$v) {
            if($i == $v) {
                $this->key = $v;
                $this->value = $k;
                break;
            }
        }
        if(is_null($this->value)) {
            throw new InvalidArgumentException("Parametro invalido.");
        }
	}
	
	public function get_value() {
		return $this->value;
	}
	public function get_key() {
		return $this->key;
	}
}
class Heroes extends Base_Enum {

	const INVALID = 0;
	const DRUID = 2;
	const HUNTER = 3;
	const MAGE = 4;
	const PALADIN = 5;
	const PRIEST = 6;
	const ROGUE = 7;
	const SHAMAN = 8;
	const WARLOCK = 9;
	const WARRIOR = 10;
	const DEAMON_HUNTER = 14;

	public function __construct($id) {
		parent::__construct($id);
	}
}

class Game_Types extends Base_Enum {

	const INVALID = 0;
	const STANDARD = 2;

	public function __construct($id) {
		parent::__construct($id);
	}
}

class DeckString_Positions extends Base_Enum {

	const RESERVED = 0;
	const VERSION = 1;
	const GAME_TYPE = 2;
	const HEROES_BIT = 3;
	const HEROES = 4;
	const SINGLE_CARDS_BIT = 5;

	public function __construct($id) {
		parent::__construct($id);
	}
}

?>