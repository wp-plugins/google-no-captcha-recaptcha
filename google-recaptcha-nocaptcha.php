<?php

/**
 * @package   Wdm_Google_Nocaptcha_Recaptcha
 * @author    WisdmLabs <support@wisdmlabs.com>
 * @license   GPL-2.0+
 * @link      http://wisdmlabs.com
 * @copyright 2014 WisdmLabs 
 *
 * Plugin Name:       Google No CAPTCHA reCAPTCHA by WisdmLabs
 * Description:       The plugin adds a No CAPTCHA reCAPTCHA tag in Contact Form 7, which can be used to include a No CAPTCHA reCAPTCHA anti-spam field.
 * Version:           1.1.1
 * Author:            WisdmLabs
 * Author URI:        http://wisdmlabs.com
 * Text Domain:       google-nocaptcha-recaptcha-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}
$wdm_recaptcha_section = array(
	'site_key'	 => array(
		'name'		 => 'Site Key',
		'type'		 => 'text',
		'default'	 => '',
		'tip'		 => '<i>' . sprintf(__( 'Please enter the Site key provided by Google while %1$s registering your site for reCaptcha service %2$s', "google-nocaptcha-recaptcha-locale" ), '<a href="https://www.google.com/recaptcha/admin#list" target="_blank">', '</a>') . '</i>'
	),
	'secret_key' => array(
		'name'		 => 'Secret Key',
		'type'		 => 'text',
		'default'	 => '',
		'tip'		 => '<i>' . __( 'Copy the Secret key provided by Google in this textbox', "google-nocaptcha-recaptcha-locale" ) . '</i>'
	),
);

$wdm_recaptcha_settings = array( 'general' => array(
		'name'	 => '',
		'fields' => $wdm_recaptcha_section,
	)
);

if ( !defined( 'WDM_RECAPTCHA_OPTION_NAME' ) ) {
	define( 'WDM_RECAPTCHA_OPTION_NAME', 'wdm_recaptcha_settings' );
}
/* ----------------------------------------------------------------------------*
 * Public-Facing Functionality
 * ---------------------------------------------------------------------------- */

require_once( plugin_dir_path( __FILE__ ) . 'includes/class-wdm-gnr-retrieve-options.php' );
$wdm_recaptcha_settings_values = Wdm_Class_Gnr_Retrieve_Options::get_instance();
require_once( plugin_dir_path( __FILE__ ) . 'public/class-wdm-google-nocaptcha-recaptcha.php' );


add_action( 'plugins_loaded', array( 'Wdm_Google_Nocaptcha_Recaptcha', 'get_instance' ) );
/* ----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 * ---------------------------------------------------------------------------- */

if ( is_admin() && (!defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-google-recaptcha-nocaptcha-admin.php' );
	add_action( 'plugins_loaded', array( 'Wdm_Google_Nocaptcha_Recaptcha_Admin', 'get_instance' ) );
}

/*
 * Enable NoCaptcha ReCaptcha for specific modules. By default enabled for all modules
 * In this associative array, value is name of the folder name for respective module
 * 
 * @since    1.0.0
 * 
 */

$wdm_gnr_enabled_modules = apply_filters( 'enabled_modules', array(
	'Contact Form 7' => 'contact-form-7'
)
);

//include files of all enabled modules. 
foreach ( $wdm_gnr_enabled_modules as $single_module_name => $single_module_slug ) {
	//include files required on admin side
	if ( is_admin() ) {
		if ( file_exists( plugin_dir_path( __FILE__ ) . 'admin/includes/' . $single_module_slug . '/class-wdm-' . $single_module_slug . '-admin.php' ) ) {
			@include_once ( plugin_dir_path( __FILE__ ) . 'admin/includes/' . $single_module_slug . '/class-wdm-' . $single_module_slug . '-admin.php');
		}
	}
	
	//include files required on admin side as well as on frontend
	if ( file_exists( plugin_dir_path( __FILE__ ) . 'includes/' . $single_module_slug . '/class-wdm-' . $single_module_slug . '.php' ) ) {
		@include_once ( plugin_dir_path( __FILE__ ) . 'includes/' . $single_module_slug . '/class-wdm-' . $single_module_slug . '.php');
	}

	//include files required on frontend
	if ( !is_admin() ) {
		if ( file_exists( plugin_dir_path( __FILE__ ) . 'public/includes/' . $single_module_slug . '/class-wdm-' . $single_module_slug . '-public.php' ) ) {
			@include_once ( plugin_dir_path( __FILE__ ) . 'public/includes/' . $single_module_slug . '/class-wdm-' . $single_module_slug . '-public.php');
		}
	}
}