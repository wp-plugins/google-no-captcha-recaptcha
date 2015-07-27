<?php

/*
 * Registers a new shortcode in Contact Form 7
 * 
 * @package   Wdm_Contact_Form_7
 * @author    WisdmLabs <support@wisdmlabs.com>
 * @license   GPL-2.0+
 * @link      http://wisdmlabs.com
 * @copyright 2014 WisdmLabs 
 */

if ( !class_exists( 'Wdm_Contact_Form_7' ) ) {

	class Wdm_Contact_Form_7 {

		/**
		 * Instance of this class.
		 *
		 * @since    1.0.0
		 *
		 * @var      object
		 */
		protected static $instance = null;

		/**
		 * Return an instance of this class.
		 *
		 * @since     1.0.0
		 *
		 * @return    object    A single instance of this class.
		 */
		public static function get_instance() {

			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		private function __construct() {
			add_action( 'wpcf7_init', array( $this, 'add_nocaptcha_shortcode' ) );
		}

		/*
		 * Registers New shortcode in Contact Form 7. This is displayed while creating
		 * a new form in Contact Form 7
		 */

		public function add_nocaptcha_shortcode() {
			wpcf7_add_shortcode( 'recaptcha', array( 'Wdm_Contact_Form_7_Public', 'nocaptcha_shortcode_handler' ), true );
		}

	}

	Wdm_Contact_Form_7::get_instance();
}
