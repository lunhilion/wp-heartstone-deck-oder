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

$content = '';
if(isset($_POST['export_html_submit'])) {
	$deck = Hs_Serializer::deserialize($_POST['deck-code']);
	$deck->set_deck_name($_POST['deck-name']);
	$content = $deck->html_render();
}
?>

<h1><?php _e( 'Heartstone DeckOder', 'WpAdminStyle' ); ?></h1>

<div class="wrap">
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<h2><span><?php esc_attr_e( 'Aggiungi un nuovo Mazzo', 'WpAdminStyle' ); ?></span></h2>

						<div class="inside">
							<form name="deck-code" id="deck-code" method="post">
								Nome Mazzo:   <input type="text" class="regular-text" name="deck-name"><br /><br />
								Codice Mazzo: <input type="text" class="regular-text" name="deck-code"><br /><br />
								<input class="button-primary" type="submit" name="my_submit" value="Salva">
								<input class="button-primary" type="submit" name="export_html_submit" value="Visualizza html">
							</form>
						</div>
					</div>
				</div>
			</div>

			<div id="post-body-content2">
				<textarea id="" name="" cols="80" rows="10" class="large-text" style="margin-top: 0px; margin-bottom: 0px; height: 205px;"><?php echo $content; ?></textarea>
			</div>

			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox">
						<h2><span><?php esc_attr_e(
									'Sidebar Content Header', 'WpAdminStyle'
								); ?></span></h2>

						<div class="inside">
						<form name="card-import" id="card-import" method="post">
								<input class="button-primary" type="submit" name="my_submit_import" value="Importa Carte">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>
</div>
