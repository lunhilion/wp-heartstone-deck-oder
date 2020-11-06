<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/lunhilion/
 * @since      0.0.1
 *
 * @package    Wp_Heartstone_Deck_Oder
 * @subpackage Wp_Heartstone_Deck_Oder/admin/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap">
	<p> Aggiungi un Mazzo </p>
	<form name="deck-code" id="deck-code" method="post">
		Nome Mazzo: <input type="text" name="deck-name"><br />
		Codice Mazzo: <input type="text" name="deck-code"><br />
		<input type="submit" name="my_submit" value="Salva">
	</form>
</div>
