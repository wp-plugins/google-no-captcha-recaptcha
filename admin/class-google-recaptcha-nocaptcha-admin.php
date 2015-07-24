<?php

/**
 * Google No CAPTCHA reCAPTCHA by WisdmLabs.
 *
 * @package   Wdm_Google_Nocaptcha_Recaptcha_Admin
 * @author    WisdmLabs <support@wisdmlabs.com>
 * @license   GPL-2.0+
 * @link      http://wisdmlabs.com
 * @copyright 2014 WisdmLabs 
 *
 *
 * @package Wdm_Google_Nocaptcha_Recaptcha_Admin
 * @author  WisdmLabs <support@wisdmlabs.com>
 */
class Wdm_Google_Nocaptcha_Recaptcha_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Holds Current Section Description
	 * 
	 * @var string 
	 */
	public $section_description	 = '';
	public $option_name			 = WDM_RECAPTCHA_OPTION_NAME;
	protected $section_slug		 = '';
	public $settings			 = array();

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		$plugin				 = Wdm_Google_Nocaptcha_Recaptcha::get_instance();
		$this->plugin_slug	 = $plugin->get_plugin_slug();

		global $wdm_recaptcha_settings;
		$this->settings = $wdm_recaptcha_settings;

		// Load admin style sheet and JavaScript.
