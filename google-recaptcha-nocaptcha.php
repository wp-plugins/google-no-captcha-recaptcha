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
 * Version:           4.0.3
 * Author:            WisdmLabs
 * Author URI:        http://wisdmlabs.com
 * Text Domain:       google-nocaptcha-recaptcha-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


$wdm_recaptcha_section = array(
	'site_key'						 => array(
		'name'		 => 'Site Key',
		'type'		 => 'text',
		'default'	 => '',
		'tip'		 => '<br><div class="captcha_setting_text">' . sprintf( __( 'Please enter the Site key provided by Google while %1$s registering your site for reCaptcha service %2$s', "google-nocaptcha-recaptcha-locale" ), '<a href="https://www.google.com/recaptcha/admin#list" target="_blank">', '</a>' ) . '</div>'
	),
	'secret_key'					 => array(
		'name'		 => 'Secret Key',
		'type'		 => 'text',
		'default'	 => '',
		'tip'		 => '<br><div class="captcha_setting_text">' . __( 'Copy the Secret key provided by Google in this textbox', "google-nocaptcha-recaptcha-locale" ) . '</div>'
	),
	'language'						 => array(
		'name'			 => 'Language',
		'type'			 => 'select',
		'option_values'	 => captcha_language_codes(),
		'tip'			 => '<div class="captcha_setting_text">' . __( 'Select the language in which the captcha should be rendered', "google-nocaptcha-recaptcha-locale" ) . '</div>'
	),
	'wdm_custom_unchecked_error_msg' => array(
		'name'		 => 'Custom Error Messages',
		'type'		 => 'text',
		'default'	 => '',
		'tip'		 => '<br><div class="captcha_setting_text">' . __( 'Custom error message to be displayed when NoCaptcha reCaptcha is not checked', "google-nocaptcha-recaptcha-locale" ) . '</i>'
	),
	'wdm_custom_bot_error_msg'		 => array(
		'name'		 => '',
		'type'		 => 'text',
		'default'	 => '',
		'tip'		 => '<br><div class="captcha_setting_text">' . __( 'Custom error message to be displayed when bot is detected', "google-nocaptcha-recaptcha-locale" ) . '</div>'
	),
);

/**
 * contains list of language codes
 * @return array list of language codes supported by google nocaptcha recaptcha
 */
