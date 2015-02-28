<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Wdm_Google_Nocaptcha_Recaptcha
 * @author    WisdmLabs <support@wisdmlabs.com>
 * @license   GPL-2.0+
 * @link      http://wisdmlabs.com
 * @copyright 2014 WisdmLabs 
 */

// If uninstall not called from WordPress, then exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

if ( is_multisite() ) {

	$blogs = $wpdb->get_results( "SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A );

	if ( $blogs ) {

		foreach ( $blogs as $blog ) {
			switch_to_blog( $blog[ 'blog_id' ] );
			delete_option( 'wdm_recaptcha_settings' );
			restore_current_blog();
		}
	}
} else {
	delete_option( 'wdm_recaptcha_settings' );
}