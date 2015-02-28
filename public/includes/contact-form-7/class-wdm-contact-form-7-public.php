<?php

if ( ! class_exists( 'Wdm_Contact_Form_7_Public' ) ) {

	class Wdm_Contact_Form_7_Public {

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
			add_filter( 'wpcf7_validate_recaptcha', array( $this, 'recaptcha_validation_filter' ), 10, 2 );
			add_filter( 'wpcf7_messages', array( $this, 'recaptcha_messages' ) );
		}

		/*
		 * Validates if form has been submitted correctly and Captcha value is not empty
		 * 
		 * It throws error, if form fields are not filled properly, captcha value is not filled 
		 * or captcha is not filled properly.
		 * 
		 * @param $result Results array passed by Contact Form 7
		 * @param $tag Current tag being used
		 * @return array returns array of success and error messages
		 */

		public function recaptcha_validation_filter( $result, $tag ) {
			global $wdm_recaptcha_settings_values;

			$site_key	 = $wdm_recaptcha_settings_values->get_option( 'general_site_key' );
			$secret_key	 = $wdm_recaptcha_settings_values->get_option( 'general_secret_key' );

			//if site key and secret key are available, then validate captcha
			if ( ! empty( $site_key ) && ! empty( $secret_key ) ) {
				$tag = new WPCF7_Shortcode( $tag );

				$type	 = $tag->type;
				$name	 = ! empty( $tag->name ) ? $tag->name : 'recaptcha';

				$recaptcha_value = isset( $_POST[ 'g-recaptcha-response' ] ) ? (string) $_POST[ 'g-recaptcha-response' ] : '';
			    
				//cf7 4.1 replaced results array structure to object  
				$result_type	 = gettype( $result );
				if ( $result_type === 'object' ) {
					if ( 0 == strlen( trim( $recaptcha_value ) ) ) {   //recaptcha is uncheked
						$result->invalidate( $tag, wpcf7_get_message( 'no_re_uncheked' ) );
					} else {
						$captcha_value = $this->check_recaptcha( $recaptcha_value );
						if ( ! $captcha_value ) {  //google returned false
							$result->invalidate( $tag, wpcf7_get_message( 'no_re_bot_detected' ) );
						}
					}
				} else {

					if ( 0 == strlen( trim( $recaptcha_value ) ) ) {   //recaptcha is uncheked
						$result[ 'valid' ]	 = false;
						$reason				 = array( $name => wpcf7_get_message( 'no_re_uncheked' ) );
						$result[ 'reason' ]	 = array_merge( $result[ 'reason' ], $reason );
					} else {
						$captcha_value = $this->check_recaptcha( $recaptcha_value );
						if ( ! $captcha_value ) {  //google returned false 
							$result[ 'valid' ]	 = false;
							$reason				 = array( $name => wpcf7_get_message( 'no_re_bot_detected' ) );
							$result[ 'reason' ]	 = array_merge( $result[ 'reason' ], $reason );
						}

						if ( $captcha_value && true == $result[ 'valid' ] ) {
							//reset captcha if form was submitted successfully
						}
					}
				}
			}
			return $result;
		}

		/*
		 * Checks if captcha value is filled properly and returns TRUE or FALSE accordingly
		 */

		function check_recaptcha( $recaptcha_value ) {
			global $wdm_recaptcha_settings_values;
			$secret_key = $wdm_recaptcha_settings_values->get_option( 'general_secret_key' );

			if ( isset( $_COOKIE[ 'wdm_cf7_cookie' ] ) && hash( 'sha512', $_POST[ 'g-recaptcha-response' ] . $secret_key ) == $_COOKIE[ 'wdm_cf7_cookie' ] ) {
				return true;
			}

			if ( empty( $secret_key ) ) {
				return false;
			}

			$no_ssl_array = array(
				'ssl' => array(
					'verify_peer'		 => false,
					'verify_peer_name'	 => false
				)
			);

			//complusory for 5.6
			$ctx		 = stream_context_create( $no_ssl_array );
			$json_reply	 = file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret_key . "&response=" . $recaptcha_value, false, $ctx );

			$reply_obj = json_decode( $json_reply );

			if ( $reply_obj->success == 1 ) {
				setcookie( 'wdm_cf7_cookie', hash( 'sha512', $_POST[ 'g-recaptcha-response' ] . $secret_key ), strtotime( '+3 minutes' ) );
				return true;
			}
			return false;
		}

		/*
		 * Messages to be shown if validation of captcha fails
		 * 
		 * @param array Array of Messages
		 */

		function recaptcha_messages( $messages ) {
			return array_merge( $messages, array(
				'no_re_uncheked'	 => array(
					'description'	 => __( "No CAPTCHA reCAPTCHA is unchecked", "google-nocaptcha-recaptcha-locale" ),
					'default'		 => __( 'No CAPTCHA reCAPTCHA is unchecked, Check to proceed', "google-nocaptcha-recaptcha-locale" )
				),
				'no_re_bot_detected' => array(
					'description'	 => __( "Your activity seems like a bot", "google-nocaptcha-recaptcha-locale" ),
					'default'		 => __( 'It seems that you are a bot, Please try again.', "google-nocaptcha-recaptcha-locale" )
				) )
			);
		}

		/*
		 * Shows noCpatcha reCaptcha box on the frontend
		 * 
		 * @param object $tag Current tag being used
		 * @return string HTML to be shown on the frontend in returned
		 */

		public static function nocaptcha_shortcode_handler( $tag ) {
			$html = '';

			global $wdm_recaptcha_settings_values;

			$site_key	 = $wdm_recaptcha_settings_values->get_option( 'general_site_key' );
			$secret_key	 = $wdm_recaptcha_settings_values->get_option( 'general_secret_key' );

			if ( trim( $site_key ) != '' && trim( $secret_key ) != '' ) {
				$tag					 = new WPCF7_Shortcode( $tag );
				if ( empty( $tag->name ) )
					return '';
				$validation_error		 = wpcf7_get_validation_error( $tag->name );
				if ( $validation_error )
					$class .= ' wpcf7-not-valid';
				$atts[ 'aria-invalid' ]	 = $validation_error ? 'true' : 'false';

				wp_enqueue_script( 'wdm_render_recaptcha', plugins_url( '/assets/js/render_recaptcha.js', dirname( dirname( __FILE__ ) ) ), array(), false, true );
				if ( $tag->has_option( 'theme:dark' ) ) {
					wp_localize_script( 'wdm_render_recaptcha', 'wdm_recaptcha', array( 'sitekey' => $site_key, 'theme' => 'dark' ) );
				} else {
					wp_localize_script( 'wdm_render_recaptcha', 'wdm_recaptcha', array( 'sitekey' => $site_key, 'theme' => 'light' ) );
				}
				if ( is_ssl() ) {
					$protocol_to_be_used = 'https://';
				} else {
					$protocol_to_be_used = 'http://';
				}
				wp_register_script( 'google-nocaptcha-recaptcha-api', "{$protocol_to_be_used}www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit", array( 'wdm_render_recaptcha' ), '1.0.0', false );
				wp_enqueue_script( 'google-nocaptcha-recaptcha-api' );
				$class	 = wpcf7_form_controls_class( $tag->type );
				$atts	 = array();

				$atts[ 'class' ]	 = "wdm-nocapt-recapt " . $tag->get_class_option( $class );
				$atts[ 'id' ]		 = 'wdm-nocapt-recapt-id';
				$atts[ 'tabindex' ]	 = $tag->get_option( 'tabindex', 'int', true );
				$atts[ 'type' ]		 = 'recaptcha';


				$atts = wpcf7_format_atts( $atts );

				$html = sprintf( '<div %1$s"></div>', $atts );


				if ( isset( $validation_error ) ) {
					$html .= sprintf(
					'<span class="wpcf7-form-control-wrap %1$s">%2$s</span>', sanitize_html_class( $tag->name ), $validation_error );
					wp_enqueue_script( 'google-nocaptcha-recaptcha-api' );
				}
			}
			return $html;
		}

	}

	Wdm_Contact_Form_7_Public::get_instance();
}

