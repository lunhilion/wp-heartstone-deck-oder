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
        foreach($constants as $k => $v) {
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

	public function get_constants() {
		$my_class = new ReflectionClass(get_class($this));
		$array = $my_class->getConstants();
		ksort($array);
        return $array;
	}
}
class Heroes extends Base_Enum {

	const DRUID = "Druid";
	const HUNTER = "Hunter";
	const MAGE = "Mage";
	const PALADIN = "Paladin";
	const PRIEST = "Priest";
	const ROGUE = "Rogue";
	const SHAMAN = "Shaman";
	const WARLOCK = "Warlock";
	const WARRIOR = "Warrior";
	const DEMONHUNTER = "Demon Hunter";

	public function __construct($id) {
		parent::__construct($id);
	}
}

class Game_Types extends Base_Enum {
	
	const UNKNOWN = '';
	const ARENA = 'Arena';
	const DUELS = 'Duels';
	const STANDARD = 'Standard';
	const WILD = 'Wild';

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

class Rarity extends Base_Enum {
	const COMMON = 0;
	const RARE = 1;
	const EPIC = 2;
	const LEGENDARY = 3;

	public function __construct($id) {
		parent::__construct($id);
	}
}

class Servers extends Base_Enum {
	const UNKNOWN = '';
	const NORTH_AMERICA = 'NA';
	const EUROPE = 'EU';
	const ASIA_PACIFIC = 'AP';
	const CHINA = 'CN';

	public function __construct($id) {
		parent::__construct($id);
	}
}

class Dust_Values extends Base_Enum {
	const BASE = 0;
	const COMMON = 40;
	const RARE = 100;
	const EPIC = 400;
	const LEGENDARY = 1600;

	public function __construct($id) {
		parent::__construct($id);
	}
}

?>