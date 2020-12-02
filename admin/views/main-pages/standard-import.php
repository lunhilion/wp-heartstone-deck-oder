<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="wrap">
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<div class="table-deck-header"><h2><?php esc_attr_e( 'Aggiungi un nuovo mazzo', 'WpAdminStyle' ); ?></h2></div>
						<div class="inside">
						<form action="" method="post">
							<table class="form-table">
								<tbody>
								<tr valign="top">
									<th scope="row">
										<label for="deck-code">Codice Mazzo</label>
									</th>
									<td>
										<input type="text" name="deck-code" value="" required="true">
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="deck-title">Titolo Mazzo</label>
									</th>
									<td>
										<input type="text" name="deck-title" value="" required="true">
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="deck-format">Formato</label>
									</th>
									<td>
										<?php Wp_Heartstone_Deck_Oder_Admin::create_combobox('format', new Game_Types(0), Game_Types::STANDARD); ?>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="deck-server">Server</label>
									</th>
									<td>
										<?php Wp_Heartstone_Deck_Oder_Admin::create_combobox('server', new Servers(0), Servers::UNKNOWN); ?>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="deck-column">Colonna Singola</label>
									</th>
									<td>
									<input type="checkbox" name="deck-column" class="form-checkbox" value="1">
									</td>
								</tr>
								</tbody>
							</table>
							<div class="table-deck-footer">
									<input class="button-primary" type="submit" name="submit_standard" value="Salva Mazzo">
									<input class="button-primary" type="submit" name="export_html_submit" value="Visualizza html">
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>

			<div id="post-body-content2">
				<textarea id="" name="" cols="80" rows="10" class="large-text html-box"><?php if(isset($_POST['html_content'])) echo $_POST['html_content']; ?></textarea>
			</div>

</div>

