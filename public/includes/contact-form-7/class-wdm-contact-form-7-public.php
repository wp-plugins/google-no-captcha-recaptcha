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

				$type	 = $tag->name;
				$name	 = ! empty( $tag->name ) ? $tag->name : 'recaptcha';

				$recaptcha_value = isset( $_POST[ 'g-recaptcha-response' ] ) ? (string) $_POST[ 'g-recaptcha-response' ] : '';

				//cf7 4.1 replaced results array structure to object  
				$result_type = gettype( $result );
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
			//grecaptcha.reset();
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

			/* $no_ssl_array = array(
			  'ssl' => array(
			  'verify_peer'		 => false,
			  'verify_peer_name'	 => false
			  )
			  );
			 */


			/** changes made based on Sam's reply 
			 *  https://wordpress.org/support/topic/validation-problems-8
			 *  Thank you Sam for your contribution
			 */
			$response = wp_remote_post(
			'https://www.google.com/recaptcha/api/siteverify', array(
				'method' => 'POST',
				'body'	 => array(
					'secret'	 => $secret_key,
					'response'	 => $recaptcha_value
				)
			)
			);

			$body_response	 = wp_remote_retrieve_body( $response );
			$reply_obj		 = json_decode( $body_response );


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
			
			global $wdm_recaptcha_settings_values;

			$unchecked_error_msg		 = $wdm_recaptcha_settings_values->get_option( 'general_wdm_custom_unchecked_error_msg' );
			
				
			$bot_error_msg		 = $wdm_recaptcha_settings_values->get_option( 'general_wdm_custom_bot_error_msg' );
			
			
			$default_unchecked_error_msg="No CAPTCHA reCAPTCHA is unchecked, Check to proceed";
			
			$default_bot_error_msg="It seems that you are a bot, Please try again.";
			
			if($unchecked_error_msg===""){
				$unchecked_message_to_be_shown=$default_unchecked_error_msg;
			}
			else{
				$unchecked_message_to_be_shown=$unchecked_error_msg;
			}
			
			if($default_bot_error_msg===""){
				$bot_message_to_be_shown=$default_bot_error_msg;
			}
			else{
				$bot_message_to_be_shown=$bot_error_msg;
			}
			return array_merge( $messages, array(
				'no_re_uncheked'	 => array(
					'description'	 => __( $unchecked_message_to_be_shown, "google-nocaptcha-recaptcha-locale" ),
					'default'		 => __( $unchecked_message_to_be_shown, "google-nocaptcha-recaptcha-locale" )
				),
				'no_re_bot_detected' => array(
					'description'	 => __( $bot_message_to_be_shown, "google-nocaptcha-recaptcha-locale" ),
					'default'		 => __( $bot_message_to_be_shown, "google-nocaptcha-recaptcha-locale" )
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

			$site_key		 = $wdm_recaptcha_settings_values->get_option( 'general_site_key' );
			$secret_key		 = $wdm_recaptcha_settings_values->get_option( 'general_secret_key' );
			$language_code	 = $wdm_recaptcha_settings_values->get_option( 'general_language' );
			
			if ( $language_code == "" ) {
				$language_code = "en";
			}
			
		
			if ( trim( $site_key ) != '' && trim( $secret_key ) != '' ) {
				$tag			 = new WPCF7_Shortcode( $tag );
				$class			 = wpcf7_form_controls_class( $tag->type );
				$name			 = $tag->name;
				$recaptcha_id	 = "wdm-nocapt-recapt-id-" . $name . $tag->get_id_option();
				if ( empty( $tag->name ) ) {
					return '';
				}
				$validation_error = wpcf7_get_validation_error( $tag->name );
				if ( $validation_error ) {
					$class .= 'wpcf7-not-valid';
				}
				$atts[ 'aria-invalid' ] = $validation_error ? 'true' : 'false';

				wp_enqueue_script( 'wdm_render_recaptcha', plugins_url( '/assets/js/render-recaptcha.js', dirname( dirname( __FILE__ ) ) ), array(), time(), true );

				wp_localize_script( 'wdm_render_recaptcha', 'wdm_recaptcha', array( 'sitekey' => $site_key,'validation_error'=>$validation_error ) );

				wp_register_style( 'wdm_captcha_css', plugins_url( '/assets/css/captcha-style.css', dirname( dirname( __FILE__ ) ) ) );
				wp_enqueue_style( 'wdm_captcha_css' );


				if ( is_ssl() ) {
					$protocol_to_be_used = 'https://';
				} else {
					$protocol_to_be_used = 'http://';
				}


				wp_register_script( 'google-nocaptcha-recaptcha-api', "{$protocol_to_be_used}www.google.com/recaptcha/api.js?render=explicit&hl=" . $language_code, array( 'wdm_render_recaptcha' ), '1.0.0', false );
				wp_enqueue_script( 'google-nocaptcha-recaptcha-api' );


				$atts = array();

				$atts[ 'class' ] = "wdm-nocapt-recapt " . $tag->get_class_option( $class. " wdm-recaptcha-resize" );
				
				$atts[ 'id' ] = $recaptcha_id;
				if ( $tag->has_option( 'theme:dark' ) ) {
					$atts[ 'theme' ] = "dark";
				} else {
					$atts[ 'theme' ] = "light";
				}
				
				if($tag->has_option( 'captcha_size' ))
				{
					$captcha_size_array=$tag->get_option( 'captcha_size' );
					$captcha_size=$captcha_size_array[0];
				}
				else{
					$captcha_size=1;
				}
							
				$atts[ 'tabindex' ]	 = $tag->get_option( 'tabindex', 'int', true );
				$atts[ 'type' ]		 = 'recaptcha';

				$atts = wpcf7_format_atts( $atts );

				$html = sprintf( '<div %1$s style="transform:scale('.$captcha_size.');transform-origin:0;-webkit-transform:scale('.$captcha_size.');transform:scale('.$captcha_size.');-webkit-transform-origin:0 0;transform-origin:0 0; 0"></div>', $atts );

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

