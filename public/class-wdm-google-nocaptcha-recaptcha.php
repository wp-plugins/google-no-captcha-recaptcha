<?php

/**
 * Google NoCaptcha Recaptcha by WisdmLabs.
 *
 * @package   Wdm_Google_Nocaptcha_Recaptcha
 * @author    WisdmLabs <support@wisdmlabs.com>
 * @license   GPL-2.0+
 * @link      http://wisdmlabs.com
 * @copyright 2014 WisdmLabs 
 */
class Wdm_Google_Nocaptcha_Recaptcha {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 * 
	 * Unique identifier for  plugin.
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'google-nocaptcha-recaptcha';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug . "-locale";

		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		if ( ! defined( 'WDM_LAND_DIR' ) ) {
			define( 'WDM_LAND_DIR', dirname( dirname( __FILE__ )  ) . "/languages/");
		}
		load_textdomain( $domain, WDM_LAND_DIR . $domain . '-' . $locale . '.mo' );
	}

}
