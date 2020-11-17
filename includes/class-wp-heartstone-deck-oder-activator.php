<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.0.1
 * @package    Wp_Heartstone_Deck_Oder
 * @subpackage Wp_Heartstone_Deck_Oder/includes
 * @author     LunHilion <e.sanguin.92@gmail.com>
 */
class Wp_Heartstone_Deck_Oder_Activator {

	public static function activate() {

	}

	public static function url_get_contents ($url) {
		if (function_exists('curl_exec')){ 
			$conn = curl_init($url);
			curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
			curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
			$url_get_contents_data = (curl_exec($conn));
			curl_close($conn);
		}elseif(function_exists('file_get_contents')){
			$url_get_contents_data = file_get_contents($url);
		}elseif(function_exists('fopen') && function_exists('stream_get_contents')){
			$handle = fopen ($url, "r");
			$url_get_contents_data = stream_get_contents($handle);
		}else{
			$url_get_contents_data = false;
		}
	return $url_get_contents_data;
	}

}
