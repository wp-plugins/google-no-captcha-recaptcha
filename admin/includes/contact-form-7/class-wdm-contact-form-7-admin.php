<?php

/**
 * Generates a settings for Google's No CAPTCHA reCAPTCHA while creating a form in Contact Form 7
 *
 * @package   Wdm_Contact_Form_7_Admin
 * @author    WisdmLabs <support@wisdmlabs.com>
 * @license   GPL-2.0+
 * @link      http://wisdmlabs.com
 * @copyright 2014 WisdmLabs 
 */
if ( !class_exists( 'Wdm_Contact_Form_7_Admin' ) ) {

	class Wdm_Contact_Form_7_Admin {

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
			add_action( 'admin_init', array( $this, 'cf7_nocaptcha_tag_generator' ), 55 );
		}

		/*
		 * Generates a new tag
		 */

		public function cf7_nocaptcha_tag_generator() {
			if ( !function_exists( 'wpcf7_add_tag_generator' ) )
				return;

			wpcf7_add_tag_generator( 'recaptcha', __( 'No CAPTCHA reCAPTCHA', 'contact-form-7' ), 'cf7_nocaptcha_pane', array( $this, 'cf7_nocaptcha_pane' ) );
		}

		/*
		 * Shows a settings page on Form Builder plugin of Contact Form 7
		 * 
		 */

		public static function cf7_nocaptcha_pane( $contact_form ) {

			@include_once dirname( dirname( dirname( __FILE__ ) ) ) . '/views/contact-form-7/create_pane.php';
		}

	}

	Wdm_Contact_Form_7_Admin::get_instance();
}

