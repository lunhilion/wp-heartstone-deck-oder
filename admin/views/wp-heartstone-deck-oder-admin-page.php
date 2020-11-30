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


$content = '';
if(isset($_POST['export_html_submit'])) {
	$deck = Hs_Serializer::deserialize($_POST['deck-code']);
	$deck->set_deck_name($_POST['deck-name']);
	$content = $deck->html_render();
}

?>

<h1><?php _e( 'Heartstone DeckOder', 'WpAdminStyle' ); ?></h1>

<?php
if(isset($_GET['tab'])) {
	Wp_Heartstone_Deck_Oder_Admin::create_admin_page($_GET['tab']);
} else {
	Wp_Heartstone_Deck_Oder_Admin::create_admin_page(NULL);
}

?>