function captcha_language_codes() {
	return array(
		'ar'	 => __( 'Arabic', 'google-nocaptcha-recaptcha-locale' ),
		'bn'	 => __( 'Bengali', 'google-nocaptcha-recaptcha-locale' ),
		'bg'	 => __( 'Bulgarian', 'google-nocaptcha-recaptcha-locale' ),
		'ca'	 => __( 'Catalan', 'google-nocaptcha-recaptcha-locale' ),
		'zh-CN'	 => __( 'Chinese (Simplified)', 'google-nocaptcha-recaptcha-locale' ),
		'zh-TW'	 => __( 'Chinese (Traditional)', 'google-nocaptcha-recaptcha-locale' ),
		'hr'	 => __( 'Croatian', 'google-nocaptcha-recaptcha-locale' ),
		'cs'	 => __( 'Czech', 'google-nocaptcha-recaptcha-locale' ),
		'da'	 => __( 'Danish', 'google-nocaptcha-recaptcha-locale' ),
		'nl'	 => __( 'Dutch', 'google-nocaptcha-recaptcha-locale' ),
		'en-GB'	 => __( 'English (UK)', 'google-nocaptcha-recaptcha-locale' ),
		'en'	 => __( 'English (US)', 'google-nocaptcha-recaptcha-locale' ),
		'et'	 => __( 'Estonian', 'google-nocaptcha-recaptcha-locale' ),
		'fil'	 => __( 'Filipino', 'google-nocaptcha-recaptcha-locale' ),
		'fi'	 => __( 'Finnish', 'google-nocaptcha-recaptcha-locale' ),
		'fr'	 => __( 'French', 'google-nocaptcha-recaptcha-locale' ),
		'fr-CA'	 => __( 'French (Canadian)', 'google-nocaptcha-recaptcha-locale' ),
		'de'	 => __( 'German', 'google-nocaptcha-recaptcha-locale' ),
		'gu'	 => __( 'Gujarati', 'google-nocaptcha-recaptcha-locale' ),
		'de-AT'	 => __( 'German (Austria)', 'google-nocaptcha-recaptcha-locale' ),
		'de-CH'	 => __( 'German (Switzerland)', 'google-nocaptcha-recaptcha-locale' ),
		'el'	 => __( 'Greek', 'google-nocaptcha-recaptcha-locale' ),
		'iw'	 => __( 'Hebrew', 'google-nocaptcha-recaptcha-locale' ),
		'hi'	 => __( 'Hindi', 'google-nocaptcha-recaptcha-locale' ),
		'hu'	 => __( 'Hungarain', 'google-nocaptcha-recaptcha-locale' ),
		'id'	 => __( 'Indonesian', 'google-nocaptcha-recaptcha-locale' ),
		'it'	 => __( 'Italian', 'google-nocaptcha-recaptcha-locale' ),
		'ja'	 => __( 'Japanese', 'google-nocaptcha-recaptcha-locale' ),
		'kn'	 => __( 'Kannada', 'google-nocaptcha-recaptcha-locale' ),
		'ko'	 => __( 'Korean', 'google-nocaptcha-recaptcha-locale' ),
		'lv'	 => __( 'Latvian', 'google-nocaptcha-recaptcha-locale' ),
		'lt'	 => __( 'Lithuanian', 'google-nocaptcha-recaptcha-locale' ),
		'ms'	 => __( 'Malay', 'google-nocaptcha-recaptcha-locale' ),
		'ml'	 => __( 'Malayalam', 'google-nocaptcha-recaptcha-locale' ),
		'mr'	 => __( 'Marathi', 'google-nocaptcha-recaptcha-locale' ),
		'no'	 => __( 'Norwegian', 'google-nocaptcha-recaptcha-locale' ),
		'fa'	 => __( 'Persian', 'google-nocaptcha-recaptcha-locale' ),
		'pl'	 => __( 'Polish', 'google-nocaptcha-recaptcha-locale' ),
		'pt'	 => __( 'Portuguese', 'google-nocaptcha-recaptcha-locale' ),
		'pt-BR'	 => __( 'Portuguese (Brazil)', 'google-nocaptcha-recaptcha-locale' ),
		'pt-PT'	 => __( 'Portuguese (Portugal)', 'google-nocaptcha-recaptcha-locale' ),
		'ro'	 => __( 'Romanian', 'google-nocaptcha-recaptcha-locale' ),
		'ru'	 => __( 'Russian', 'google-nocaptcha-recaptcha-locale' ),
		'sr'	 => __( 'Serbian', 'google-nocaptcha-recaptcha-locale' ),
		'sk'	 => __( 'Slovak', 'google-nocaptcha-recaptcha-locale' ),
		'sl'	 => __( 'Slovenian', 'google-nocaptcha-recaptcha-locale' ),
		'es'	 => __( 'Spanish', 'google-nocaptcha-recaptcha-locale' ),
		'es-419' => __( 'Spanish (Latin America)', 'google-nocaptcha-recaptcha-locale' ),
		'sv'	 => __( 'Swedish', 'google-nocaptcha-recaptcha-locale' ),
		'ta'	 => __( 'Tamil', 'google-nocaptcha-recaptcha-locale' ),
		'te'	 => __( 'Telugu', 'google-nocaptcha-recaptcha-locale' ),
		'th'	 => __( 'Thai', 'google-nocaptcha-recaptcha-locale' ),
		'tr'	 => __( 'Turkish', 'google-nocaptcha-recaptcha-locale' ),
		'uk'	 => __( 'Ukrainian', 'google-nocaptcha-recaptcha-locale' ),
		'ur'	 => __( 'Urdu', 'google-nocaptcha-recaptcha-locale' ),
		'vi'	 => __( 'Vietnamese', 'google-nocaptcha-recaptcha-locale' )
	);
}

/**
 * contains the list of captcha size which we want to support
 * @return array of captcha sizes
 */
function captcha_sizes() {
	return array(
		'1'		 => '1',
		'0.75'	 => '0.85',
		'0.75'	 => '0.75',
		'0.75'	 => '0.65',
		'0.5'	 => '0.5',
		'0.45'	 => '0.45'
	);
}

$wdm_recaptcha_settings = array( 'general' => array(
		'name'	 => '',
		'fields' => $wdm_recaptcha_section,
	)
);

if ( ! defined( 'WDM_RECAPTCHA_OPTION_NAME' ) ) {
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

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-google-recaptcha-nocaptcha-admin.php' );
	add_action( 'plugins_loaded', array( 'Wdm_Google_Nocaptcha_Recaptcha_Admin', 'get_instance' ) );
}

add_action( 'admin_enqueue_scripts', 'enqueue_admin_scripts' );

function enqueue_admin_scripts() {

	wp_register_style( 'wdm_settings_page_css', plugins_url( 'public/assets/css/settings-page-style.css', __FILE__ ) );
	wp_enqueue_style( 'wdm_settings_page_css' );

	wp_register_script( 'wdm_tag_manipultor', plugins_url( 'public/assets/js/tag-manipulator.js', __FILE__ ) );
	wp_enqueue_script( 'wdm_tag_manipultor' );
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
	if ( ! is_admin() ) {
		if ( file_exists( plugin_dir_path( __FILE__ ) . 'public/includes/' . $single_module_slug . '/class-wdm-' . $single_module_slug . '-public.php' ) ) {
			@include_once ( plugin_dir_path( __FILE__ ) . 'public/includes/' . $single_module_slug . '/class-wdm-' . $single_module_slug . '-public.php');
		}
	}
}