//		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
//		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		//Register settings, Add settings fields and settting section
		add_action( 'admin_init', array( $this, 'admin_init' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );
	}

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

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 */
		$this->plugin_screen_hook_suffix = add_options_page(
		__( 'Google No CAPTCHA reCAPTCHA Settings', $this->plugin_slug ), __( 'Google No CAPTCHA reCAPTCHA', $this->plugin_slug ), 'manage_options', $this->plugin_slug, array( $this, 'display_plugin_admin_page' )
		);
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
		array(
			'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
		), $links
		);
	}

	/**
	 * Register Settings, Add New fields and Add New Section
	 */
	public function admin_init() {

		
		register_setting( $this->option_name, $this->option_name );

		// Get the value of this setting
		$values_stored_in_database = maybe_unserialize( get_option( $this->option_name ) );

		$list_of_all_sections = $this->settings;

		foreach ( $list_of_all_sections as $single_section_slug => $single_section ) {

			$this->section_slug			 = $single_section_slug;
			$this->section_description	 = isset( $single_section[ 'description' ] ) ? $single_section[ 'description' ] : "";

			add_settings_section(
			$single_section_slug, $single_section[ 'name' ], array(
				$this, 'print_section_name' ), $this->plugin_slug
			);

			foreach ( $single_section[ 'fields' ] as $single_field_data_id => $single_field_data ) {

				$single_field_data[ 'field_name' ] = $single_field_data_id; //Pass field name 

				$array_of_data_types = array( 'text', 'password',
					'email', 'hidden', 'search', 'tel', 'url', 'date',
					'datetime', 'datetime-local', 'month', 'week',
					'time', 'number', 'range', 'color');

				$callback = 'print_field_of_' . $single_field_data[ 'type' ] . '_type';

				
				if ( in_array( $single_field_data[ 'type' ], $array_of_data_types ) ) {

					$callback = "print_one_line_field";
					
				}
				else if($single_field_data[ 'type' ]==="select"){
					$callback = "print_field_of_select_type";
					
				}
			

				// Get the field name from the $args array
				$single_field_data[ 'database_field_name' ]			 = $this->section_slug . '_' . $single_field_data_id;
				
				$single_field_data[ 'field' ]						 = $this->option_name . '[' . $single_field_data[ 'database_field_name' ] . ']';
				$single_field_data[ 'values_stored_in_database' ]	 = $values_stored_in_database;

				$single_field_data[ 'tip' ]		 = isset( $single_field_data[ 'tip' ] ) ? $single_field_data[ 'tip' ] : '';
				$single_field_data[ 'default' ]	 = isset( $single_field_data[ 'default' ] ) ? $single_field_data[ 'default' ] : '';

				
				add_settings_field(
				$single_field_data_id, $single_field_data[ 'name' ], array(
					$this, $callback ), $this->plugin_slug, $single_section_slug, $single_field_data
				);
			}
		}
	}

	public function validate_input_fields( $input ) {
		// Create our array for storing the validated options
		$output = array();

		$values_stored_in_database = maybe_unserialize( get_option( $this->option_name ) );

		// Loop through each of the incoming options
		foreach ( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if ( isset( $input[ $key ] ) ) {
				$output[ $key ] = esc_attr( strip_tags( stripslashes( $input[ $key ] ) ) );
			} // end if
		} // end foreach
		// Return the array processing any additional functions filtered by this action
		return $output;
	}

	/**
	 * Prints Section Name
	 * 
	 * @return null Does not return anything but displays section description
	 * @access public
	 */
	public function print_section_name() {
		echo $this->section_description;
	}

	/*
	 * Prints text fields
	 */
	public function print_one_line_field( $args ) {

		$field_settings = '';

		if ( isset( $args[ $args[ 'type' ] . '_settings' ] ) && !empty( $args[ $args[ 'type' ] . '_settings' ] ) && is_array( $args[ $args[ 'type' ] . '_settings' ] ) ) {
			foreach ( $args[ $args[ 'type' ] . '_settings' ] as $settings_key => $settings_value ) {

				$field_settings .= $settings_key . '="' . $settings_value . '" ';
			}
		}

		$database_field_name = $args[ 'database_field_name' ];

		if ( isset( $args[ 'values_stored_in_database' ][ $database_field_name ] ) && !empty( $args[ 'values_stored_in_database' ][ $database_field_name ] ) ) {
			$value = $args[ 'values_stored_in_database' ][ $database_field_name ];
		} else {
			$value = $args[ 'default' ];
		}

		$field_html = sprintf( '<input type="%s" name="%s" class="wdm_textbox" id="%s" value="%s" %s/><label for="%s"> %s </label>', $args[ 'type' ], $args[ 'field' ], $args[ 'field' ], $value, $field_settings, $args[ 'field' ], $args[ 'tip' ] );

		echo apply_filters( $database_field_name . '_field', $field_html, $args );
	}

	/*
	 * Prints dropdown fields
	 */
	public function print_field_of_select_type( $args ) {

		
		$field_settings = '';

		if ( isset( $args[ $args[ 'type' ] . '_settings' ] ) && !empty( $args[ $args[ 'type' ] . '_settings' ] ) && is_array( $args[ $args[ 'type' ] . '_settings' ] ) ) {
			foreach ( $args[ $args[ 'type' ] . '_settings' ] as $settings_key => $settings_value ) {

				$field_settings .= $settings_key . '="' . $settings_value . '" ';
			}
		}

		$database_field_name = $args[ 'database_field_name' ];

		if ( isset( $args[ 'values_stored_in_database' ][ $database_field_name ] ) && !empty( $args[ 'values_stored_in_database' ][ $database_field_name ] ) ) {
			$value = $args[ 'values_stored_in_database' ][ $database_field_name ];
		} else {
			$value = $args[ 'default' ];
		}

		$field_html = sprintf( '<select name="%s" id="%s" %s>', $args[ 'field' ], $args[ 'field' ], $field_settings );

		if ( isset( $args[ 'option_values' ] ) && is_array( $args[ 'option_values' ] ) ) {
			foreach ( $args[ 'option_values' ] as $single_option_key => $single_option_value ) {
				$is_selected = selected( $value, $single_option_key, false );
				$field_html .= sprintf( '<option value="%s" %s>%s</option>', $single_option_key, $is_selected, trim( $single_option_value ) );
			}
		}
		$field_html .= sprintf( '</select><label for="%s"> %s </label>', $args[ 'field' ], $args[ 'tip' ] );

		echo apply_filters( $database_field_name . '_field', $field_html, $args );
	}

	/*
	 * Prints Multiselect fields
	 */
	public function print_field_of_multi_select_type( $args ) {

		$multi_select_settings = '';
		if ( isset( $args[ 'multi_select_settings' ] ) && !empty( $args[ 'multi_select_settings' ] ) && is_array( $args[ 'multi_select_settings' ] ) ) {
			foreach ( $args[ 'multi_select_settings' ] as $settings_key => $settings_value ) {

				$multi_select_settings .= $settings_key . '="' . $settings_value . '" ';
			}
		}


		$database_field_name = $args[ 'database_field_name' ];

		$field_html = sprintf( '<select multiple name="%s" id="%s" %s>', $args[ 'field' ] . '[]', $args[ 'field' ], $multi_select_settings );

		$value = array();

		if ( isset( $args[ 'values_stored_in_database' ][ $database_field_name ] ) && !empty( $args[ 'values_stored_in_database' ][ $database_field_name ] ) ) {
			$value = $args[ 'values_stored_in_database' ][ $database_field_name ];
		} else {
			$values_array = explode( ',', $args[ 'default' ] );
			foreach ( $values_array as $single_value ) {
				$value[] = trim( $single_value );
			}
		}

		foreach ( $args[ 'option_values' ] as $option_value_id => $single_option_value ) {

			$check_if_selected = in_array( $option_value_id, $value ) ? 'selected="selected"' : '';

			$field_html .= sprintf(
			'<option value="%s" %s>%s</option>', $option_value_id, $check_if_selected, $single_option_value
			);
		}

		$field_html .= sprintf( '</select><label for="%s"> %s </label>', $args[ 'field' ], $args[ 'tip' ] );

		echo apply_filters( $database_field_name . '_field', $field_html, $args );
	}

	/*
	 * Prints Textarea on the settings page
	 */

	public function print_field_of_textarea_type( $args ) {

		$database_field_name = $args[ 'database_field_name' ];

		if ( isset( $args[ 'values_stored_in_database' ][ $database_field_name ] ) && !empty( $args[ 'values_stored_in_database' ][ $database_field_name ] ) ) {
			$value = $args[ 'values_stored_in_database' ][ $database_field_name ];
		} else {
			$value = $args[ 'default' ];
		}

		$show_wp_editor = isset( $args[ 'wp_editor' ] ) ? (bool) $args[ 'wp_editor' ] : false;

		if ( $show_wp_editor ) {
			// Start buffering
			ob_start();

			$settings = array(
				'textarea_name' => $args[ 'field' ],
			);

			$settings = isset( $args[ 'wp_editor_settings' ] ) ? array_merge( $settings, $args[ 'wp_editor_settings' ] ) : $settings;

			wp_editor( $value, $args[ 'database_field_name' ], $settings );

			// Get value of buffering so far
			$field_html = ob_get_contents();

			// Stop buffering
			ob_end_clean();
		} else {

			$textarea_settings = '';

			if ( isset( $args[ 'textarea_settings' ] ) && !empty( $args[ 'textarea_settings' ] ) && is_array( $args[ 'textarea_settings' ] ) ) {
				foreach ( $args[ 'textarea_settings' ] as $settings_key => $settings_value ) {

					$textarea_settings .= $settings_key . '="' . $settings_value . '" ';
				}
			} else {
				$textarea_settings = ' rows="4" cols="50"';
			}

			$field_html = sprintf( '<textarea  style="vertical-align:middle" name="%s" id="%s" %s>%s</textarea>', $args[ 'field' ], $args[ 'field' ], $textarea_settings, $value );
		}

		$label		 = sprintf( '<label for="%s"> %s </label>', $args[ 'field' ], $args[ 'tip' ] );
		$field_html	 = $field_html . $label;

		echo apply_filters( $database_field_name . '_field', $field_html, $args );
	}

	/*
	 * Prints Radio Buttons
	 */

	public function print_field_of_radio_type( $args ) {

		$radio_settings = '';

		if ( isset( $args[ 'radio_settings' ] ) && !empty( $args[ 'radio_settings' ] ) && is_array( $args[ 'radio_settings' ] ) ) {
			foreach ( $args[ 'radio_settings' ] as $settings_key => $settings_value ) {

				$radio_settings .= $settings_key . '="' . $settings_value . '" ';
			}
		}

		$database_field_name = $args[ 'database_field_name' ];

		$field_html = '';

		if ( isset( $args[ 'values_stored_in_database' ][ $database_field_name ] ) && !empty( $args[ 'values_stored_in_database' ][ $database_field_name ] ) ) {
			$value = $args[ 'values_stored_in_database' ][ $database_field_name ];
		} else {
			$value = $args[ 'default' ];
		}


		foreach ( $args[ 'radio_values' ] as $radio_value_id => $single_radio_value ) {

			$check_if_selected = checked( $value, $radio_value_id, false );

			$field_html .= sprintf(
			'<input type="%s" name="%s" id="%s" value="%s" %s %s/><label for="%s"> %s </label><br />', $args[ 'type' ], $args[ 'field' ], $args[ 'field' ] . '[' . $radio_value_id . ']', $radio_value_id, $radio_settings, $check_if_selected, $args[ 'field' ] . '[' . $radio_value_id . ']', $single_radio_value
			);
		}

		echo apply_filters( $database_field_name . '_field', $field_html, $args );
	}

	/*
	 * Prints Checkboxes on settings page
	 */

	public function print_field_of_checkbox_type( $args ) {

		$checkbox_settings = '';

		if ( isset( $args[ 'checkbox_settings' ] ) && !empty( $args[ 'checkbox_settings' ] ) && is_array( $args[ 'checkbox_settings' ] ) ) {
			foreach ( $args[ 'checkbox_settings' ] as $settings_key => $settings_value ) {

				$checkbox_settings .= $settings_key . '="' . $settings_value . '" ';
			}
		}


		$database_field_name = $args[ 'database_field_name' ];

		$field_html = '';

		$value = array();

		if ( isset( $args[ 'values_stored_in_database' ][ $database_field_name ] ) && !empty( $args[ 'values_stored_in_database' ][ $database_field_name ] ) ) {
			$value = $args[ 'values_stored_in_database' ][ $database_field_name ];
		} else {
			$values_array = explode( ',', $args[ 'default' ] );
			foreach ( $values_array as $single_value ) {
				$value[ trim( $single_value ) ] = $args[ 'checkbox_values' ][ trim( $single_value ) ];
			}
		}

		$value_ids = array_keys( $value );


		foreach ( $args[ 'checkbox_values' ] as $checkbox_value_id => $single_checkbox_value ) {

			$check_if_selected = in_array( $checkbox_value_id, $value_ids ) ? 'checked="checked"' : '';

			$field_html .= sprintf(
			'<input type="%s" name="%s" id="%s" value="%s" %s %s /><label for="%s"> %s </label><br />', $args[ 'type' ], $args[ 'field' ] . '[' . $checkbox_value_id . ']', $args[ 'field' ] . '[' . $checkbox_value_id . ']', $single_checkbox_value, $check_if_selected, $checkbox_settings, $args[ 'field' ] . '[' . $checkbox_value_id . ']', $single_checkbox_value
			);
		}

		echo apply_filters( $database_field_name . '_field', $field_html, $args );
	}

}
