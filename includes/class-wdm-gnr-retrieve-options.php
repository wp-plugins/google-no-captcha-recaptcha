<?php

/*
 * Retreives settins from the database
 * 
 * @package   Wdm_Class_Gnr_Retrieve_Options
 * @author    WisdmLabs <support@wisdmlabs.com>
 * @license   GPL-2.0+
 * @link      http://wisdmlabs.com
 * @copyright 2014 WisdmLabs 
 */
if ( !class_exists( 'Wdm_Class_Gnr_Retrieve_Options' ) ) {

	class Wdm_Class_Gnr_Retrieve_Options {

		/**
		 * Instance of this class.
		 *
		 * @since    1.0.0
		 *
		 * @var      object
		 */
		protected static $instance = null;
		public $options = null;

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

		private function __construct() {
			$this->options = maybe_unserialize( get_option( WDM_RECAPTCHA_OPTION_NAME ) );
		}

		/*
		 * Get Option Value of specific setting
		 * 
		 * @return mixed If setting exists, value of it is returned.
		 */

		public function get_option( $setting_name ) {
			if ( $this->options == NULL ) {
				$this->options = maybe_unserialize( get_option( WDM_RECAPTCHA_OPTION_NAME ) );
			}

			if ( is_array($this->options) && !empty($this->options) && array_key_exists( $setting_name, $this->options ) ) {
				return $this->options [ $setting_name ];
			} else {
				return false;
			}
		}

	}

}
