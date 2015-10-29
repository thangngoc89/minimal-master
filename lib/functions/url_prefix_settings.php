<?php
/**
 * Social Settings
 *
 * This file registers the Social settings to the Theme Settings, to be used in the nav bar.
 *
 * @package      Client Name
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
/**
 * Register Defaults
 * @author Bill Erickson
 * @link http://www.billerickson.net/genesis-theme-options/
 *
 * @param array $defaults
 * @return array modified defaults
 *
 */
 function kn_url_prefix_defaults( $defaults ) {
 	$defaults['url_prefix'] = '';
 	$defaults['url_prefix_include_hosts'] = '';
 	return $defaults;
 }
 add_filter( 'genesis_theme_settings_defaults', 'kn_url_prefix_defaults' );

/**
 * Sanitization
 * @author Bill Erickson
 * @link http://www.billerickson.net/genesis-theme-options/
 *
 */
function kn_url_prefix_sanitization_filters() {
	genesis_add_option_filter( 'no_html', GENESIS_SETTINGS_FIELD,
		array(
			'url_prefix',
			'url_prefix_include_hosts',
		) );
}
add_action( 'genesis_settings_sanitizer_init', 'kn_url_prefix_sanitization_filters' );
/**
 * Register Metabox
 * @author Bill Erickson
 * @link http://www.billerickson.net/genesis-theme-options/
 *
 * @param string $_genesis_theme_settings_pagehook
 */
function kn_register_url_prefix_settings_box( $_genesis_theme_settings_pagehook ) {
	add_meta_box('kn_url_prefix_settings', 'URL prefix', 'kn_url_prefix_settings_box', $_genesis_theme_settings_pagehook, 'main', 'high');
}
add_action('genesis_theme_settings_metaboxes', 'kn_register_url_prefix_settings_box');
/**
 * Create Metabox
 * @author Bill Erickson
 * @link http://www.billerickson.net/genesis-theme-options/
 *
 */
function kn_url_prefix_settings_box() {
	?>
	<p>URL prefix:<br />
	<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[url_prefix]" value="<?php echo esc_attr( genesis_get_option('url_prefix') ); ?>" size="50" /> </p>
	<p>Include hosts:<br />
	<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[url_prefix_include_hosts]" value="<?php echo esc_attr( genesis_get_option('url_prefix_include_hosts') ); ?>" style="width: 100%" /> </p>
	<?php
}
